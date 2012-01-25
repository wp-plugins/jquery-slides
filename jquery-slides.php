<?php

/*
  Plugin Name: jQuery Slides
  Description: jQuery slides with customization options. Based on jQuery Slider by Vijay Kumar.
  Author: Paweł Szczekutowicz
  Version: 1.0.1

  Copyright 2011  Paweł Szczekutowicz  (email : pszczekutowicz@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

include_once 'settings.php';

// Activating plugin
register_activation_hook(__FILE__, 'slides_activate');

function slides_activate() {
    add_option('slides_width', '964');
    add_option('slides_height', '340');
    add_option('slides_pause', 'true');
    add_option('slides_pagination', 'true');
    add_option('slides_navigation', 'false');
    add_option('slides_delay', '5');
    add_option('slides_pause_delay', '10');
    add_option('slides_effect', 'fade');
    add_option('slides_crossfade', 'true');
    add_option('slides_class_prefix', '');
}

/* Slider Post Types */
add_action('init', 'slides_custom_init');

function slides_custom_init() {
    $labels = array(
        'name' => _x('Slides', 'post type general name'),
        'singular_name' => _x('Slide', 'post type singular name'),
        'add_new' => _x('Add New', 'slide'),
        'add_new_item' => __('Add New Slide'),
        'edit_item' => __('Edit Slide'),
        'new_item' => __('New Slide'),
        'view_item' => __('View Slide'),
        'search_items' => __('Search Slides'),
        'not_found' => __('No slides found'),
        'not_found_in_trash' => __('No slides found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Slides'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => array('title', 'editor', 'custom-fields', 'thumbnail')
    );
    register_post_type('slide', $args);
}

// Load javascripts and css files
if (!is_admin()) {
    add_action('wp_print_scripts', 'slides_load_js');

    function slides_load_js() {
        wp_enqueue_script('jquery', plugins_url('js/jquery.min.js', __FILE__));
        wp_enqueue_script('jquerySlides', plugins_url('js/jquery.slides.min.js', __FILE__), array('jquery'));
    }

    add_action('wp_head', 'slides_head_code');
    function slides_head_code() {
        $classPrefix = get_option('slides_class_prefix');
        $html = "<script type='text/javascript'>
    jQuery(document).ready(function(){
        jQuery('." . $classPrefix . "slides').slides({
            preload: true,
            preloadImage: '" . plugins_url('images/loading.gif', __FILE__) . "',
            generatePagination: " . get_option('slides_pagination') . ",
            generateNextPrev: " . get_option('slides_navigation') . ",
            play: " . (get_option('slides_delay') * 1000) . ",
            pause: " . (get_option('slides_pause_delay') * 1000) . ",
            hoverPause: " . get_option('slides_pause') . ",
            effect: '" . get_option('slides_effect') . "',
            crossfade: " . get_option('slides_crossfade') . ",
            container: '" . $classPrefix . "slides-container',
            paginationClass: '" . $classPrefix . "slides-pagination'
        });
    });</script>";
        echo $html;
    }

}

function jquery_slides() {
    global $post;

    $qry = new WP_Query('post_type=slide&showposts=-1');
    if ($qry->have_posts()):
        $classPrefix = get_option('slides_class_prefix');
        $html = '<div class="'.$classPrefix.'slides"><div class="'.$classPrefix.'slides-container" style="width: ' . get_option('slides_width') . 'px; height: ' . get_option('slides_height') . 'px">';
        while ($qry->have_posts()) : $qry->the_post();
            $html .= '<div class="'.$classPrefix.'slides-item">';
            $html .= '<div class="'.$classPrefix.'caption">' . get_the_content($post->ID) . '</div>';
            $thumbnail_id = get_post_thumbnail_id($post->ID);
            if ($thumbnail_id) {
                $html .= wp_get_attachment_image($thumbnail_id, 'full');
            } else {
                $images = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999));
                if ($images) {
                    $image = array_shift($images);
                    $html .= wp_get_attachment_image($image->ID, 'full');
                }
            }
            $html .= '</div>';
        endwhile;
        $html .= '</div></div>';
    endif;
    wp_reset_postdata();

    return $html;
}

add_shortcode('jQuery Slides', 'jquery_slides');
add_theme_support('post-thumbnails');
