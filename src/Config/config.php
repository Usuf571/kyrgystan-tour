<?php
/**
 * Database Configuration
 * 
 * Environment-specific database settings
 */

return [
    'database' => [
        'driver' => 'mysql',
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_NAME') ?: 'kg_tourism_db',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') ?: '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ],
    
    'app' => [
        'name' => 'Discover Kyrgyzstan',
        'url' => getenv('APP_URL') ?: 'http://localhost',
        'debug' => getenv('APP_DEBUG') ?: true,
        'timezone' => 'Asia/Bishkek',
        'locale' => 'ru',
        'fallback_locale' => 'en',
        'locales' => ['ru', 'en', 'kg'],
    ],
    
    'mail' => [
        'driver' => 'smtp',
        'host' => getenv('MAIL_HOST') ?: 'smtp.mailtrap.io',
        'port' => getenv('MAIL_PORT') ?: 587,
        'username' => getenv('MAIL_USERNAME'),
        'password' => getenv('MAIL_PASSWORD'),
        'encryption' => 'tls',
        'from' => [
            'address' => 'noreply@visitkg.com',
            'name' => 'Discover Kyrgyzstan'
        ]
    ],
    
    'upload' => [
        'max_size' => 10 * 1024 * 1024, // 10MB
        'allowed_images' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
        'allowed_audio' => ['mp3', 'wav', 'ogg', 'm4a'],
        'paths' => [
            'tours' => '/uploads/tours/',
            'regions' => '/uploads/regions/',
            'attractions' => '/uploads/attractions/',
            'audio' => '/uploads/audio/',
            'avatars' => '/uploads/avatars/',
            'blog' => '/uploads/blog/',
        ]
    ],
    
    'security' => [
        'csrf_enabled' => true,
        'rate_limit' => [
            'enabled' => true,
            'max_requests' => 60,
            'decay_minutes' => 1,
        ]
    ],
    
    'pagination' => [
        'per_page' => 12,
        'max_pages' => 100,
    ],
];
