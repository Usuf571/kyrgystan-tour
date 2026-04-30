<?php
/**
 * Tours Listing Page
 * Premium tour catalog with filters and search
 */

$currentLocale = $_SESSION['locale'] ?? 'ru';
$translations = [
    'ru' => [
        'title' => 'Туры по Кыргызстану',
        'subtitle' => 'Найдите своё идеальное приключение',
        'search_placeholder' => 'Поиск туров...',
        'filters' => 'Фильтры',
        'region' => 'Регион',
        'all_regions' => 'Все регионы',
        'difficulty' => 'Сложность',
        'all_difficulties' => 'Любая',
        'duration' => 'Длительность (дней)',
        'price' => 'Цена (USD)',
        'tour_type' => 'Тип тура',
        'all_types' => 'Все типы',
        'apply_filters' => 'Применить',
        'reset_filters' => 'Сбросить',
        'tours_found' => 'Найдено туров',
        'no_tours' => 'По вашим фильтрам туров не найдено',
        'try_different' => 'Попробуйте изменить параметры поиска',
        'view_all' => 'Все туры',
        'days' => 'дн.',
        'per_person' => '/ чел',
        'details' => 'Подробнее',
        'easy' => 'Лёгкий',
        'moderate' => 'Средний',
        'hard' => 'Сложный',
    ],
    'en' => [
        'title' => 'Tours in Kyrgyzstan',
        'subtitle' => 'Find your perfect adventure',
        'search_placeholder' => 'Search tours...',
        'filters' => 'Filters',
        'region' => 'Region',
        'all_regions' => 'All regions',
        'difficulty' => 'Difficulty',
        'all_difficulties' => 'Any',
        'duration' => 'Duration (days)',
        'price' => 'Price (USD)',
        'tour_type' => 'Tour type',
        'all_types' => 'All types',
        'apply_filters' => 'Apply',
        'reset_filters' => 'Reset',
        'tours_found' => 'tours found',
        'no_tours' => 'No tours found for your filters',
        'try_different' => 'Try changing your search parameters',
        'view_all' => 'All tours',
        'days' => 'days',
        'per_person' => '/ person',
        'details' => 'Details',
        'easy' => 'Easy',
        'moderate' => 'Moderate',
        'hard' => 'Hard',
    ],
    'kg' => [
        'title' => 'Кыргызстандагы турлар',
        'subtitle' => 'Өзүңүздүн идеалдуу саякатыңызды табыңыз',
        'search_placeholder' => 'Турларды издөө...',
        'filters' => 'Фильтрлер',
        'region' => 'Аймак',
        'all_regions' => 'Бардык аймактар',
        'difficulty' => 'Татаалдыгы',
        'all_difficulties' => 'Каалаган',
        'duration' => 'Узактыгы (күн)',
        'price' => 'Баасы (USD)',
        'tour_type' => 'Тур түрү',
        'all_types' => 'Бардык түрлөр',
        'apply_filters' => 'Колдонуу',
        'reset_filters' => 'Калыбына келтирүү',
        'tours_found' => 'табылды',
        'no_tours' => 'Сиздин фильтрлериңиз боюнча турлар табылган жок',
        'try_different' => 'Издөө параметрлерин өзгөртүп көрүңүз',
        'view_all' => 'Бардык турлар',
        'days' => 'күн',
        'per_person' => '/ адам',
        'details' => 'Чоо-жайы',
        'easy' => 'Оңой',
        'moderate' => 'Орточо',
        'hard' => 'Татаал',
    ],
];

$t = $translations[$currentLocale] ?? $translations['ru'];
?>

<!-- Hero Section -->
<section class="relative py-20 bg-gradient-to-br from-kg-blue-900 via-kg-dark to-kg-emerald-900 overflow-hidden">
    <!-- Ornament Pattern Background -->
    <div class="absolute inset-0 opacity-5" style="background-image: url('<?= asset('images/patterns/ala-kiyiz-pattern.svg') ?>');"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center" data-aos="fade-up">
            <span class="text-kg-gold-400 font-semibold tracking-wider uppercase text-sm"><?= $t['filters'] ?></span>
            <h1 class="font-display text-4xl md:text-6xl font-bold text-white mt-3 mb-4">
                <?= $t['title'] ?>
            </h1>
            <p class="text-white/70 text-lg max-w-2xl mx-auto">
                <?= $t['subtitle'] ?>
            </p>
        </div>
    </div>
</section>

<!-- Filters & Results Section -->
<section class="py-12 bg-gray-50 -mt-8 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filters Panel -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8" data-aos="fade-up">
            <form method="GET" action="/tours" class="space-y-6">
                
                <!-- Search Bar -->
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="<?= e($filters['search'] ?? '') ?>"
                           placeholder="<?= $t['search_placeholder'] ?>"
                           class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <!-- Filter Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    <!-- Region Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['region'] ?></label>
                        <select name="region" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all appearance-none bg-white">
                            <option value=""><?= $t['all_regions'] ?></option>
                            <?php foreach ($regions as $region): ?>
                                <option value="<?= $region['id'] ?>" <?= ($filters['region'] ?? '') == $region['id'] ? 'selected' : '' ?>>
                                    <?= e($region["name_{$currentLocale}"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Difficulty Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['difficulty'] ?></label>
                        <select name="difficulty" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all appearance-none bg-white">
                            <option value=""><?= $t['all_difficulties'] ?></option>
                            <option value="easy" <?= ($filters['difficulty'] ?? '') === 'easy' ? 'selected' : '' ?>><?= $t['easy'] ?></option>
                            <option value="moderate" <?= ($filters['difficulty'] ?? '') === 'moderate' ? 'selected' : '' ?>><?= $t['moderate'] ?></option>
                            <option value="hard" <?= ($filters['difficulty'] ?? '') === 'hard' ? 'selected' : '' ?>><?= $t['hard'] ?></option>
                        </select>
                    </div>
                    
                    <!-- Duration Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['duration'] ?></label>
                        <div class="flex gap-2">
                            <input type="number" name="duration_min" value="<?= e($filters['duration_min'] ?? '') ?>" placeholder="От" min="1" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                            <input type="number" name="duration_max" value="<?= e($filters['duration_max'] ?? '') ?>" placeholder="До" min="1" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                    
                    <!-- Price Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['price'] ?></label>
                        <div class="flex gap-2">
                            <input type="number" name="price_min" value="<?= e($filters['price_min'] ?? '') ?>" placeholder="От" min="0" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                            <input type="number" name="price_max" value="<?= e($filters['price_max'] ?? '') ?>" placeholder="До" min="0" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                    
                    <!-- Tour Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['tour_type'] ?></label>
                        <select name="type" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all appearance-none bg-white">
                            <option value=""><?= $t['all_types'] ?></option>
                            <?php foreach ($tourTypes as $key => $label): ?>
                                <option value="<?= $key ?>" <?= ($filters['type'] ?? '') === $key ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4 justify-between items-center pt-4 border-t border-gray-100">
                    <div class="text-gray-600">
                        <?php if ($pagination['total'] > 0): ?>
                            <span class="font-semibold text-kg-dark"><?= $pagination['total'] ?></span> <?= $t['tours_found'] ?>
                        <?php endif; ?>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary px-8 py-3">
                            <?= $t['apply_filters'] ?>
                        </button>
                        <a href="/tours" class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                            <?= $t['reset_filters'] ?>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Tours Grid -->
        <?php if (empty($tours)): ?>
            <!-- No Results -->
            <div class="text-center py-20" data-aos="fade-up">
                <svg class="w-20 h-20 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="font-display text-2xl font-bold text-gray-800 mb-2"><?= $t['no_tours'] ?></h3>
                <p class="text-gray-600 mb-6"><?= $t['try_different'] ?></p>
                <a href="/tours" class="btn-primary inline-flex items-center">
                    <?= $t['reset_filters'] ?>
                </a>
            </div>
        <?php else: ?>
            <!-- Tours Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php foreach ($tours as $tour): ?>
                    <article class="group card-hover bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="fade-up">
                        <!-- Image -->
                        <div class="relative h-72 img-zoom-container overflow-hidden">
                            <img src="<?= uploadUrl($tour['main_image'] ?? 'placeholder.jpg') ?>" 
                                 alt="<?= e($tour["title_{$currentLocale}"]) ?>"
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
                                <span class="text-white/70 text-sm"><?= $t['per_person'] ?></span>
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
                                    <span><?= $tour['duration_days'] ?> <?= $t['days'] ?></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    <span class="capitalize">
                                        <?php
                                        $diffTranslations = ['easy' => $t['easy'], 'moderate' => $t['moderate'], 'hard' => $t['hard']];
                                        echo $diffTranslations[$tour['difficulty']] ?? $tour['difficulty'];
                                        ?>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="font-display text-xl font-bold text-kg-dark mb-2 group-hover:text-kg-blue-600 transition-colors">
                                <a href="/tours/<?= $tour['slug'] ?>">
                                    <?= e($tour["title_{$currentLocale}"]) ?>
                                </a>
                            </h3>
                            
                            <!-- Short Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                <?= e(truncate($tour["short_description_{$currentLocale}"] ?? '', 100)) ?>
                            </p>
                            
                            <!-- Regions -->
                            <?php if (!empty($tour['regions'])): ?>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <?php foreach (array_slice($tour['regions'], 0, 2) as $region): ?>
                                        <span class="px-3 py-1 bg-kg-blue-50 text-kg-blue-600 rounded-full text-xs font-medium">
                                            <?= e($region["name_{$currentLocale}"]) ?>
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
                                <?= $t['details'] ?>
                                <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($pagination['last_page'] > 1): ?>
                <div class="flex justify-center" data-aos="fade-up">
                    <nav class="flex items-center gap-2">
                        <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                            <?php
                            $queryParams = $_GET;
                            $queryParams['page'] = $i;
                            $queryString = http_build_query($queryParams);
                            ?>
                            <a href="/tours?<?= $queryString ?>" 
                               class="px-4 py-2 rounded-xl transition-colors <?= $i === $pagination['current_page'] ? 'bg-kg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
