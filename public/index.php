<?php
/**
 * Kyrgyzstan Tourism Platform - Main Entry Point
 * 
 * @version 1.0.0
 * @author Premium Development Team
 */

// Enable error reporting for development (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define base paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('TEMPLATE_PATH', ROOT_PATH . '/templates');
define('STORAGE_PATH', ROOT_PATH . '/storage');
define('SRC_PATH', ROOT_PATH . '/src');

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = SRC_PATH . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Load configuration
require_once SRC_PATH . '/Config/config.php';
require_once SRC_PATH . '/Helpers/functions.php';

// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// Simple routing
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route mapping
$routes = [
    'GET' => [
        '/' => 'HomeController@index',
        '/tours' => 'TourController@index',
        '/tours/[:slug]' => 'TourController@show',
        '/regions' => 'RegionController@index',
        '/regions/[:slug]' => 'RegionController@show',
        '/attractions' => 'AttractionController@index',
        '/audio-guide' => 'AudioController@index',
        '/gallery' => 'GalleryController@index',
        '/blog' => 'BlogController@index',
        '/blog/[:slug]' => 'BlogController@show',
        '/contact' => 'ContactController@index',
        '/favorites' => 'UserController@favorites',
        '/login' => 'AuthController@login',
        '/register' => 'AuthController@register',
        '/logout' => 'AuthController@logout',
        '/api/tours' => 'Api\TourController@index',
        '/api/weather' => 'Api\WeatherController@index',
    ],
    'POST' => [
        '/booking/create' => 'BookingController@store',
        '/review/create' => 'ReviewController@store',
        '/contact/send' => 'ContactController@send',
        '/login' => 'AuthController@authenticate',
        '/register' => 'AuthController@store',
        '/favorites/toggle' => 'UserController@toggleFavorite',
    ],
];

// Admin routes
$adminRoutes = [
    'GET' => [
        '/admin' => 'Admin\DashboardController@index',
        '/admin/tours' => 'Admin\TourController@index',
        '/admin/tours/create' => 'Admin\TourController@create',
        '/admin/tours/[:id]/edit' => 'Admin\TourController@edit',
        '/admin/bookings' => 'Admin\BookingController@index',
        '/admin/users' => 'Admin\UserController@index',
        '/admin/regions' => 'Admin\RegionController@index',
        '/admin/attractions' => 'Admin\AttractionController@index',
        '/admin/audio' => 'Admin\AudioController@index',
        '/admin/settings' => 'Admin\SettingController@index',
    ],
    'POST' => [
        '/admin/tours/create' => 'Admin\TourController@store',
        '/admin/tours/[:id]/update' => 'Admin\TourController@update',
        '/admin/tours/[:id]/delete' => 'Admin\TourController@destroy',
        '/admin/bookings/[:id]/status' => 'Admin\BookingController@updateStatus',
        '/admin/upload/image' => 'Admin\UploadController@image',
        '/admin/upload/audio' => 'Admin\UploadController@audio',
    ],
];

// Simple router function
function route($requestUri, $method, $routes) {
    foreach ($routes[$method] ?? [] as $route => $handler) {
        // Convert route pattern to regex
        $pattern = preg_replace('/\[:([a-zA-Z_]+)\]/', '(?P<$1>[^/]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $requestUri, $matches)) {
            // Remove numeric keys from matches
            $params = array_filter($matches, ARRAY_FILTER_USE_KEY, fn($key) => is_string($key));
            
            // Call controller method
            [$controller, $action] = explode('@', $handler);
            $controllerClass = "App\\Controllers\\$controller";
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                if (method_exists($controllerInstance, $action)) {
                    return call_user_func_array([$controllerInstance, $action], $params);
                }
            }
            
            http_response_code(500);
            die("Controller method not found: $handler");
        }
    }
    
    return false;
}

// Check for admin prefix
if (strpos($requestUri, '/admin') === 0) {
    // Admin authentication middleware would go here
    if (!route($requestUri, $method, $adminRoutes)) {
        http_response_code(404);
        require TEMPLATE_PATH . '/errors/404.php';
    }
} else {
    // Public routes
    if (!route($requestUri, $method, $routes)) {
        http_response_code(404);
        require TEMPLATE_PATH . '/errors/404.php';
    }
}
