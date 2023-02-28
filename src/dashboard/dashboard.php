<?php
/**
 * Gold Live Backend DashBoard
 * 
 * @since 1.0.0
 */

class Hnsbrg_Backend_Dashboard {
    // Constructor
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'hnsbrg_dashboard' ) );
    }

    public function hnsbrg_dashboard() {
    }
}

new Hnsbrg_Backend_Dashboard();