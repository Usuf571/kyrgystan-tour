<?php
/**
 * Single Tour Details Page
 * Premium tour presentation with booking form
 */

$currentLocale = $_SESSION['locale'] ?? 'ru';
$translations = [
    'ru' => [
        'book_now' => 'Забронировать',
        'from_price' => 'от',
        'per_person' => '/ чел',
        'duration' => 'Длительность',
        'days' => 'дней',
        'difficulty' => 'Сложность',
        'group_size' => 'Размер группы',
        'people' => 'человек',
        'location' => 'Локация',
        'overview' => 'Обзор',
        'itinerary' => 'Программа тура',
        'included' => 'Включено',
        'not_included' => 'Не включено',
        'gallery' => 'Галерея',
        'reviews' => 'Отзывы',
        'related_tours' => 'Похожие туры',
        'full_name' => 'Ваше имя',
        'email' => 'Email',
        'phone' => 'Телефон',
        'participants' => 'Количество участников',
        'start_date' => 'Дата начала',
        'end_date' => 'Дата окончания',
        'comment' => 'Комментарий',
        'send_request' => 'Отправить заявку',
        'day' => 'День',
        'easy' => 'Лёгкий',
        'moderate' => 'Средний',
        'hard' => 'Сложный',
        'why_choose_us' => 'Почему выбирают нас',
        'safety' => 'Безопасность',
        'experienced_guides' => 'Опытные гиды',
        'best_price' => 'Лучшая цена',
        'support_24_7' => 'Поддержка 24/7',
    ],
    'en' => [
        'book_now' => 'Book Now',
        'from_price' => 'from',
        'per_person' => '/ person',
        'duration' => 'Duration',
        'days' => 'days',
        'difficulty' => 'Difficulty',
        'group_size' => 'Group size',
        'people' => 'people',
        'location' => 'Location',
        'overview' => 'Overview',
        'itinerary' => 'Itinerary',
        'included' => 'Included',
        'not_included' => 'Not included',
        'gallery' => 'Gallery',
        'reviews' => 'Reviews',
        'related_tours' => 'Related Tours',
        'full_name' => 'Full Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'participants' => 'Number of participants',
        'start_date' => 'Start date',
        'end_date' => 'End date',
        'comment' => 'Comment',
        'send_request' => 'Send Request',
        'day' => 'Day',
        'easy' => 'Easy',
        'moderate' => 'Moderate',
        'hard' => 'Hard',
    ],
    'kg' => [
        'book_now' => 'Брондоо',
        'from_price' => 'баштап',
        'per_person' => '/ адам',
        'duration' => 'Узактыгы',
        'days' => 'күн',
        'difficulty' => 'Татаалдыгы',
        'group_size' => 'Топтун өлчөмү',
        'people' => 'адам',
        'location' => 'Жайгашкан жери',
        'overview' => 'Чолдоо',
        'itinerary' => 'Турдун программасы',
        'included' => 'Камтылган',
        'not_included' => 'Камтылган эмес',
        'gallery' => 'Галерея',
        'reviews' => 'Пикирлер',
        'related_tours' => 'Окшош турлар',
        'full_name' => 'Атыңыз',
        'email' => 'Email',
        'phone' => 'Телефон',
        'participants' => 'Катышуучулардын саны',
        'start_date' => 'Башталуу датасы',
        'end_date' => 'Аяктоо датасы',
        'comment' => 'Комментарий',
        'send_request' => 'Өтүнмө жөнөтүү',
        'day' => 'Күн',
        'easy' => 'Оңой',
        'moderate' => 'Орточо',
        'hard' => 'Татаал',
    ],
];

$t = $translations[$currentLocale] ?? $translations['ru'];

// Difficulty translations
$diffTranslations = [
    'ru' => ['easy' => 'Лёгкий', 'moderate' => 'Средний', 'hard' => 'Сложный'],
    'en' => ['easy' => 'Easy', 'moderate' => 'Moderate', 'hard' => 'Hard'],
    'kg' => ['easy' => 'Оңой', 'moderate' => 'Орточо', 'hard' => 'Татаал'],
];
$difficultyText = $diffTranslations[$currentLocale][$tour['difficulty']] ?? ucfirst($tour['difficulty']);
?>

<!-- Hero Section with Image Slider -->
<section class="relative h-[60vh] min-h-[500px] overflow-hidden">
    <!-- Main Image Slider -->
    <div class="absolute inset-0" x-data="{ activeSlide: 0 }" x-init="setInterval(() => { if (activeSlide < <?= count($images) - 1 ?>) { activeSlide++ } else { activeSlide = 0 } }, 5000)">
        <?php foreach ($images as $index => $image): ?>
            <div class="absolute inset-0 transition-opacity duration-1000" 
                 :class="activeSlide === <?= $index ?> ? 'opacity-100' : 'opacity-0'">
                <img src="<?= uploadUrl($image['image_path']) ?>" 
                     alt="<?= e($tour["title_{$currentLocale}"]) ?>"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
            </div>
        <?php endforeach; ?>
        
        <!-- Navigation Dots -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 flex gap-3">
            <?php foreach ($images as $index => $image): ?>
                <button @click="activeSlide = <?= $index ?>" 
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === <?= $index ?> ? 'bg-white scale-125' : 'bg-white/50 hover:bg-white/75'">
                </button>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Tour Title Overlay -->
    <div class="absolute bottom-0 left-0 right-0 z-10 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <!-- Breadcrumbs -->
                    <nav class="flex items-center gap-2 text-white/70 text-sm mb-4">
                        <a href="/" class="hover:text-white transition-colors">Главная</a>
                        <span>/</span>
                        <a href="/tours" class="hover:text-white transition-colors">Туры</a>
                        <span>/</span>
                        <span class="text-white"><?= e($tour["title_{$currentLocale}"]) ?></span>
                    </nav>
                    
                    <h1 class="font-display text-4xl md:text-6xl font-bold text-white mb-4">
                        <?= e($tour["title_{$currentLocale}"]) ?>
                    </h1>
                    
                    <!-- Meta Info -->
                    <div class="flex flex-wrap gap-6 text-white">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><?= $tour['duration_days'] ?> <?= $t['days'] ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span><?= $difficultyText ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span><?= $tour['max_group_size'] ?? 12 ?> <?= $t['people'] ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Price & CTA -->
                <div class="glass-dark backdrop-blur-md rounded-2xl p-6 min-w-[280px]">
                    <div class="text-white/70 text-sm mb-1"><?= $t['from_price'] ?></div>
                    <div class="text-4xl font-display font-bold text-kg-gold-400 mb-4">
                        <?= formatPrice($tour['price_from']) ?>
                        <span class="text-lg text-white/70"><?= $t['per_person'] ?></span>
                    </div>
                    <a href="#booking" class="btn-primary w-full text-center block py-4">
                        <?= $t['book_now'] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left Column - Details -->
            <div class="lg:col-span-2 space-y-12">
                
                <!-- Overview -->
                <div data-aos="fade-up">
                    <h2 class="font-display text-3xl font-bold text-kg-dark mb-6"><?= $t['overview'] ?></h2>
                    <div class="prose prose-lg max-w-none text-gray-600">
                        <?= nl2br(e($tour["full_description_{$currentLocale}"] ?? '')) ?>
                    </div>
                </div>
                
                <!-- Itinerary -->
                <?php if (!empty($tour["itinerary_{$currentLocale}"])): ?>
                <div data-aos="fade-up">
                    <h2 class="font-display text-3xl font-bold text-kg-dark mb-6"><?= $t['itinerary'] ?></h2>
                    <div class="space-y-6">
                        <?php 
                        $days = explode("\n\n", $tour["itinerary_{$currentLocale}"]);
                        foreach ($days as $index => $dayContent): 
                        ?>
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 w-16 h-16 rounded-full bg-gradient-to-br from-kg-blue-500 to-kg-emerald-500 flex items-center justify-center text-white font-bold">
                                    <?= $index + 1 ?>
                                </div>
                                <div class="flex-1 bg-white rounded-xl p-6 shadow-sm">
                                    <h3 class="font-display text-xl font-bold text-kg-dark mb-2"><?= $t['day'] ?> <?= $index + 1 ?></h3>
                                    <p class="text-gray-600"><?= nl2br(e($dayContent)) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Included / Not Included -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8" data-aos="fade-up">
                    <div class="bg-white rounded-2xl p-8 shadow-sm">
                        <h3 class="font-display text-2xl font-bold text-green-600 mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?= $t['included'] ?>
                        </h3>
                        <ul class="space-y-3">
                            <?php 
                            $includedItems = !empty($tour['included_ru']) ? explode("\n", $tour['included_ru']) : [];
                            foreach ($includedItems as $item): 
                            ?>
                                <li class="flex items-start gap-3 text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <?= e(trim($item)) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="bg-white rounded-2xl p-8 shadow-sm">
                        <h3 class="font-display text-2xl font-bold text-red-600 mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?= $t['not_included'] ?>
                        </h3>
                        <ul class="space-y-3">
                            <?php 
                            $notIncludedItems = !empty($tour['not_included_ru']) ? explode("\n", $tour['not_included_ru']) : [];
                            foreach ($notIncludedItems as $item): 
                            ?>
                                <li class="flex items-start gap-3 text-gray-600">
                                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <?= e(trim($item)) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <!-- Gallery -->
                <?php if (count($images) > 1): ?>
                <div data-aos="fade-up">
                    <h2 class="font-display text-3xl font-bold text-kg-dark mb-6"><?= $t['gallery'] ?></h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach (array_slice($images, 1, 6) as $image): ?>
                            <div class="group relative aspect-square rounded-xl overflow-hidden cursor-pointer img-zoom-container">
                                <img src="<?= uploadUrl($image['image_path']) ?>" 
                                     alt="Tour gallery"
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Related Tours -->
                <?php if (!empty($related_tours)): ?>
                <div data-aos="fade-up">
                    <h2 class="font-display text-3xl font-bold text-kg-dark mb-6"><?= $t['related_tours'] ?></h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($related_tours as $relatedTour): ?>
                            <a href="/tours/<?= $relatedTour['slug'] ?>" class="group card-hover bg-white rounded-2xl overflow-hidden shadow-lg">
                                <div class="relative h-48 img-zoom-container overflow-hidden">
                                    <img src="<?= uploadUrl($relatedTour['main_image'] ?? 'placeholder.jpg') ?>" 
                                         alt="<?= e($relatedTour["title_{$currentLocale}"]) ?>"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-display text-lg font-bold text-kg-dark mb-2 group-hover:text-kg-blue-600">
                                        <?= e($relatedTour["title_{$currentLocale}"]) ?>
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500"><?= $relatedTour['duration_days'] ?> <?= $t['days'] ?></span>
                                        <span class="text-kg-blue-600 font-bold"><?= formatPrice($relatedTour['price_from']) ?></span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Right Column - Booking Form -->
            <div class="lg:col-span-1">
                <div id="booking" class="sticky top-24 bg-white rounded-2xl shadow-xl p-8" data-aos="fade-left">
                    <h3 class="font-display text-2xl font-bold text-kg-dark mb-6"><?= $t['book_now'] ?></h3>
                    
                    <form id="bookingForm" class="space-y-5" action="/booking/create" method="POST">
                        <?= csrfField() ?>
                        <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['full_name'] ?></label>
                            <input type="text" name="full_name" required
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['email'] ?></label>
                            <input type="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['phone'] ?></label>
                            <input type="tel" name="phone" required
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['participants'] ?></label>
                            <input type="number" name="participants" id="participants" min="1" max="20" value="<?= $default_participants ?>"
                                   onchange="updatePrice()"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['start_date'] ?></label>
                            <input type="date" name="start_date" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['end_date'] ?></label>
                            <input type="date" name="end_date" min="<?= date('Y-m-d', strtotime('+2 days')) ?>"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><?= $t['comment'] ?></label>
                            <textarea name="comment" rows="3"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-kg-blue-500 focus:border-transparent transition-all"></textarea>
                        </div>
                        
                        <!-- Total Price Display -->
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600"><?= $t['per_person'] ?>:</span>
                                <span class="font-semibold text-kg-dark"><?= formatPrice($tour['price_from']) ?></span>
                            </div>
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-lg font-medium text-gray-700"><?= $t['participants'] ?>:</span>
                                <span id="participantCount" class="text-lg font-semibold text-kg-dark"><?= $default_participants ?></span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="text-xl font-bold text-kg-dark">Итого:</span>
                                <span id="totalPrice" class="text-2xl font-display font-bold text-kg-blue-600"><?= formatPrice($calculated_price) ?></span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full py-4 text-lg">
                            <?= $t['send_request'] ?>
                        </button>
                        
                        <p class="text-xs text-gray-500 text-center mt-4">
                            Нажимая кнопку, вы соглашаетесь с условиями обработки персональных данных
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function updatePrice() {
    const participants = parseInt(document.getElementById('participants').value) || 1;
    const basePrice = <?= $tour['price_from'] ?>;
    
    // Calculate discount
    let discount = 0;
    if (participants >= 10) discount = 0.15;
    else if (participants >= 5) discount = 0.10;
    else if (participants >= 3) discount = 0.05;
    
    const total = basePrice * participants * (1 - discount);
    
    document.getElementById('participantCount').textContent = participants;
    document.getElementById('totalPrice').textContent = new Intl.NumberFormat('ru-RU', { 
        style: 'currency', 
        currency: 'USD',
        minimumFractionDigits: 0
    }).format(total);
}

// Form submission
document.getElementById('bookingForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(result.message);
            this.reset();
        } else {
            alert('Ошибка: ' + result.error);
        }
    } catch (error) {
        alert('Произошла ошибка при отправке формы');
    }
});
</script>
