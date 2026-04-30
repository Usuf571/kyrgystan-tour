<?php
/**
 * Helper Functions
 * Common utility functions used throughout the application
 */

/**
 * Generate a URL-friendly slug from a string
 */
function slugify(string $text): string {
    // Replace non-letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
    // Transliterate
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    
    // Trim
    $text = trim($text, '-');
    
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    
    // Lowercase
    $text = strtolower($text);
    
    return empty($text) ? 'n-a' : $text;
}

/**
 * Format price with currency
 */
function formatPrice(float $amount, string $currency = 'USD'): string {
    $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'KGS' => 'сом',
        'GBP' => '£',
    ];
    
    $symbol = $symbols[$currency] ?? $currency;
    
    if ($currency === 'KGS') {
        return number_format($amount, 0, ',', ' ') . ' ' . $symbol;
    }
    
    return $symbol . number_format($amount, 2);
}

/**
 * Format date based on locale
 */
function formatDate(string $date, string $format = 'long', string $locale = 'ru'): string {
    $timestamp = strtotime($date);
    
    $months_ru = [
        1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
        'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'
    ];
    
    $months_en = [
        1 => 'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    
    $month = (int) date('n', $timestamp);
    $day = date('j', $timestamp);
    $year = date('Y', $timestamp);
    
    if ($locale === 'ru') {
        if ($format === 'short') {
            return date('d.m.Y', $timestamp);
        }
        return "$day {$months_ru[$month]} $year";
    } elseif ($locale === 'kg') {
        return date('d.m.Y', $timestamp);
    } else {
        if ($format === 'short') {
            return date('m/d/Y', $timestamp);
        }
        return "{$months_en[$month]} $day, $year";
    }
}

/**
 * Get asset URL
 */
function asset(string $path): string {
    $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/');
    return $baseUrl . '/assets/' . ltrim($path, '/');
}

/**
 * Get upload URL
 */
function uploadUrl(string $path): string {
    $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/');
    return $baseUrl . '/uploads/' . ltrim($path, '/');
}

/**
 * Sanitize output for HTML
 */
function e(string $string): string {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate CSRF input field
 */
function csrfField(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
}

/**
 * Verify CSRF token
 */
function verifyCsrfToken(string $token): bool {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if current route matches
 */
function isActiveRoute(string $route): bool {
    $currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentUri === $route || strpos($currentUri, $route . '/') === 0;
}

/**
 * Pagination helper
 */
function renderPagination(array $pagination, string $baseUrl = ''): string {
    if ($pagination['last_page'] <= 1) {
        return '';
    }
    
    $html = '<nav class="pagination"><ul class="pagination-list">';
    
    // Previous
    if ($pagination['current_page'] > 1) {
        $prevPage = $pagination['current_page'] - 1;
        $html .= '<li><a href="' . $baseUrl . '?page=' . $prevPage . '" class="pagination-link">&laquo; Prev</a></li>';
    }
    
    // Pages
    for ($i = 1; $i <= $pagination['last_page']; $i++) {
        $active = $i === $pagination['current_page'] ? 'active' : '';
        $html .= '<li><a href="' . $baseUrl . '?page=' . $i . '" class="pagination-link ' . $active . '">' . $i . '</a></li>';
    }
    
    // Next
    if ($pagination['current_page'] < $pagination['last_page']) {
        $nextPage = $pagination['current_page'] + 1;
        $html .= '<li><a href="' . $baseUrl . '?page=' . $nextPage . '" class="pagination-link">Next &raquo;</a></li>';
    }
    
    $html .= '</ul></nav>';
    
    return $html;
}

/**
 * Calculate tour price based on participants
 */
function calculateTourPrice(float $basePrice, int $participants): float {
    // Example pricing logic: base price per person
    // Could be extended with discounts for groups
    $discount = 0;
    
    if ($participants >= 10) {
        $discount = 0.15; // 15% discount for 10+ people
    } elseif ($participants >= 5) {
        $discount = 0.10; // 10% discount for 5-9 people
    } elseif ($participants >= 3) {
        $discount = 0.05; // 5% discount for 3-4 people
    }
    
    return $basePrice * $participants * (1 - $discount);
}

/**
 * Get file extension
 */
function getFileExtension(string $filename): string {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Generate random string
 */
function randomString(int $length = 32): string {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Time ago helper
 */
function timeAgo(string $datetime): string {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return "$mins minute" . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return "$hours hour" . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return "$days day" . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('M j, Y', $timestamp);
    }
}

/**
 * Truncate text with ellipsis
 */
function truncate(string $text, int $length = 100): string {
    if (strlen($text) <= $length) {
        return $text;
    }
    return rtrim(substr($text, 0, $length)) . '...';
}

/**
 * Debug helper (only in development)
 */
function dd(...$vars): void {
    if ($_ENV['APP_DEBUG'] ?? false) {
        echo '<pre style="background: #f5f5f5; padding: 20px; margin: 20px; border-radius: 5px;">';
        foreach ($vars as $var) {
            var_dump($var);
            echo "\n";
        }
        echo '</pre>';
        die();
    }
}
