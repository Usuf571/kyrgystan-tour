<?php
/**
 * Booking Model
 * Handles tour bookings and reservations
 */

namespace App\Models;

class Booking extends Model {
    protected string $table = 'bookings';
    
    /**
     * Create a new booking
     */
    public function createBooking(array $data): int {
        $bookingData = [
            'tour_id' => $data['tour_id'],
            'user_id' => $data['user_id'] ?? null,
            'guest_name' => $data['guest_name'],
            'guest_email' => $data['guest_email'],
            'guest_phone' => $data['guest_phone'],
            'travel_date' => $data['travel_date'],
            'participants_count' => $data['participants_count'],
            'total_price' => $data['total_price'],
            'status' => 'pending',
            'special_requests' => $data['special_requests'] ?? null,
        ];
        
        return $this->create($bookingData);
    }
    
    /**
     * Get bookings for a specific tour
     */
    public function getByTour(int $tourId, string $status = null): array {
        $where = ['tour_id' => $tourId];
        if ($status) {
            $where['status'] = $status;
        }
        
        return $this->all($where, 'created_at DESC');
    }
    
    /**
     * Get user bookings
     */
    public function getByUser(int $userId): array {
        $sql = "SELECT b.*, t.title_ru as tour_title, t.title_en as tour_title_en, 
                (SELECT image_path FROM tour_images WHERE tour_id = b.tour_id AND is_main = 1 LIMIT 1) as tour_image
                FROM {$this->table} b 
                JOIN tours t ON b.tour_id = t.id 
                WHERE b.user_id = :user_id 
                ORDER BY b.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        
        return $stmt->fetchAll();
    }
    
    /**
     * Update booking status
     */
    public function updateStatus(int $bookingId, string $status): bool {
        $allowedStatuses = ['pending', 'confirmed', 'paid', 'cancelled', 'completed'];
        
        if (!in_array($status, $allowedStatuses)) {
            throw new \InvalidArgumentException("Invalid status: $status");
        }
        
        return $this->update($bookingId, ['status' => $status]);
    }
    
    /**
     * Get booking with tour details
     */
    public function findWithDetails(int $id): ?array {
        $sql = "SELECT b.*, t.title_ru as tour_title, t.title_en as tour_title_en, 
                t.price_from as tour_price, t.duration_days,
                u.name as user_name, u.email as user_email, u.phone as user_phone
                FROM {$this->table} b 
                JOIN tours t ON b.tour_id = t.id 
                LEFT JOIN users u ON b.user_id = u.id 
                WHERE b.id = :id 
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch() ?: null;
    }
    
    /**
     * Get statistics for dashboard
     */
    public function getStatistics(): array {
        $sql = "SELECT 
                COUNT(*) as total_bookings,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed_count,
                SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_count,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_count,
                SUM(CASE WHEN status = 'paid' THEN total_price ELSE 0 END) as total_revenue
                FROM {$this->table}";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetch();
    }
    
    /**
     * Get recent bookings for admin dashboard
     */
    public function getRecent(int $limit = 10): array {
        $sql = "SELECT b.*, t.title_ru as tour_title, 
                b.guest_name as customer_name
                FROM {$this->table} b 
                JOIN tours t ON b.tour_id = t.id 
                ORDER BY b.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Check availability for a tour on a specific date
     */
    public function checkAvailability(int $tourId, string $date, int $participants): array {
        // Get max group size for the tour
        $tourSql = "SELECT max_group_size FROM tours WHERE id = :id";
        $stmt = $this->db->prepare($tourSql);
        $stmt->execute(['id' => $tourId]);
        $tour = $stmt->fetch();
        
        if (!$tour) {
            return ['available' => false, 'message' => 'Tour not found'];
        }
        
        $maxGroupSize = (int) $tour['max_group_size'];
        
        // Get existing bookings for this date
        $bookingSql = "SELECT SUM(participants_count) as booked_spots 
                      FROM {$this->table} 
                      WHERE tour_id = :tour_id 
                      AND travel_date = :date 
                      AND status IN ('pending', 'confirmed', 'paid')";
        
        $stmt = $this->db->prepare($bookingSql);
        $stmt->execute([
            'tour_id' => $tourId,
            'date' => $date
        ]);
        
        $result = $stmt->fetch();
        $bookedSpots = (int) ($result['booked_spots'] ?? 0);
        $availableSpots = $maxGroupSize - $bookedSpots;
        
        return [
            'available' => $availableSpots >= $participants,
            'available_spots' => $availableSpots,
            'max_group_size' => $maxGroupSize,
            'booked_spots' => $bookedSpots,
        ];
    }
}
