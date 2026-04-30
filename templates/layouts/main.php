<!DOCTYPE html>
<html lang="<?= $current_locale ?? 'ru' ?>" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?= $page_title ?? 'Discover Kyrgyzstan' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Explore the breathtaking beauty of Kyrgyzstan' ?>">
    <meta name="keywords" content="Kyrgyzstan, tourism, travel, mountains, Issyk-Kul, nomads, Central Asia, adventure">
    <meta name="author" content="Discover Kyrgyzstan">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $page_title ?? 'Discover Kyrgyzstan' ?>">
    <meta property="og:description" content="<?= $meta_description ?? 'Explore the breathtaking beauty of Kyrgyzstan' ?>">
    <meta property="og:image" content="<?= $og_image ?? asset('images/og-default.jpg') ?>">
    <meta property="og:url" content="<?= $_SERVER['HTTP_HOST'] ?? 'https://visitkg.com' ?>">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= asset('images/favicon.png') ?>">
    
    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for development - use build process for production) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Kyrgyzstan-inspired palette
                        'kg-blue': {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            300: '#7cc5fb',
                            400: '#36a9f6',
                            500: '#0d8eed',
                            600: '#0070d3',
                            700: '#0059b0',
                            800: '#064c8e',
                            900: '#094178',
                        },
                        'kg-emerald': {
                            50: '#f2fcf9',
                            100: '#e0f8f0',
                            200: '#bcf0de',
                            300: '#85e3c3',
                            400: '#45d1a5',
                            500: '#20b988',
                            600: '#10996e',
                            700: '#0f7d5a',
                            800: '#11654a',
                            900: '#0f533e',
                        },
                        'kg-gold': {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        'kg-terracotta': {
                            50: '#fdf8f6',
                            100: '#fcece7',
                            200: '#fad5ca',
                            300: '#f5b29f',
                            400: '#ed856b',
                            500: '#e05d43',
                            600: '#d13f2b',
                            700: '#b02d1f',
                            800: '#90281e',
                            900: '#76261d',
                        },
                        'kg-sand': '#f5f0eb',
                        'kg-dark': '#1a1f2e',
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'Georgia', 'serif'],
                        'body': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    backgroundImage: {
                        'ala-kiyiz': "url('/assets/images/patterns/ala-kiyiz-pattern.svg')",
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'slide-up': 'slideUp 0.8s ease-out forwards',
                        'slide-down': 'slideDown 0.8s ease-out forwards',
                        'scale-in': 'scaleIn 0.6s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                    },
                },
            },
        }
    </script>
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #fafafa;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #0d8eed;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #0070d3;
        }
        
        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .glass-dark {
            background: rgba(26, 31, 46, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #0d8eed 0%, #20b988 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Image hover zoom */
        .img-zoom-container {
            overflow: hidden;
        }
        
        .img-zoom-container img {
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .img-zoom-container:hover img {
            transform: scale(1.1);
        }
        
        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #0d8eed 0%, #0070d3 100%);
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 142, 237, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 142, 237, 0.5);
        }
        
        .btn-secondary {
            background: white;
            color: #0d8eed;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            border: 2px solid #0d8eed;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #0d8eed;
            color: white;
        }
        
        /* Card hover effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        /* Navigation styles */
        .nav-scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Loading spinner */
        .spinner {
            border: 3px solid rgba(13, 142, 237, 0.1);
            border-radius: 50%;
            border-top-color: #0d8eed;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Parallax container */
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        /* Ornament pattern overlay */
        .ornament-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230d8eed' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
    
    <?php if (isset($additional_css)): ?>
        <?= $additional_css ?>
    <?php endif; ?>
</head>
<body class="antialiased text-gray-800">
    
    <!-- Navigation -->
    <?php require TEMPLATE_PATH . '/partials/navigation.php'; ?>
    
    <!-- Main Content -->
    <main class="min-h-screen">
        <?php require TEMPLATE_PATH . "/pages/{$view}.php"; ?>
    </main>
    
    <!-- Footer -->
    <?php require TEMPLATE_PATH . '/partials/footer.php'; ?>
    
    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
        });
        
        // Navigation scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.main-navigation');
            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Language switcher
        function switchLanguage(locale) {
            fetch('/api/set-locale', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ locale })
            }).then(() => location.reload());
        }
    </script>
    
    <?php if (isset($additional_js)): ?>
        <?= $additional_js ?>
    <?php endif; ?>
    
</body>
</html>
