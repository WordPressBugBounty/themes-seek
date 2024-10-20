<?php
if ( !class_exists('Seek_Getting_started') ):

    class Seek_Getting_started
    {   

        function __construct()
        {	

	        add_action( 'wp_ajax_seek_install_plugins', array( $this, 'seek_install_plugins' ) );

            // Include required libs for installation
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
            require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
        }

        // Check Plugins Status
        public static function seek_plugin_status($plugin_class, $plugin_folder, $plugin_file){

            if( class_exists( $plugin_class ) ){

                return array('status' => 'active','string' => esc_html__('Deactivate','seek') );

            }else{

                $path = WP_PLUGIN_DIR.'/'.esc_attr( $plugin_folder ).'/'.esc_attr( $plugin_file );

                if( file_exists( $path ) ) {

                    return array('status' => 'deactivate','string' => esc_html__('Activate','seek') );
                }else{

                    return array('status' => 'not-install','string' => esc_html__('Install & Active','seek') );

                }

            }

            return;

        }

        public static function seek_recommended_plugins(){

            return $plugin_lists = array(
                'booster-extension' => array(
                    'PluginFile' => 'booster-extension.php',
                    'class' => 'Booster_Extension_Class',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=booster-extension' ),
                ),
                'mailchimp-for-wp' => array(
                    'PluginFile' => 'mailchimp-for-wp.php',
                    'class' => 'MC4WP_Admin',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/admin.php?page=mailchimp-for-wp' ),
                ),
                'demo-import-kit' => array(
                    'PluginFile' => 'demo-import-kit.php',
                    'class' => 'Demo_Import_Kit_Class',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=demo-import-kit' ),
                ),
                'themeinwp-import-companion' => array(
                    'PluginFile' => 'themeinwp-import-companion.php',
                    'class' => 'Themeinwp_Import_Companion',
                    'setting_page' => esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=themeinwp-import-companion' ),
                ),
            );

        }

        // Install Active Deactive
        public function seek_install_plugins(){
            
            $nonce = isset( $_POST["_wpnonce"] ) ? sanitize_text_field( wp_unslash( $_POST["_wpnonce"] ) ) : '';

            if ( ! current_user_can('install_plugins') ) {
                wp_die( esc_html__( 'Sorry, you are not allowed to install plugins on this site.', 'seek' ) );
            }

            // Check our nonce, if they don't match then bounce!
            if (! wp_verify_nonce( $nonce, 'seek_ajax_nonce' )) {

                wp_die( esc_html__( 'Error - unable to verify nonce, please try again.', 'seek') );

            }

            $plugin_lists = array();

            if( isset( $_POST['single'] ) ){
                
                if( isset( $_POST['PluginStatus'] ) && 
                    isset( $_POST['PluginSlug'] ) && 
                    isset( $_POST['PluginFile'] ) && 
                    isset( $_POST['PluginFolder'] ) && 
                    isset( $_POST['PluginName'] ) &&
                    isset( $_POST['pluginClass'] ) ){

                    $plugin_lists = array(

                        $_POST['PluginSlug'] => array(
                            'PluginFile' => sanitize_text_field( wp_unslash( $_POST['PluginFile'] ) ),
                            'class' => sanitize_text_field( wp_unslash( $_POST['pluginClass'] ) ),
                        )

                    );

                }

            }else{

                $plugin_lists = $this->seek_recommended_plugins();

            }

            foreach( $plugin_lists as $key => $plugin ){

                if( isset( $_POST['single'] ) ){

                    $PluginStatus = sanitize_text_field( wp_unslash( $_POST['PluginStatus'] ) );

                }else{

                    $pluginstatus   = $this->seek_plugin_status( $plugin['class'],$key,$plugin['PluginFile'] );
                    $PluginStatus = $pluginstatus['status'];

                }
                
                $plugin_file    = $plugin['PluginFile'];
                $plugin_dir     = ABSPATH . 'wp-content/plugins/'.esc_html( $key ).'/'.esc_html( $plugin_file );

                if( isset( $_POST['single'] ) && $PluginStatus == 'active' ) {

                    deactivate_plugins( $plugin_dir );
                    esc_html_e('Deactivated' , 'seek');
                    die();

                }elseif( $PluginStatus == 'deactivate' && file_exists($plugin_dir) ) {

                    activate_plugin($plugin_dir);

                    if( isset( $_POST['single'] ) ) {

                        esc_html_e('Activated' , 'seek');
                        die();

                    }

                }elseif( $PluginStatus == 'not-install' ){

                    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

                    $plugin_info = plugins_api(
                        'plugin_information',
                        array(
                            'slug'   => sanitize_key( wp_unslash( $key ) ),
                            'fields' => array(
                                'sections' => false,
                            ),
                        )
                    );

                    $skin     = new WP_Ajax_Upgrader_Skin();
                    $upgrader = new Plugin_Upgrader( $skin );
                    $upgrader->install($plugin_info->download_link);
                    $plugin_file = esc_html($key).'/'.esc_html($plugin_file);
                    
                    if( file_exists($plugin_dir) ) {

                        activate_plugin($plugin_dir);

                        if( isset( $_POST['single'] ) ) {
                            esc_html_e('Installed & Activated' , 'seek');
                            die();
                        }

                    }

                    if( isset( $_POST['single'] ) ) {

                        esc_html_e('Failed' , 'seek');
                        die();

                    }

                }else{

                    if( isset( $_POST['single'] ) ) {

                        esc_html_e('Failed' , 'seek');
                        die();

                    }

                }

            }

            if( !isset( $_POST['single'] ) ) {
                echo esc_url( get_home_url(null, '/').'wp-admin/themes.php?page=seek-about' );
            }

            die();

        }

    }

    new Seek_Getting_started();

endif;