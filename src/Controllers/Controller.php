<?php
/**
 * Base Controller Class
 * Provides common functionality for all controllers
 */

namespace App\Controllers;

abstract class Controller {
    protected array $data = [];
    protected string $currentLocale = 'ru';
    
    public function __construct() {
        // Set current locale from session or default
        $this->currentLocale = $_SESSION['locale'] ?? 'ru';
        
        // Share common data with all views
        $this->shareCommonData();
    }
    
    /**
     * Share common data to all views
     */
    protected function shareCommonData(): void {
        $this->data['site_title'] = 'Discover Kyrgyzstan';
        $this->data['current_locale'] = $this->currentLocale;
        $this->data['locales'] = ['ru' => 'Русский', 'en' => 'English', 'kg' => 'Кыргызча'];
        $this->data['user'] = $_SESSION['user'] ?? null;
        $this->data['csrf_token'] = $this->generateCsrfToken();
    }
    
    /**
     * Render a view template
     */
    protected function render(string $view, array $data = [], ?string $layout = 'main'): void {
        $data = array_merge($this->data, $data);
        
        if ($layout) {
            extract($data);
            require TEMPLATE_PATH . "/layouts/{$layout}.php";
        } else {
            extract($data);
            require TEMPLATE_PATH . "/pages/{$view}.php";
        }
    }
    
    /**
     * Render partial view
     */
    protected function partial(string $partial, array $data = []): void {
        extract($data);
        require TEMPLATE_PATH . "/partials/{$partial}.php";
    }
    
    /**
     * Redirect to a URL
     */
    protected function redirect(string $url): void {
        header("Location: $url");
        exit;
    }
    
    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Generate CSRF token
     */
    protected function generateCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verify CSRF token
     */
    protected function verifyCsrfToken(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated(): bool {
        return isset($_SESSION['user']);
    }
    
    /**
     * Require authentication
     */
    protected function requireAuth(): void {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
    
    /**
     * Check if user is admin
     */
    protected function isAdmin(): bool {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
    
    /**
     * Require admin access
     */
    protected function requireAdmin(): void {
        if (!$this->isAdmin()) {
            http_response_code(403);
            die('Access denied');
        }
    }
    
    /**
     * Sanitize input
     */
    protected function sanitize(string $input): string {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Get POST data
     */
    protected function post(string $key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get GET data
     */
    protected function get(string $key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Flash message
     */
    protected function flash(string $type, string $message): void {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    /**
     * Get and clear flash message
     */
    protected function getFlash(): ?array {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }
}
