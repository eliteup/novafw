<?php
/**
 * The Shortcode
 */
function novafw_product_list_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "block_title" => '',
        "shortcode" => '',
        "show_type" => 'slider',
        "columns_2" => '4',
        "columns_3" => '4',
        "columns_4" => '2',
        "columns_5" => '2',
        "show_action" => 'yes',
        "style" => 'style_default'
    ), $atts));
    $sliderrandomid = rand();
    if($shortcode !== ''){
        $new_shortcode = rawurldecode( base64_decode( strip_tags( $shortcode ) ) );
    }
    $pattern = get_shortcode_regex();
    $shortcode_str = $short_atts = '';
    preg_match_all("/".$pattern."/",$new_shortcode,$matches);
    $shortcode_str = str_replace('"','',str_replace(" ","&",trim($matches[3][0])));
    $short_atts = parse_str($shortcode_str);//explode("&",$shortcode_str);
    if(isset($matches[2][0])): $display_type = $matches[2][0]; else: $display_type = ''; endif;
    if(!isset($columns)): $columns = '4'; endif;
    if(isset($per_page)): $post_count = $per_page; endif;
    if(isset($number)): $post_count = $number; endif;
    if(!isset($order)): $order = 'asc'; endif;
    if(!isset($orderby)): $orderby = 'date'; endif;
    if(!isset($category)): $category = ''; endif;
    if(!isset($ids)): $ids = ''; endif;
    if($ids){
        $ids = explode( ',', $ids );
        $ids = array_map( 'trim', $ids );
    }
    $meta_query = '';
    if ($display_type == "recent_products") {
        $meta_query = WC()->query->get_meta_query();
    }
    if ($display_type == "featured_products") {
        $meta_query = array(
            array(
                'key' => '_visibility',
                'value' => array('catalog', 'visible'),
                'compare' => 'IN'
            ),
            array(
                'key' => '_featured',
                'value' => 'yes'
            )
        );
    }
    if ($display_type == "top_rated_products") {
        add_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
        $meta_query = WC()->query->get_meta_query();
    }
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'posts_per_page' => $post_count,
        'orderby' => $orderby,
        'order' => $order,
        'paged' => '',
        'meta_query' => $meta_query
    );
    if ($display_type == "sale_products") {
        $product_ids_on_sale = wc_get_product_ids_on_sale();
        $meta_query = array();
        $meta_query[] = WC()->query->visibility_meta_query();
        $meta_query[] = WC()->query->stock_status_meta_query();
        $args['meta_query'] = $meta_query;
        $args['post__in'] = $product_ids_on_sale;
    }
    if ($display_type == "best_selling_products") {
        $args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
        $args['meta_query'] = array(
            array(
                'key' => '_visibility',
                'value' => array('catalog', 'visible'),
                'compare' => 'IN'
            )
        );
    }
    if ($display_type == "product_category") {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'terms' => array(esc_attr($category)),
                'field' => 'slug',
                'operator' => 'IN'
            )
        );
    }
    if ($display_type == "product_categories") {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'terms' => $ids,
                'field' => 'term_id',
                'operator' => 'IN'
            )
        );
    }
    $query = new WP_Query($args);
    ob_start();
    ?>
    <?php if($show_type == 'slider'):?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#thebear-products-slider-<?php echo esc_attr($sliderrandomid) ?>").owlCarousel({
                items:<?php echo esc_attr($columns) ?>,
                itemsDesktop : [1200,<?php echo esc_attr($columns_2)?>],
                itemsDesktopSmall : [1170,<?php echo esc_attr($columns_3)?>],
                itemsTablet: [768,<?php echo esc_attr($columns_4)?>],
                itemsMobile : [640,<?php echo esc_attr($columns_5)?>],
                lazyLoad : true,
                navigation:true,
                navigationText : ["<span class=\"novafw-icon-arrow icon-arrows-left\"></span>","<span class=\"novafw-icon-arrow icon-arrows-right\"></span>"],
                pagination : false,
            });
        });
    </script>
    <div class="thebear_products_slider woocommerce preset_<?php echo esc_attr($style)?>">
        <?php if($block_title):?>
            <div class="woo-custom-title">
                <h2><?php echo esc_html($block_title)?></h2>
            </div>
        <?php endif;?>
        <div id="thebear-products-slider-<?php echo esc_attr($sliderrandomid) ?>" class="products-grid owl-carousel products product product_slider_theme auto_hidden">
            <?php if($query->have_posts()): ?>
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php endwhile; ?>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>
    <?php
    wp_reset_query();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode("thebear_products_list", "novafw_product_list_shortcode");

/**
 * The VC Functions
 */
function novafw_product_list_shortcode_vc()
{
    vc_map(array(
        "name" => esc_html__('Product List', 'thebear'),
        "category" => esc_html__('Thebear WP Theme', 'thebear'),
        "description" => esc_html__('Display products', 'thebear'),
        "base" => "thebear_products_list",
        "class" => "",
        "icon" => "thebear-vc-block",


        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "hide_in_vc_editor",
                "admin_label" => true,
                "heading" => esc_html__("Title", "thebear"),
                "param_name" => "block_title",
                "value" => ""
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Display Type", "thebear"),
                "param_name" => "show_type",
                "value" => array(
                    "Slider" => "slider"
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Display Style", "thebear"),
                "param_name" => "style",
                "value" => array(
                    "Style 1" => "",
                    "Style 2" => "style_2"
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "hide_in_vc_editor",
                "admin_label" => true,
                "heading" => "Show Product Action?",
                "param_name" => "show_action",
                "value" => array(
                    "Yes" => "yes",
                    "No" => "no"
                ),
                "std" => "yes"
            ),
            array(
                "type" => "woocomposer",
                "class" => "",
                "heading" => esc_html__("Query Builder", "thebear"),
                "param_name" => "shortcode",
                "value" => "",
                "module" => "grid",
                "labels" => array(
                    "products_from" => esc_html__("Display:", "thebear"),
                    "per_page" => esc_html__("How Many:", "thebear"),
                    "columns" => esc_html__("Columns:", "thebear"),
                    "order_by" => esc_html__("Order By:", "thebear"),
                    "order" => esc_html__("Display Order:", "thebear"),
                    "category" => esc_html__("Category:", "thebear"),
                ),
                "group" => esc_html__("Initial Settings", "thebear"),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "hide_in_vc_editor",
                "admin_label" => true,
                "heading" => esc_html__("Colums for Desktop", "thebear"),
                "param_name" => "columns_2",
                "value" => "4",
                "description" => esc_html__("Number of columns for posts to be displayed in desktop.", "thebear"),
                "group" => esc_html__("Slider Settings", "thebear"),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "hide_in_vc_editor",
                "admin_label" => true,
                "heading" => esc_html__("Colums for Small Desktop", "thebear"),
                "param_name" => "columns_3",
                "value" => "4",
                "description" => esc_html__("Number of columns for posts to be displayed in small desktop.", "thebear"),
                "group" => esc_html__("Slider Settings", "thebear"),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "hide_in_vc_editor",
                "admin_label" => true,
                "heading" => esc_html__("Colums for Tablet", "thebear"),
                "param_name" => "columns_4",
                "value" => "2",
                "description" => esc_html__("Number of columns for posts to be displayed in Tablet.", "thebear"),
                "group" => esc_html__("Slider Settings", "thebear"),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "hide_in_vc_editor",
                "admin_label" => true,
                "heading" => esc_html__("Colums for Mobile", "thebear"),
                "param_name" => "columns_5",
                "value" => "2",
                "description" => esc_html__("Number of columns for posts to be displayed in Mobile.", "thebear"),
                "group" => esc_html__("Slider Settings", "thebear"),
            ),

        )

    ));
}
add_action( 'vc_before_init', 'novafw_product_list_shortcode_vc' );