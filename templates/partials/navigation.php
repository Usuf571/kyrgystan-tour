<!-- Navigation Bar -->
<nav class="main-navigation fixed w-full z-50 transition-all duration-300 bg-transparent" 
     x-data="{ mobileMenuOpen: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 50)"
     :class="{ 'nav-scrolled': scrolled, 'bg-white/95': scrolled }">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-kg-blue-500 to-kg-emerald-500 flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-xl <?= $scrolled ?? false ? 'text-kg-dark' : 'text-white' ?> transition-colors duration-300">
                        Discover<br/><span class="gradient-text">Kyrgyzstan</span>
                    </span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="nav-link font-medium <?= isActiveRoute('/') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Главная
                </a>
                <a href="/tours" class="nav-link font-medium <?= isActiveRoute('/tours') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Туры
                </a>
                <a href="/regions" class="nav-link font-medium <?= isActiveRoute('/regions') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Регионы
                </a>
                <a href="/attractions" class="nav-link font-medium <?= isActiveRoute('/attractions') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Места
                </a>
                <a href="/audio-guide" class="nav-link font-medium <?= isActiveRoute('/audio-guide') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Аудиогид
                </a>
                <a href="/gallery" class="nav-link font-medium <?= isActiveRoute('/gallery') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Галерея
                </a>
                <a href="/blog" class="nav-link font-medium <?= isActiveRoute('/blog') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Блог
                </a>
                <a href="/contact" class="nav-link font-medium <?= isActiveRoute('/contact') ? 'text-kg-blue-500' : ($scrolled ?? false ? 'text-gray-700 hover:text-kg-blue-500' : 'text-white/90 hover:text-white') ?> transition-colors duration-200">
                    Контакты
                </a>
            </div>
            
            <!-- Right Side Actions -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Language Switcher -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-1 <?= $scrolled ?? false ? 'text-gray-700' : 'text-white' ?> hover:text-kg-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        <span class="uppercase text-sm font-medium"><?= $current_locale ?></span>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-xl py-2 border border-gray-100 animate-scale-in">
                        <?php foreach ($locales as $code => $name): ?>
                            <a href="#" onclick="switchLanguage('<?= $code ?>')" 
                               class="block px-4 py-2 text-sm <?= $current_locale === $code ? 'bg-kg-blue-50 text-kg-blue-600' : 'text-gray-700 hover:bg-gray-50' ?>">
                                <?= $code === 'ru' ? 'Русский' : ($code === 'en' ? 'English' : 'Кыргызча') ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- User Menu / Login -->
                <?php if (isset($user) && $user): ?>
                    <a href="/profile" class="<?= $scrolled ?? false ? 'text-gray-700' : 'text-white' ?> hover:text-kg-blue-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <a href="/login" class="<?= $scrolled ?? false ? 'text-gray-700' : 'text-white' ?> hover:text-kg-blue-500 transition-colors font-medium">
                        Войти
                    </a>
                    <a href="/register" class="btn-primary text-sm px-6 py-3">
                        Регистрация
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="<?= $scrolled ?? false ? 'text-gray-700' : 'text-white' ?> hover:text-kg-blue-500 focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         class="md:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="/" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Главная</a>
            <a href="/tours" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Туры</a>
            <a href="/regions" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Регионы</a>
            <a href="/attractions" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Места</a>
            <a href="/audio-guide" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Аудиогид</a>
            <a href="/gallery" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Галерея</a>
            <a href="/blog" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Блог</a>
            <a href="/contact" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Контакты</a>
            
            <div class="border-t border-gray-200 pt-4 mt-4">
                <?php if (isset($user) && $user): ?>
                    <a href="/profile" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Профиль</a>
                <?php else: ?>
                    <a href="/login" class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:text-kg-blue-500 hover:bg-kg-blue-50">Войти</a>
                    <a href="/register" class="block px-3 py-3 rounded-md text-base font-medium text-kg-blue-600 hover:bg-kg-blue-50">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
