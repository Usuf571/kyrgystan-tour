<?php
/**
 * Base Model Class
 * Provides common database operations for all models
 */

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOStatement;

abstract class Model {
    protected PDO $db;
    protected string $table;
    protected string $primaryKey = 'id';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Find record by ID
     */
    public function find(int $id): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    /**
     * Get all records with optional conditions
     */
    public function all(array $conditions = [], string $orderBy = null, int $limit = null): array {
        $sql = "SELECT * FROM {$this->table}";
        
        $where = [];
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll();
    }
    
    /**
     * Insert new record
     */
    public function create(array $data): int {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        
        return (int) $this->db->lastInsertId();
    }
    
    /**
     * Update record by ID
     */
    public function update(int $id, array $data): bool {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE {$this->primaryKey} = :id";
        $data['id'] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    /**
     * Delete record by ID
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Count records with optional conditions
     */
    public function count(array $conditions = []): int {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        
        $where = [];
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($conditions);
        $result = $stmt->fetch();
        
        return (int) $result['total'];
    }
    
    /**
     * Paginated query
     */
    public function paginate(int $page = 1, int $perPage = 12, array $conditions = [], string $orderBy = null): array {
        $offset = ($page - 1) * $perPage;
        
        // Build where clause
        $where = [];
        $params = [];
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $where[] = "$key = :$key";
                $params[$key] = $value;
            }
        }
        
        $whereClause = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";
        
        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} $whereClause";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetch()['total'];
        
        // Get records
        $sql = "SELECT * FROM {$this->table} $whereClause";
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        $sql .= " LIMIT $perPage OFFSET $offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $records = $stmt->fetchAll();
        
        return [
            'data' => $records,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total),
        ];
    }
    
    /**
     * Custom query with prepared statements
     */
    protected function query(string $sql, array $params = []): PDOStatement {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
