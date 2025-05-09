<?php

// [featured_items_slider]
function flatsome_portfolio_shortcode($atts, $content = null, $tag = '' ) {

  extract(shortcode_atts(array(
        // meta
        'filter' => '',
        'filter_nav' => 'line-grow',
        'filter_align' => 'center',
        '_id' => 'portfolio-'.rand(),
        'link' => '',
        'class' => '',
        'visibility' => '',
        'orderby' => 'menu_order',
        'order' => '',
        'offset' => '',
        'exclude' => '',
        'number'  => '999',
        'ids' => '',
        'cat' => '',
        'lightbox' => '',
        'lightbox_image_size' => 'original',

        // Layout
        'style' => '',
        'columns' => '4',
        'columns__sm' => '',
        'columns__md' => '',
        'col_spacing' => 'small',
        'type' => 'slider', // slider, row, masonery, grid
        'width' => '',
        'grid' => '1',
        'grid_height' => '600px',
        'grid_height__md' => '500px',
        'grid_height__sm' => '400px',
        'slider_nav_style' => 'reveal',
        'slider_nav_position' => '',
        'slider_nav_color' => '',
        'slider_bullets' => 'false',
        'slider_arrows' => 'true',
        'auto_slide' => 'false',
        'infinitive' => 'true',
        'depth' => '',
        'depth_hover' => '',

         // Box styles
        'animate' => '',
        'text_pos' => '',
        'text_padding' => '',
        'text_bg' => '',
        'text_color' => '',
        'text_hover' => '',
        'text_align' => 'center',
        'text_size' => '',
        'image_size' => 'medium',
        'image_mask' => '',
        'image_width' => '',
        'image_radius' => '',
        'image_height' => '100%',
        'image_hover' => '',
        'image_hover_alt' => '',
        'image_overlay' => '',

        // Deprecated
        'height' => '',
), $atts));

	ob_start();

  if($height && !$image_height) $image_height = $height;

	// Get Default Theme style.
	if ( ! $style ) $style = get_theme_mod( 'portfolio_style', '' );

  // Fix old
  if($tag == 'featured_items_slider') $type = 'slider';

	// Set Classes.
	$wrapper_class = array( 'portfolio-element-wrapper', 'has-filtering' );
	$classes_box   = array( 'portfolio-box', 'box', 'has-hover' );
	$classes_image = array();
	$classes_text  = array( 'box-text' );

  // Fix Grid type
  if($type == 'grid'){
    $columns = 0;
    $current_grid = 0;
    $grid = flatsome_get_grid($grid);
    $grid_total = count($grid);
    flatsome_get_grid_height($grid_height, $_id);
  }

	// Wrapper classes.
	if ( $visibility ) $wrapper_class[] = $visibility;

  // Set box style
  if($style) $classes_box[] = 'box-'.$style;
  if($style == 'overlay') $classes_box[] = 'dark';
  if($style == 'shade') $classes_box[] = 'dark';
  if($style == 'badge') $classes_box[] = 'hover-dark';
  if($text_pos) $classes_box[] = 'box-text-'.$text_pos;
  if($style == 'overlay' && !$image_overlay) $image_overlay = true;

  // Set image styles
  if($image_hover)  $classes_image[] = 'image-'.$image_hover;
  if($image_hover_alt)  $classes_image[] = 'image-'.$image_hover_alt;
  if($image_height)  $classes_image[] = 'image-cover';

  // Text classes
  if($text_hover) $classes_text[] = 'show-on-hover hover-'.$text_hover;
  if($text_align) $classes_text[] = 'text-'.$text_align;
  if($text_size) $classes_text[] = 'is-'.$text_size;
  if($text_color == 'dark') $classes_text[] = 'dark';

  $css_col = array(
    array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%'),
  );

  $css_args_img = array(
    array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%'),
    array( 'attribute' => 'width', 'value' => $image_width, 'unit' => '%' ),
  );

  $css_image_height = array(
    array( 'attribute' => 'padding-top', 'value' => $image_height),
  );

  $css_args = array(
        array( 'attribute' => 'background-color', 'value' => $text_bg ),
        array( 'attribute' => 'padding', 'value' => $text_padding ),
  );


 if($animate) {$animate = 'data-animate="' . esc_attr( $animate ) . '"';}

 echo '<div id="' . esc_attr( $_id ) . '" class="' . esc_attr( implode( ' ', $wrapper_class ) ) . '">';

 // Add filter
 if($filter && $filter != 'disabled' && empty($cat) && $type !== 'grid' && $type !== 'slider' && $type !== 'full-slider'){
  // TODO: Get categories for filtering.
  wp_enqueue_script('flatsome-isotope-js');
  ?>
  <div class="container mb-half">
  <ul class="nav nav-<?php echo esc_attr( $filter ); ?> nav-<?php echo esc_attr( $filter_align ); ?> nav-<?php echo esc_attr( $filter_nav ); ?> nav-uppercase filter-nav">
    <li class="active"><a href="#" data-filter="*"><?php echo esc_html__( 'All','flatsome' ); ?></a></li>
    <?php
      $tax_terms = get_terms('featured_item_category');
      foreach ($tax_terms as $key => $value) {
         ?><li><a href="#" data-filter="[data-terms*='<?php echo "&quot;" . esc_attr( $value->name ) . "&quot;"; ?>']"><?php echo wp_kses_post( $value->name ); ?></a></li><?php
      }
    ?>
  </ul>
  </div>
  <?php
} else{
  $filter = false;
}

// Repeater options
$repeater['id'] = $_id;
$repeater['tag'] = $tag;
$repeater['type'] = $type;
$repeater['style'] = $style;
$repeater['class'] = $class;
$repeater['visibility'] = $visibility;
$repeater['slider_style'] = $slider_nav_style;
$repeater['slider_nav_color'] = $slider_nav_color;
$repeater['slider_nav_position'] = $slider_nav_position;
$repeater['slider_bullets'] = $slider_bullets;
$repeater['auto_slide'] = $auto_slide;
$repeater['infinitive'] = $infinitive;
$repeater['row_spacing'] = $col_spacing;
$repeater['row_width'] = $width;
$repeater['columns'] = $columns;
$repeater['columns__sm'] = $columns__sm;
$repeater['columns__md'] = $columns__md;
$repeater['depth'] = $depth;
$repeater['depth_hover'] = $depth_hover;
$repeater['filter'] = $filter;

global $wp_query;

$args = array(
  'post_type' => 'featured_item',
);

// Exclude

// If custom Ids
if ( isset( $atts['ids'] ) ) {
  $ids = explode( ',', $atts['ids'] );
  $ids = array_map( 'trim', $ids );
  $args['post__in'] = $ids;
  $args['posts_per_page'] = -1;
  $args['orderby'] = 'post__in';
} else {
  $args['offset'] = $offset;
  $args['order'] = $order;
  $args['orderby'] = $orderby;
  if($exclude) $args['post__not_in'] = explode( ',', $exclude );
  $args['posts_per_page'] = $number;
  if ( !empty( $atts['cat'] ) ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'featured_item_category',
        'field' => 'id',
        'terms' => $cat,
      ),
    );
  }
}

$wp_query = new WP_Query( $args );

// Get repeater structure
get_flatsome_repeater_start($repeater);

 ?>
  <?php

        if ( $wp_query->have_posts() ) :

        while ($wp_query->have_posts()) : $wp_query->the_post();
          $link = get_permalink(get_the_ID());

          $has_lightbox = '';
          if($lightbox == 'true'){
            $link = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $lightbox_image_size );
            $link = $link ? $link[0] : '';
            $has_lightbox = 'lightbox-gallery';
          }

          $image = get_post_thumbnail_id();
          $classes_col = array('col');

          // Add Columns for Grid style
          if($type == 'grid'){
              if($grid_total > $current_grid) $current_grid++;
              $current = $current_grid-1;

              $classes_col[] = 'grid-col';
              if($grid[$current]['height']) $classes_col[] = 'grid-col-'.$grid[$current]['height'];

              if($grid[$current]['span']) $classes_col[] = 'large-'.$grid[$current]['span'];
              if($grid[$current]['md']) $classes_col[] = 'medium-'.$grid[$current]['md'];

              // Set image size
              if($grid[$current]['size']) $image_size = $grid[$current]['size'];
          }

          ?><div class="<?php echo esc_attr( implode( ' ', $classes_col ) ); ?>" data-terms="<?php echo strip_tags( get_the_term_list( get_the_ID(), 'featured_item_category', "[&quot;", "&quot;,&quot;", "&quot;]" ) ); ?>" <?php echo $animate; ?>>
          <div class="col-inner" <?php echo get_shortcode_inline_css($css_col); ?>>
          <a href="<?php echo esc_url( $link ); ?>" class="plain <?php echo $has_lightbox; ?>">
          <div class="<?php echo esc_attr( implode( ' ', $classes_box ) ); ?>">
            <div class="box-image" <?php echo get_shortcode_inline_css( $css_args_img ); ?>>
                <div class="<?php echo esc_attr( implode( ' ', $classes_image ) ); ?>" <?php echo get_shortcode_inline_css($css_image_height); ?>>
                <?php echo wp_get_attachment_image($image, $image_size); ?>
                <?php if($image_overlay) { ?><div class="overlay" style="background-color:<?php echo esc_attr( $image_overlay ); ?>"></div><?php } ?>
                <?php if($style == 'shade'){ ?><div class="shade"></div><?php } ?>
                </div>
            </div>
            <div class="<?php echo esc_attr( implode( ' ', $classes_text ) ); ?>" <?php echo get_shortcode_inline_css( $css_args ); ?>>
                  <div class="box-text-inner">
                      <h6 class="uppercase portfolio-box-title"><?php the_title(); ?></h6>
                      <p class="uppercase portfolio-box-category is-xsmall op-6">
                        <span class="show-on-hover">
                         <?php  echo strip_tags( get_the_term_list( get_the_ID(), 'featured_item_category', "",", " ) );?>
                        </span>
                      </p>
                  </div>
            </div>
           </div>
           </a>
           </div>
           </div><?php
          endwhile;
          endif;
          wp_reset_query();

  get_flatsome_repeater_end($repeater);
  echo '</div>';

  $args = array(
   'image_width' => array(
      'selector' => '.box-image',
      'property' => 'width',
      'unit' => '%',
    ),
   'text_padding' => array(
      'selector' => '.box-text',
      'property' => 'padding',
    ),
  );
  echo ux_builder_element_style_tag($_id, $args, $atts);

  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}
add_shortcode("featured_items_slider", "flatsome_portfolio_shortcode");
add_shortcode("featured_items_grid", "flatsome_portfolio_shortcode");
add_shortcode("ux_portfolio", "flatsome_portfolio_shortcode");
