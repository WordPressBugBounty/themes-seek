<?php

/**
 * Seek About Page
 * @package Seek
 *
*/

if( !class_exists('Seek_About_page') ):

	class Seek_About_page{

		function __construct(){

			add_action('admin_menu', array($this, 'seek_backend_menu'),999);

		}

		// Add Backend Menu
        function seek_backend_menu(){

            add_theme_page(esc_html__( 'Seek','seek' ), esc_html__( 'Seek','seek' ), 'activate_plugins', 'seek-about', array($this, 'seek_main_page'),1);

        }

        // Settings Form
        function seek_main_page(){

            require get_template_directory() . '/classes/about-render.php';

        }

	}

	new Seek_About_page();

endif;