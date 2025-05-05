<?php
// Add class even for timeline
function addClassTimeline()
{
    wp_enqueue_script(
        'timeline-script', // Tên handle
        get_stylesheet_directory_uri() . './assets/js/timeline.js', // Đường dẫn
        array(), // Không cần dependencies
        null, // Không cần version
        true // Đặt ở footer
    );
}
add_action('wp_enqueue_scripts', 'addClassTimeline');
