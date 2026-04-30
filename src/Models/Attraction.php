<?php
/**
 * Attraction Model
 * Handles points of interest and attractions
 */

namespace App\Models;

class Attraction extends Model {
    protected string $table = 'attractions';
    
    /**
     * Get popular attractions based on rating and reviews
     */
    public function getPopular(int $limit = 6): array {
        $sql = "SELECT a.*, r.name_ru as region_name, r.slug as region_slug,
                (SELECT COUNT(*) FROM audio_guides WHERE attraction_id = a.id) as audio_guides_count
                FROM {$this->table} a 
                LEFT JOIN regions r ON a.region_id = r.id 
                WHERE a.rating > 0
                ORDER BY a.rating DESC, created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get attractions by type
     */
    public function getByType(string $type, int $limit = 12): array {
        $sql = "SELECT a.*, r.name_ru as region_name 
                FROM {$this->table} a 
                LEFT JOIN regions r ON a.region_id = r.id 
                WHERE a.type = :type 
                ORDER BY a.rating DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get attractions within a geographic radius (for map features)
     */
    public function getNearby(float $lat, float $lng, float $radiusKm = 50, int $limit = 20): array {
        // Using Haversine formula for distance calculation
        $sql = "SELECT a.*, r.name_ru as region_name,
                (6371 * acos(cos(radians(:lat)) * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(:lng)) 
                + sin(radians(:lat)) * sin(radians(latitude)))) AS distance
                FROM {$this->table} a 
                LEFT JOIN regions r ON a.region_id = r.id 
                HAVING distance < :radius
                ORDER BY distance ASC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':lat', $lat, \PDO::PARAM_STR);
        $stmt->bindValue(':lng', $lng, \PDO::PARAM_STR);
        $stmt->bindValue(':radius', $radiusKm, \PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get attraction by slug
     */
    public function findBySlug(string $slug): ?array {
        $sql = "SELECT a.*, r.name_ru as region_name, r.name_en as region_name_en, r.name_kg as region_name_kg
                FROM {$this->table} a 
                LEFT JOIN regions r ON a.region_id = r.id 
                WHERE a.slug = :slug 
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $attraction = $stmt->fetch();
        
        if (!$attraction) {
            return null;
        }
        
        // Get audio guides for this attraction
        $attraction['audio_guides'] = $this->getAudioGuides($attraction['id']);
        
        return $attraction;
    }
    
    /**
     * Get audio guides for an attraction
     */
    public function getAudioGuides(int $attractionId): array {
        $sql = "SELECT * FROM audio_guides 
                WHERE attraction_id = :attraction_id 
                ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['attraction_id' => $attractionId]);
        
        return $stmt->fetchAll();
    }
}
