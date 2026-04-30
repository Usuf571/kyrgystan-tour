<?php
/**
 * Home Controller
 * Handles the main landing page and key homepage sections
 */

namespace App\Controllers;

use App\Models\Tour;
use App\Models\Region;
use App\Models\Attraction;

class HomeController extends Controller {
    
    private Tour $tourModel;
    private Region $regionModel;
    
    public function __construct() {
        parent::__construct();
        $this->tourModel = new Tour();
        $this->regionModel = new Region();
    }
    
    /**
     * Display the homepage
     */
    public function index(): void {
        // Get featured tours
        $featuredTours = $this->tourModel->getFeatured(6);
        
        // Get all active regions
        $regions = $this->regionModel->all(['is_active' => 1], 'sort_order ASC', 7);
        
        // Get popular attractions
        $attractionModel = new Attraction();
        $popularAttractions = $attractionModel->getPopular(6);
        
        // Get latest blog posts
        // $blogModel = new BlogPost();
        // $latestPosts = $blogModel->getLatest(3);
        
        $this->render('home/index', [
            'featured_tours' => $featuredTours,
            'regions' => $regions,
            'popular_attractions' => $popularAttractions,
            'page_title' => 'Discover Kyrgyzstan - Land of Nomads',
            'meta_description' => 'Explore the breathtaking beauty of Kyrgyzstan. Mountain adventures, cultural experiences, and unforgettable journeys in the heart of Central Asia.',
        ]);
    }
}
