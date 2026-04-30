<?php
/**
 * Tour Model
 * Handles all tour-related database operations
 */

namespace App\Models;

class Tour extends Model {
    protected string $table = 'tours';
    
    /**
     * Get featured tours
     */
    public function getFeatured(int $limit = 6): array {
        $sql = "SELECT t.*, 
                (SELECT image_path FROM tour_images WHERE tour_id = t.id AND is_main = 1 LIMIT 1) as main_image
                FROM {$this->table} t 
                WHERE t.is_active = 1 AND t.is_featured = 1 
                ORDER BY t.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Search and filter tours with advanced options
     */
    public function search(array $filters = [], int $page = 1, int $perPage = 12): array {
        $where = ['t.is_active = 1'];
        $params = [];
        
        // Category filter
        if (!empty($filters['category'])) {
            $where[] = "t.category = :category";
            $params['category'] = $filters['category'];
        }
        
        // Difficulty filter
        if (!empty($filters['difficulty'])) {
            $where[] = "t.difficulty = :difficulty";
            $params['difficulty'] = $filters['difficulty'];
        }
        
        // Price range
        if (!empty($filters['min_price'])) {
            $where[] = "t.price_from >= :min_price";
            $params['min_price'] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $where[] = "t.price_from <= :max_price";
            $params['max_price'] = $filters['max_price'];
        }
        
        // Duration range
        if (!empty($filters['min_duration'])) {
            $where[] = "t.duration_days >= :min_duration";
            $params['min_duration'] = $filters['min_duration'];
        }
        
        if (!empty($filters['max_duration'])) {
            $where[] = "t.duration_days <= :max_duration";
            $params['max_duration'] = $filters['max_duration'];
        }
        
        // Region filter (many-to-many)
        if (!empty($filters['region_id'])) {
            $where[] = "tr.region_id = :region_id";
            $params['region_id'] = $filters['region_id'];
        }
        
        // Search by keyword
        if (!empty($filters['search'])) {
            $where[] = "(t.title_ru LIKE :search OR t.title_en LIKE :search OR t.title_kg LIKE :search OR t.full_description_ru LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        // Build join for regions if needed
        $join = '';
        if (!empty($filters['region_id'])) {
            $join = "LEFT JOIN tour_regions tr ON t.id = tr.tour_id";
        }
        
        // Get total count
        $countSql = "SELECT COUNT(DISTINCT t.id) as total FROM {$this->table} t $join WHERE $whereClause";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetch()['total'];
        
        // Pagination
        $offset = ($page - 1) * $perPage;
        
        // Ordering
        $orderBy = 't.created_at DESC';
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $orderBy = 't.price_from ASC';
                    break;
                case 'price_desc':
                    $orderBy = 't.price_from DESC';
                    break;
                case 'duration_asc':
                    $orderBy = 't.duration_days ASC';
                    break;
                case 'duration_desc':
                    $orderBy = 't.duration_days DESC';
                    break;
                case 'popular':
                    $orderBy = 't.views_count DESC';
                    break;
            }
        }
        
        // Get records
        $sql = "SELECT DISTINCT t.*, 
                (SELECT image_path FROM tour_images WHERE tour_id = t.id AND is_main = 1 LIMIT 1) as main_image
                FROM {$this->table} t 
                $join 
                WHERE $whereClause 
                ORDER BY $orderBy 
                LIMIT $perPage OFFSET $offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $tours = $stmt->fetchAll();
        
        // Get regions for each tour
        foreach ($tours as &$tour) {
            $tour['regions'] = $this->getTourRegions($tour['id']);
            $tour['images'] = $this->getTourImages($tour['id']);
        }
        
        return [
            'data' => $tours,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
        ];
    }
    
    /**
     * Get tour by slug with full details
     */
    public function findBySlug(string $slug): ?array {
        $sql = "SELECT t.*, 
                (SELECT GROUP_CONCAT(r.name_ru SEPARATOR ', ') 
                 FROM tour_regions tr 
                 JOIN regions r ON tr.region_id = r.id 
                 WHERE tr.tour_id = t.id) as regions_names
                FROM {$this->table} t 
                WHERE t.slug = :slug AND t.is_active = 1 
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $tour = $stmt->fetch();
        
        if (!$tour) {
            return null;
        }
        
        // Increment views
        $this->incrementViews($tour['id']);
        
        // Load related data
        $tour['regions'] = $this->getTourRegions($tour['id']);
        $tour['images'] = $this->getTourImages($tour['id']);
        $tour['reviews'] = $this->getTourReviews($tour['id']);
        $tour['related'] = $this->getRelatedTours($tour['id'], $tour['category'], 4);
        
        return $tour;
    }
    
    /**
     * Get regions for a tour
     */
    public function getTourRegions(int $tourId): array {
        $sql = "SELECT r.* FROM regions r 
                JOIN tour_regions tr ON r.id = tr.region_id 
                WHERE tr.tour_id = :tour_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get images for a tour
     */
    public function getTourImages(int $tourId): array {
        $sql = "SELECT * FROM tour_images WHERE tour_id = :tour_id ORDER BY sort_order ASC, is_main DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tour_id' => $tourId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get reviews for a tour
     */
    public function getTourReviews(int $tourId, int $limit = 5): array {
        $sql = "SELECT r.*, u.avatar as user_avatar 
                FROM reviews r 
                LEFT JOIN users u ON r.user_id = u.id 
                WHERE r.tour_id = :tour_id AND r.is_approved = 1 
                ORDER BY r.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tour_id', $tourId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get related tours by category
     */
    public function getRelatedTours(int $excludeId, string $category, int $limit = 4): array {
        $sql = "SELECT t.*, 
                (SELECT image_path FROM tour_images WHERE tour_id = t.id AND is_main = 1 LIMIT 1) as main_image
                FROM {$this->table} t 
                WHERE t.id != :exclude_id 
                AND t.category = :category 
                AND t.is_active = 1 
                ORDER BY RAND() 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':exclude_id', $excludeId, \PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, \PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Increment tour view count
     */
    public function incrementViews(int $tourId): void {
        $sql = "UPDATE {$this->table} SET views_count = views_count + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $tourId]);
    }
    
    /**
     * Get all categories with counts
     */
    public function getCategories(): array {
        $sql = "SELECT category, COUNT(*) as count 
                FROM {$this->table} 
                WHERE is_active = 1 
                GROUP BY category 
                ORDER BY count DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
