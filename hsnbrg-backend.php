<?php
/**
 * Plugin Name: Hnsbrg Backend
 * Plugin URI: https://github.com/WordPress/gutenberg
 * Description: Backend plugin for Hnsbrg
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Version: 1.0.0
 * Author: Eugene Lee
 * Text Domain: hnsbrg-backend
 *
 * @package hnsbrg
 */

define( 'HNSBRG_PLUGIN_DIR', __DIR__ );
define( 'HNSBRG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'HNSBRG_PLUGIN_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets' );
define( 'HNSBRG_PLUGIN_VENDOR_URL', plugin_dir_url( __FILE__ ) . 'assets/vendor' );

// Functions Library
include_once( HNSBRG_PLUGIN_DIR . '/functions.php' );

if ( ! class_exists( 'Hnsbrg_Backend' ) ) {
    class Hnsbrg_Backend {
        public function __construct() {
            // Add Menu Page
            // add_action( 'admin_menu', array( $this, 'menu' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'backend_enqueue_scripts' ) ); 
            add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue_scripts' ) );     

            // Initialize Databse.
            $this->init();
            
            // Main Dashboard
            include_once( HNSBRG_PLUGIN_DIR . '/src/dashboard/dashboard.php' );
            # Ads List
            include_once( HNSBRG_PLUGIN_DIR . '/src/frontend/hnsbrg-ads-frontend.php' );
            include_once( HNSBRG_PLUGIN_DIR . '/src/backend/hnsbrg-ads-backend.php' );
        }

        public function backend_enqueue_scripts() {
            // wp_enqueue_style( 'hnsberg_backend', plugins_url( 'hnsbrg-backend/assets/css/style.css' ), array(), '1.0.0', NULL);
        }

        public function frontend_enqueue_scripts() {
            // wp_enqueue_style( 'hnsberg_frontend', plugins_url( 'hnsbrg-backend/assets/css/frontend.css' ), array(), '1.0.0', NULL);
        }

        public function init() {
            // Order List Datbase Initialize.
            init_advertisement_db();
        }

        public function menu() {
            add_menu_page( 
                esc_html__( 'Hnsberg Ads', 'hnsbrg-backend' ),
                esc_html__( 'Hnsberg Ads', 'hnsbrg-backend' ),
                'manage_options',
                'hnsberg_menu',
                array( $this, 'dashboard' ),
                'dashicons-format-gallery',
                6
            );
        }

        public function dashboard() { 
        }
    }
}

new Hnsbrg_Backend();
