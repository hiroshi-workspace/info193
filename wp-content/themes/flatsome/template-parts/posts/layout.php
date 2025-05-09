<?php

/**
 * Posts layout.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

do_action('flatsome_before_blog');
?>

<?php if (!is_single() && get_theme_mod('blog_featured', '') == 'top') {
	get_template_part('template-parts/posts/featured-posts');
} ?>
<div class="row align-center">
	<div class="large-10 col custom-single-blog">
		<!-- Call my shortcode -->
		<?php echo do_shortcode('[post_info]');?>
		<?php if (!is_single() && get_theme_mod('blog_featured', '') == 'content') {
			get_template_part('template-parts/posts/featured-posts');
		} ?>

		<?php
		if (is_single()) {
			get_template_part('template-parts/posts/single');
			comments_template();
		} elseif (get_theme_mod('blog_style_archive', '') && (is_archive() || is_search())) {
			get_template_part('template-parts/posts/archive', get_theme_mod('blog_style_archive', ''));
		} else {
			get_template_part('template-parts/posts/archive', get_theme_mod('blog_style', 'normal'));
		}
		?>
	</div>

</div>
<?php echo do_shortcode('[block id="bai-viet-gan-day"]');?>

<?php do_action('flatsome_after_blog');
