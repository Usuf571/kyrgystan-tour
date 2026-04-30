<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Страница не найдена | Discover Kyrgyzstan</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'kg-blue': { 500: '#0d8eed', 600: '#0070d3' },
                        'kg-emerald': { 500: '#20b988' },
                        'kg-dark': '#1a1f2e',
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'Georgia', 'serif'],
                        'body': ['Inter', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="font-body bg-kg-sand min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-4xl mx-auto text-center">
        <!-- Illustration / Graphic -->
        <div class="mb-8">
            <svg class="w-64 h-64 mx-auto text-kg-blue-500/20" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Mountain shapes -->
                <path d="M20 150 L60 80 L100 150 Z" fill="currentColor" opacity="0.3"/>
                <path d="M80 150 L120 50 L160 150 Z" fill="currentColor" opacity="0.5"/>
                <path d="M140 150 L170 90 L200 150 Z" fill="currentColor" opacity="0.4"/>
                <!-- Yurt circle -->
                <circle cx="100" cy="100" r="15" fill="none" stroke="currentColor" stroke-width="2"/>
                <circle cx="100" cy="100" r="8" fill="currentColor" opacity="0.3"/>
            </svg>
        </div>
        
        <!-- Error Code -->
        <h1 class="font-display text-8xl md:text-9xl font-bold text-kg-dark mb-4">404</h1>
        
        <!-- Error Message -->
        <h2 class="font-display text-3xl md:text-4xl font-bold text-gray-700 mb-4">
            Страница не найдена
        </h2>
        <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">
            Похоже, вы заблудились в горах. Не волнуйтесь, мы поможем вам найти дорогу обратно.
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/" class="btn-primary inline-flex items-center px-8 py-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                На главную
            </a>
            <a href="/tours" class="inline-flex items-center px-8 py-4 border-2 border-kg-blue-500 text-kg-blue-600 font-semibold rounded-full hover:bg-kg-blue-500 hover:text-white transition-colors">
                Смотреть туры
            </a>
        </div>
        
        <!-- Helpful Links -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <p class="text-gray-500 text-sm mb-4">Возможно, вы искали:</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/tours" class="text-kg-blue-600 hover:text-kg-blue-700 font-medium">Все туры</a>
                <span class="text-gray-300">•</span>
                <a href="/regions" class="text-kg-blue-600 hover:text-kg-blue-700 font-medium">Регионы</a>
                <span class="text-gray-300">•</span>
                <a href="/attractions" class="text-kg-blue-600 hover:text-kg-blue-700 font-medium">Места</a>
                <span class="text-gray-300">•</span>
                <a href="/contact" class="text-kg-blue-600 hover:text-kg-blue-700 font-medium">Контакты</a>
            </div>
        </div>
    </div>
    
    <style>
        .btn-primary {
            background: linear-gradient(135deg, #0d8eed 0%, #0070d3 100%);
            color: white;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 142, 237, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 142, 237, 0.5);
        }
    </style>
</body>
</html>
