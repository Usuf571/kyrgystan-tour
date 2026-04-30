<?php
/**
 * Database Connection Class
 * Singleton pattern for PDO connection
 */

namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static ?Database $instance = null;
    private ?PDO $connection = null;
    private array $config;
    
    private function __construct() {
        $this->config = require __DIR__ . '/config.php';
        $this->connect();
    }
    
    /**
     * Get singleton instance
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Get PDO connection
     */
    public function getConnection(): PDO {
        return $this->connection;
    }
    
    /**
     * Establish database connection
     */
    private function connect(): void {
        $db = $this->config['database'];
        
        $dsn = sprintf(
            "%s:host=%s;port=%s;dbname=%s;charset=%s",
            $db['driver'],
            $db['host'],
            $db['port'],
            $db['database'],
            $db['charset']
        );
        
        try {
            $this->connection = new PDO(
                $dsn,
                $db['username'],
                $db['password'],
                $db['options']
            );
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            if ($this->config['app']['debug']) {
                die("Database connection failed. Please check your configuration.");
            }
            die("Service temporarily unavailable.");
        }
    }
    
    /**
     * Prevent cloning
     */
    private function __clone() {}
    
    /**
     * Prevent unserialization
     */
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}
