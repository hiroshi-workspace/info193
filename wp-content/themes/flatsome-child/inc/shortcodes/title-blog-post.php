<?php
function get_title_permalink($atts)
{
    // Thiết lập thuộc tính mặc định
    $atts = shortcode_atts(array(
        'id' => get_the_ID(), // nếu không truyền id thì lấy bài hiện tại
    ), $atts, 'post_info');

    // Lấy bài viết
    $post = get_post($atts['id']);
    if (! $post) return 'Bài viết không tồn tại.';

    $title = esc_html(get_the_title($post));
    $date =  get_the_date('d-m-Y');


    $html = '
    <h1 class="title-single-post">' . $title . '</h1>
    <div class="post-meta date-custom normal"><i class="fa-regular fa-calendar-days"></i>' . $date . ' </div>
    <div class="is-divider divider-full"></div>
    ';
    return $html;
}
add_shortcode('post_info', 'get_title_permalink');
