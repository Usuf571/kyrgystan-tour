<?php $view = 'home/index'; ?>

<!-- Hero Section with Video Background -->
<section class="relative h-screen min-h-[700px] flex items-center justify-center overflow-hidden">
    
    <!-- Video Background -->
    <div class="absolute inset-0 z-0">
        <video autoplay muted loop playsinline class="w-full h-full object-cover">
            <source src="<?= asset('videos/hero-mountains.mp4') ?>" type="video/mp4">
            <!-- Fallback image if video doesn't load -->
            <img src="<?= asset('images/hero-fallback.jpg') ?>" alt="Kyrgyzstan Mountains" class="w-full h-full object-cover">
        </video>
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 text-center px-4 max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="1200">
        <p class="text-white/90 text-lg md:text-xl font-medium mb-4 tracking-wider uppercase animate-slide-down">
            Добро пожаловать в
        </p>
        <h1 class="font-display text-5xl md:text-7xl lg:text-8xl font-bold text-white mb-6 leading-tight animate-slide-up">
            Кыргызстан —<br/>
            <span class="bg-gradient-to-r from-kg-blue-400 via-kg-emerald-400 to-kg-gold-400 bg-clip-text text-transparent">
                Земля Кочевников
            </span>
        </h1>
        <p class="text-white/80 text-lg md:text-xl max-w-3xl mx-auto mb-10 leading-relaxed animate-fade-in">
            Откройте для себя нетронутую природу, древние традиции и гостеприимство народа в самом сердце Центральной Азии
        </p>
        
        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-scale-in">
            <a href="/tours" class="btn-primary text-lg px-10 py-4 inline-flex items-center group">
                Выбрать тур
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="#regions" class="btn-secondary text-lg px-10 py-4 inline-flex items-center">
                Исследовать регионы
            </a>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>
    
    <!-- Stats Overlay -->
    <div class="absolute bottom-0 left-0 right-0 z-20 hidden lg:block">
        <div class="max-w-7xl mx-auto px-8 pb-8">
            <div class="grid grid-cols-4 gap-8 text-white">
                <div class="text-center">
                    <div class="text-4xl font-display font-bold text-kg-blue-400 mb-1">7</div>
                    <div class="text-sm text-white/70">Областей</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-display font-bold text-kg-emerald-400 mb-1">2000+</div>
                    <div class="text-sm text-white/70">Озёр</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-display font-bold text-kg-gold-400 mb-1">90%</div>
                    <div class="text-sm text-white/70">Горы</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-display font-bold text-kg-terracotta-400 mb-1">∞</div>
                    <div class="text-sm text-white/70">Впечатлений</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Tours Section -->
<section class="py-24 bg-gradient-to-b from-white to-kg-sand">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-kg-blue-600 font-semibold tracking-wider uppercase text-sm">Лучшие предложения</span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-kg-dark mt-3 mb-6">
                Популярные Туры
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Выберите своё следующее приключение из нашей коллекции тщательно подобранных туров по Кыргызстану
            </p>
        </div>
        
        <!-- Tours Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php foreach ($featured_tours as $tour): ?>
                <article class="group card-hover bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="fade-up">
                    <!-- Image -->
                    <div class="relative h-72 img-zoom-container overflow-hidden">
                        <img src="<?= uploadUrl($tour['main_image'] ?? 'placeholder.jpg') ?>" 
                             alt="<?= e($tour["title_{$current_locale}"]) ?>"
                             class="w-full h-full object-cover">
                        
                        <!-- Badge -->
                        <?php if ($tour['is_featured']): ?>
                            <div class="absolute top-4 left-4 bg-kg-gold-500 text-white px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider">
                                Популярный
                            </div>
                        <?php endif; ?>
                        
                        <!-- Price Tag -->
                        <div class="absolute bottom-4 right-4 glass-dark px-4 py-2 rounded-full">
                            <span class="text-white font-bold text-lg"><?= formatPrice($tour['price_from']) ?></span>
                            <span class="text-white/70 text-sm">/ чел</span>
                        </div>
                        
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <!-- Meta Info -->
                        <div class="flex items-center justify-between mb-3 text-sm text-gray-500">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><?= $tour['duration_days'] ?> дн.</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <span class="capitalize"><?= $tour['difficulty'] === 'moderate' ? 'Средний' : ($tour['difficulty'] === 'easy' ? 'Лёгкий' : 'Сложный') ?></span>
                            </div>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="font-display text-xl font-bold text-kg-dark mb-2 group-hover:text-kg-blue-600 transition-colors">
                            <a href="/tours/<?= $tour['slug'] ?>">
                                <?= e($tour["title_{$current_locale}"]) ?>
                            </a>
                        </h3>
                        
                        <!-- Short Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            <?= e(truncate($tour["short_description_{$current_locale}"] ?? '', 100)) ?>
                        </p>
                        
                        <!-- Regions -->
                        <?php if (!empty($tour['regions'])): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php foreach (array_slice($tour['regions'], 0, 2) as $region): ?>
                                    <span class="px-3 py-1 bg-kg-blue-50 text-kg-blue-600 rounded-full text-xs font-medium">
                                        <?= e($region["name_{$current_locale}"]) ?>
                                    </span>
                                <?php endforeach; ?>
                                <?php if (count($tour['regions']) > 2): ?>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                        +<?= count($tour['regions']) - 2 ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Link -->
                        <a href="/tours/<?= $tour['slug'] ?>" class="inline-flex items-center text-kg-blue-600 font-semibold hover:text-kg-blue-700 transition-colors group/link">
                            Подробнее
                            <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        
        <!-- View All Button -->
        <div class="text-center">
            <a href="/tours" class="btn-primary inline-flex items-center text-lg px-10 py-4">
                Все туры
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Regions Section -->
<section id="regions" class="py-24 bg-white ornament-overlay relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-kg-emerald-600 font-semibold tracking-wider uppercase text-sm">Исследуйте</span>
            <h2 class="font-display text-4xl md:text-5xl font-bold text-kg-dark mt-3 mb-6">
                Регионы Кыргызстана
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">
                Каждый регион уникален — от ледников Тянь-Шаня до субтропиков Ферганской долины
            </p>
        </div>
        
        <!-- Regions Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php foreach ($regions as $index => $region): ?>
                <a href="/regions/<?= $region['slug'] ?>" 
                   class="group relative h-80 md:h-96 rounded-2xl overflow-hidden card-hover"
                   data-aos="fade-up"
                   data-aos-delay="<?= ($index % 4) * 100 ?>">
                    
                    <!-- Background Image -->
                    <img src="<?= uploadUrl($region['cover_image'] ?? 'placeholder-region.jpg') ?>" 
                         alt="<?= e($region["name_{$current_locale}"]) ?>"
                         class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    
                    <!-- Content -->
                    <div class="absolute inset-0 flex flex-col justify-end p-6">
                        <h3 class="font-display text-2xl md:text-3xl font-bold text-white mb-2">
                            <?= e($region["name_{$current_locale}"]) ?>
                        </h3>
                        <div class="flex items-center text-white/80 text-sm space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <?= $region['attractions_count'] ?? 0 ?> мест
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <?= $region['tours_count'] ?? 0 ?> туров
                            </span>
                        </div>
                    </div>
                    
                    <!-- Hover Border Effect -->
                    <div class="absolute inset-0 border-2 border-white/0 group-hover:border-white/50 rounded-2xl transition-colors duration-300"></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us / Features Section -->
<section class="py-24 bg-kg-dark text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-kg-blue-400 font-semibold tracking-wider uppercase text-sm">Преимущества</span>
            <h2 class="font-display text-4xl md:text-5xl font-bold mt-3 mb-6">
                Почему выбирают нас
            </h2>
        </div>
        
        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Feature 1 -->
            <div class="text-center p-6" data-aos="fade-up" data-aos-delay="0">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-kg-blue-500 to-kg-blue-600 flex items-center justify-center transform rotate-3 hover:rotate-6 transition-transform">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-bold mb-3">Безопасность</h3>
                <p class="text-gray-400">Лицензированные гиды, проверенные маршруты и полная страховка для каждого туриста</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="text-center p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-kg-emerald-500 to-kg-emerald-600 flex items-center justify-center transform -rotate-3 hover:-rotate-6 transition-transform">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-bold mb-3">Экологичность</h3>
                <p class="text-gray-400">Ответственный туризм с заботой о природе и поддержкой местных сообществ</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="text-center p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-kg-gold-500 to-kg-gold-600 flex items-center justify-center transform rotate-3 hover:rotate-6 transition-transform">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-bold mb-3">Местные гиды</h3>
                <p class="text-gray-400">Опытные проводники, которые знают каждый уголок и поделятся уникальными историями</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="text-center p-6" data-aos="fade-up" data-aos-delay="300">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-kg-terracotta-500 to-kg-terracotta-600 flex items-center justify-center transform -rotate-3 hover:-rotate-6 transition-transform">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-bold mb-3">Честные цены</h3>
                <p class="text-gray-400">Прозрачное ценообразование без скрытых платежей и дополнительных сборов</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Attractions Preview -->
<section class="py-24 bg-gradient-to-b from-kg-sand to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-12" data-aos="fade-up">
            <div class="mb-6 md:mb-0">
                <span class="text-kg-terracotta-600 font-semibold tracking-wider uppercase text-sm">Must Visit</span>
                <h2 class="font-display text-4xl md:text-5xl font-bold text-kg-dark mt-3">
                    Популярные Места
                </h2>
            </div>
            <a href="/attractions" class="text-kg-blue-600 font-semibold hover:text-kg-blue-700 inline-flex items-center group">
                Все места
                <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        
        <!-- Attractions Carousel/Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($popular_attractions as $attraction): ?>
                <a href="/attractions/<?= $attraction['slug'] ?>" 
                   class="group relative h-80 rounded-2xl overflow-hidden card-hover"
                   data-aos="fade-up">
                    
                    <img src="<?= uploadUrl('attractions/' . ($attraction['id'] % 10) . '.jpg') ?>" 
                         alt="<?= e($attraction["name_{$current_locale}"]) ?>"
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs text-white font-medium capitalize">
                                <?= $attraction['type'] ?>
                            </span>
                            <?php if ($attraction['rating'] > 0): ?>
                                <div class="flex items-center text-kg-gold-400">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="ml-1 text-white text-sm font-medium"><?= number_format($attraction['rating'], 1) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h3 class="font-display text-2xl font-bold text-white mb-1">
                            <?= e($attraction["name_{$current_locale}"]) ?>
                        </h3>
                        <p class="text-white/70 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <?= e($attraction['region_name']) ?>
                        </p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter / CTA Section -->
<section class="py-24 relative overflow-hidden">
    <!-- Background with pattern -->
    <div class="absolute inset-0 bg-gradient-to-r from-kg-blue-600 to-kg-emerald-600"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">
            Готовы к приключению?
        </h2>
        <p class="text-white/90 text-lg mb-10 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Подпишитесь на нашу рассылку и получите эксклюзивные предложения, путеводители и вдохновение для путешествий
        </p>
        
        <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            <input type="email" 
                   placeholder="Ваш email" 
                   class="flex-1 px-6 py-4 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 text-white placeholder-white/60 focus:outline-none focus:bg-white/30 transition-colors"
                   required>
            <button type="submit" class="btn-secondary px-8 py-4 whitespace-nowrap">
                Подписаться
            </button>
        </form>
        
        <p class="text-white/60 text-sm mt-4">Мы не передаём ваши данные третьим лицам</p>
    </div>
</section>
