<?php
/*
    Plugin Name: Slider - Anh Kevin
    Description: Simple slideshow
    Author: Phan Tien Anh - anhkevin.ht@gmail.com
    Version: 1.0
*/

function np_init() {
    $args = array(
        'public' => true,
        'label' => 'Slider',
        'supports' => array(
            'title',
            'thumbnail',
        ),
        'menu_icon' => 'dashicons-images-alt2',
    );
    register_post_type('np_images', $args);
}
add_action('init', 'np_init');

function np_register_scripts_np_images() {
    if('np_images' == get_post_type()) {
        // Script
        //wp_enqueue_script('np_script_print_template1', plugins_url( 'js/script.js', __FILE__ ));

        // Style
        wp_enqueue_style('np_style_print_template1', plugins_url( 'style.css', __FILE__ ));
    }
}
add_action('admin_enqueue_scripts', 'np_register_scripts_np_images');

/** Khai báo meta box **/
function meta_slider_meta_box()
{
    add_meta_box( 'meta-slider-link', 'Link', 'meta_slider_link', 'np_images');
}
add_action( 'add_meta_boxes', 'meta_slider_meta_box' );

/**
* Lưu dữ liệu meta box khi nhập vào
* @param post_id là ID của post hiện tại
**/
function meta_slider_template_save( $post_id )
{
    update_post_meta( $post_id, '_slider_link', sanitize_text_field( $_POST['_slider_link'] ) );
}
add_action( 'save_post', 'meta_slider_template_save' );

function meta_slider_link($post){
    $data_value = get_post_meta( $post->ID, '_slider_link', true );
    echo ( '<input style="width:100%;" type="text" id="_slider_link" name="_slider_link" value="'.$data_value.'" />');
}

// add short code
function np_function($type='np_function') {
    $args = array(
        'post_type' => 'np_images',
        'posts_per_page' => 10
    );
    $result = '<div class="rev_slider_wrapper">';
    $result .= '<div id="rev_slider_1" class="rev_slider" data-version="5.0">';
    $result .= '<ul>';

    //the loop
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
        $the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
        $result .= '<li data-transition="fade">
        <img src="'.$the_url[0].'"  width="1920" height="330">
        <div class="tp-caption shop-trangchu4 tp-resizeme rs-parallaxlevel-0"
             data-x="right" data-hoffset="100"
             data-y="top" data-voffset="260"
             data-transform_idle="o:1;"
             data-transform_in="o:0"
             data-transform_out="o:0"
             data-mask_out="x:inherit;y:inherit;"
             data-start="500"><a href="'.(isset(get_post_custom($post->ID)['_slider_link'][0]) ? get_post_custom($post->ID)['_slider_link'][0] : "") .'" > Chi tiết 
            <i class="fa fa-chevron-circle-right">
            </i></a></div></li>';
    }

    $result .= '</ul>';
    $result .= '</div>';
    $result .= '</div>';
    $result .= '<script>
    var revapi;
    jQuery(document).ready(function () {
      revapi = jQuery("#rev_slider_1").revolution({
        sliderType: "standard",
        sliderLayout: "fullwidth",
        delay: 9000,
        disableProgressBar: "on",
        navigation: {
          keyboardNavigation: "off",
          keyboard_direction: "horizontal",
          mouseScrollNavigation: "off",
          onHoverStop: "off",
          bullets: {
            enable: true,
            hide_onmobile: true,
            hide_under: 778,
            style: "hermes",
            hide_onleave: false,
            direction: "horizontal",
            h_align: "center",
            v_align: "bottom",
            h_offset: 0,
            v_offset: 20,
            space: 5,tmp: ""},arrows: {style: "erinyen",enable: false,hide_onmobile: true,hide_under: 600, hide_onleave: true,hide_delay: 200,hide_delay_mobile: 1200,left: {h_align: "center",v_align: "center",h_offset: -530,v_offset: 0},right: {h_align: "center",v_align: "center",h_offset: 530,v_offset: 0}}},gridwidth: 1230,gridheight: 330});});</script>';

    return $result;
}

add_shortcode('anh-slider-shortcode', 'np_function');

