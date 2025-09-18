<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */  

add_action( 'wp_enqueue_scripts', 'park_dos_lagos_style' );
				function park_dos_lagos_style() {
					wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
					wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style') );
				}

/**
 * Your code goes below.
 */
function load_read_more_script() {
    wp_enqueue_script('read-more', get_template_directory_uri() . '/js/read-more.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'load_read_more_script');

