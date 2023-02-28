<?php
/**
 * Hnsbrg Advertisement Backend
 * 
 * @since 1.0.0
 */
if ( ! class_exists( 'Hnsbrg_Ads_List' ) ) {
    class Hnsbrg_Ads_List {
        public $positions;

        public $status;

        public function __construct() {
            delete_expired_ads();
            $this->positions = get_ads_data();

            $this->status = array(
                '0' => esc_html__( 'Pending', 'hnsbrg-backend' ),
                '1' => esc_html__( 'Approved', 'hnsbrg-backend' ),
                '2' => esc_html__( 'Declined', 'hnsbrg-backend' ),
            );

            add_action( 'admin_menu', array( $this, 'submenu' ), 99 );

            // Enqueue Scripts & Stypes.
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

            // Ajax Request
            // add_action('wp_ajax_ads_save', array( $this, 'save' ));
            // add_action('wp_ajax_nopriv_ads_save', array( $this, 'save' ));
            add_action('wp_ajax_ads_remove', array( $this, 'delete' ));

            $this->save();
        }

        public function admin_enqueue() {
            wp_enqueue_media();
            wp_enqueue_style( 'hnsbrg-admin-ads', HNSBRG_PLUGIN_ASSETS_URL . '/css/style.css', array(), 1.0 );
            wp_enqueue_script( 'wp-media-uploader', HNSBRG_PLUGIN_ASSETS_URL . '/js/wp_media_uploader.js', array( 'jquery' ), 1.0 );
            wp_enqueue_script( 'hnsbrg-admin-ads', HNSBRG_PLUGIN_ASSETS_URL . '/js/backend.js', array( 'jquery', 'jquery-ui-dialog' ), 1.0 );
            wp_localize_script( 'hnsbrg-admin-ads', 'hnsbrgAdminAds', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('hnsbrg-admin-ads'),
                'ads' => get_ads_order_items(),
                'positions' => array_reduce($this->positions, function ($arr, $element) {
                    if (empty($arr)) {
                        $arr = [];
                    } 
                    return array_merge($arr, array_values($element));
                }),
            ) );
        }

        public function enqueue() {
        }

        public function submenu() {
            add_menu_page( 
                esc_html__( 'Ads', 'hnsbrg-backend' ),
                esc_html__( 'Ads', 'hnsbrg-backend' ),
                'manage_options',
                'hnsberg_ads_list',
                array($this, 'page'),
                'dashicons-format-gallery',
                6
            );
        }

        private function save() {
            // check_ajax_referer( 'hnsbrg-admin-ads', 'nonce' );

            $options = get_option( 'hnsberg_useful_platforms', false );
            $id      = false;
            if ( ! $options ) {
                $options = array();
                $id      = 1;
            } else {
                $options = json_decode( $options, true );
                $id      = intval( array_key_last( $options ) ) + 1;
            }
            // var_dump($_REQUEST['delete_on_expire']);
            // die;

            if ( ! empty( $_REQUEST['action'] ) ) {
                switch( $_REQUEST['action'] ) {
                    case 'add':
                        if ( empty( $_REQUEST['name'] ) ) {
                            return;
                        }

                        $item = array(
                            'name'       => empty( $_REQUEST['name'] ) ? 'NULL' : $_REQUEST['name'],
                            'position'   => empty( $_REQUEST['position'] ) ? 'NULL' : $_REQUEST['position'],
                            'start_date' => empty( $_REQUEST['start_date'] ) ? 'NULL' : $_REQUEST['start_date'],
                            'end_date'   => empty( $_REQUEST['end_date'] ) ? 'NULL' : $_REQUEST['end_date'],
                            'link'       => empty( $_REQUEST['link'] ) ? 'NULL' : $_REQUEST['link'],
                            'banner'     => empty( $_REQUEST['banner'] ) ? 'NULL' : $_REQUEST['banner'],
                            'mobile_banner'     => empty( $_REQUEST['mobile_banner'] ) ? 'NULL' : $_REQUEST['mobile_banner'],
                            'link'     => empty( $_REQUEST['link'] ) ? 'NULL' : $_REQUEST['link'],
                            'display_time'     => empty( $_REQUEST['display_time'] ) ? 'NULL' : $_REQUEST['display_time'],
                            'delete_on_expire'     => empty( $_REQUEST['delete_on_expire'] ) ? 0 : 1,
                            'wallet'     => empty( $_REQUEST['wallet'] ) ? 'NULL' : $_REQUEST['wallet'],
                            'amount'     => empty( $_REQUEST['amount'] ) ? 'NULL' : $_REQUEST['amount'],
                            'status'     => empty( $_REQUEST['status'] ) ? 'NULL' : $_REQUEST['status'],
                        );

                        add_ads_order_item( $item );
                        break;
                    case 'update':
                        if ( empty( $_REQUEST['id'] ) ) {
                            return;
                        }

                        $item = array(
                            'name'       => empty( $_REQUEST['name'] ) ? 'NULL' : $_REQUEST['name'],
                            'position'   => empty( $_REQUEST['position'] ) ? 'NULL' : $_REQUEST['position'],
                            'start_date' => empty( $_REQUEST['start_date'] ) ? 'NULL' : $_REQUEST['start_date'],
                            'end_date'   => empty( $_REQUEST['end_date'] ) ? 'NULL' : $_REQUEST['end_date'],
                            'link'       => empty( $_REQUEST['link'] ) ? '' : $_REQUEST['link'],
                            'banner'     => empty( $_REQUEST['banner'] ) ? 'NULL' : $_REQUEST['banner'],
                            'mobile_banner'     => empty( $_REQUEST['mobile_banner'] ) ? 'NULL' : $_REQUEST['mobile_banner'],
                            'display_time'     => empty( $_REQUEST['display_time'] ) ? 'NULL' : $_REQUEST['display_time'],
                            'delete_on_expire'     => empty( $_REQUEST['delete_on_expire'] ) ? 0 : 1,
                            'wallet'     => empty( $_REQUEST['wallet'] ) ? 'NULL' : $_REQUEST['wallet'],
                            'amount'     => empty( $_REQUEST['amount'] ) ? 'NULL' : $_REQUEST['amount'],
                            'status'     => empty( $_REQUEST['status'] ) ? 'NULL' : $_REQUEST['status'],
                        );

                        update_ads_order_item( $_REQUEST['id'], $item );
                        break;
                    case 'delete':
                        if ( empty( $_REQUEST['id'] ) ) {
                            return;
                        }

                        delete_ads_order_item( $_REQUEST['id'] );
                        break;

                    case 'approve':
                        if ( empty( $_REQUEST['id'] ) ) {
                            return;
                        }

                        change_ads_order_item_status( $_REQUEST['id'], '1' );
                        break;

                    case 'decline':
                        if ( empty( $_REQUEST['id'] ) ) {
                            return;
                        }

                        change_ads_order_item_status( $_REQUEST['id'], '2' );
                        break;
                }

                // Clear transient.
                $ads_items = get_ads_data();
                foreach( $ads_items as $page_ads ) {
                    foreach ( $page_ads as $ads_item ) {
                        set_transient(  'hnsberg_banner_url_position' . $ads_item['pos'], false, 0 );
                    }
                }
            }
        }

        private function delete() {
            check_ajax_referer( 'hnsbrg-admin-ads', 'nonce' );
            delete_ads_order_item( $_REQUEST['ads_id'] );
        }

        public function page() {
            include_once __DIR__ . '/views.php';
        }
    }
    
}

new Hnsbrg_Ads_List();