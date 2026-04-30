<?php
/**
 * Region Model
 * Handles region-related database operations
 */

namespace App\Models;

class Region extends Model {
    protected string $table = 'regions';
    
    /**
     * Get region by slug with attractions count
     */
    public function findBySlug(string $slug): ?array {
        $sql = "SELECT r.*,
                (SELECT COUNT(*) FROM attractions WHERE region_id = r.id) as attractions_count,
                (SELECT COUNT(*) FROM tour_regions WHERE region_id = r.id) as tours_count
                FROM {$this->table} r 
                WHERE r.slug = :slug AND r.is_active = 1 
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $region = $stmt->fetch();
        
        if (!$region) {
            return null;
        }
        
        // Load related data
        $region['attractions'] = $this->getRegionAttractions($region['id']);
        $region['tours'] = $this->getRegionTours($region['id']);
        
        return $region;
    }
    
    /**
     * Get attractions for a region
     */
    public function getRegionAttractions(int $regionId, int $limit = 6): array {
        $sql = "SELECT * FROM attractions 
                WHERE region_id = :region_id 
                ORDER BY rating DESC, created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':region_id', $regionId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get tours that visit this region
     */
    public function getRegionTours(int $regionId, int $limit = 6): array {
        $sql = "SELECT t.*, 
                (SELECT image_path FROM tour_images WHERE tour_id = t.id AND is_main = 1 LIMIT 1) as main_image
                FROM tours t 
                JOIN tour_regions tr ON t.id = tr.tour_id 
                WHERE tr.region_id = :region_id 
                AND t.is_active = 1 
                ORDER BY t.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':region_id', $regionId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
