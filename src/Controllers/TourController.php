<?php
/**
 * Tour Controller
 * Handles tour listing, filtering, and details pages
 */

namespace App\Controllers;

use App\Models\Tour;
use App\Models\Region;
use App\Models\Booking;

class TourController extends Controller {
    
    private Tour $tourModel;
    private Region $regionModel;
    
    public function __construct() {
        parent::__construct();
        $this->tourModel = new Tour();
        $this->regionModel = new Region();
    }
    
    /**
     * Display tours listing with filters
     */
    public function index(): void {
        $page = max(1, (int) $this->get('page', 1));
        $perPage = 12;
        
        // Build filters from GET parameters
        $filters = [
            'category' => $this->get('category'),
            'difficulty' => $this->get('difficulty'),
            'min_price' => $this->get('min_price'),
            'max_price' => $this->get('max_price'),
            'min_duration' => $this->get('min_duration'),
            'max_duration' => $this->get('max_duration'),
            'region_id' => $this->get('region'),
            'search' => $this->get('search'),
            'sort' => $this->get('sort', 'created_at'),
        ];
        
        // Remove empty filters
        $filters = array_filter($filters, fn($v) => $v !== null && $v !== '');
        
        // Get filtered tours
        $toursData = $this->tourModel->search($filters, $page, $perPage);
        
        // Get all regions for filter dropdown
        $regions = $this->regionModel->all(['is_active' => 1], 'name_ru ASC');
        
        // Get categories
        $categories = $this->tourModel->getCategories();
        
        $this->render('tours/index', [
            'tours' => $toursData['data'],
            'pagination' => [
                'current_page' => $toursData['current_page'],
                'last_page' => $toursData['last_page'],
                'total' => $toursData['total'],
            ],
            'filters' => $filters,
            'regions' => $regions,
            'categories' => $categories,
            'page_title' => 'Tours & Adventures in Kyrgyzstan',
            'meta_description' => 'Browse our curated selection of tours across Kyrgyzstan. From mountain treks to cultural experiences.',
        ]);
    }
    
    /**
     * Display single tour details
     */
    public function show(string $slug): void {
        $tour = $this->tourModel->findBySlug($slug);
        
        if (!$tour) {
            http_response_code(404);
            $this->render('errors/404', ['page_title' => 'Tour Not Found']);
            return;
        }
        
        // Calculate price range for booking
        $basePrice = (float) $tour['price_from'];
        
        $this->render('tours/show', [
            'tour' => $tour,
            'base_price' => $basePrice,
            'page_title' => $tour["title_{$this->currentLocale}"] . ' | Discover Kyrgyzstan',
            'meta_description' => $tour["short_description_{$this->currentLocale}"] ?? '',
            'og_image' => !empty($tour['images'][0]['image_path']) ? $tour['images'][0]['image_path'] : null,
        ]);
    }
}
