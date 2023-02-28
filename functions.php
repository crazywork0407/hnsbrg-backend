<?php
/**
 * Functinos
 * 
 * @since 1.0.0
 */

if ( ! function_exists( 'init_advertisement_db' ) ) {
    function init_advertisement_db() {
        global $wpdb;

        $wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}ads_orders
        (
            ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255),
            position INT,
            banner VARCHAR(255),
            mobile_banner VARCHAR(255),
            link VARCHAR(255),
            start_date DATE,
            end_date DATE,
            display_time INT,
            delete_on_expire TINYINT,
            wallet VARCHAR(255),
            amount DOUBLE,
            purchase_date DATE,
            status INT,
            user VARCHAR(255)
        );" );
    }
}

/**
 * Get all items from table
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'get_ads_order_items' ) ) {
    function get_ads_order_items( $conditions = array() ) {
        global $wpdb;

        $conditions_query = '';
        $index            = 0;

        foreach( $conditions as $key => $value ) {
            if ( $index !== 0 ) {
                $conditions_query .= ' AND ';
            } else {
                $conditions_query .= ' WHERE ';
            }

            $conditions_query .= $key . ' = ' . $value;

            $index ++;
        }

        $result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ads_orders " . $conditions_query, ARRAY_A );

        return $result;
    }
}


/**
 * Add new item from table
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'add_ads_order_item' ) ) {
    function add_ads_order_item( $item = array() ) {
        global $wpdb;

        if ( empty( $item ) ) {
            return;
        }

        foreach( $item as $key => $value ) {
            $item[$key] = str_replace( "'", "`", $value );
        }

        $query = "INSERT INTO {$wpdb->prefix}ads_orders (" . implode( ", ", array_keys( $item ) ) . ") VALUES ('" . implode( "', '", $item ) . "')";

        $wpdb->query( $query );
    }
}

/**
 * Update item from table by ID
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'update_ads_order_item' ) ) {
    function update_ads_order_item( $id = false, $item = array() ) {
        global $wpdb;

        if ( empty( $item ) || false == $id ) {
            return;
        }

        $param_str = array();
        foreach( $item as $key => $value ) {
            $param_str[] = ( $key . "='" . str_replace( "'", "`", $value ) . "'" );
        }
        $query = "UPDATE {$wpdb->prefix}ads_orders SET " . implode( ', ',  $param_str ) . " WHERE ID=" . $id . "";

        $wpdb->query( $query );
    }
}

/**
 * Delete Item by ID
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'delete_ads_order_item' ) ) {
    function delete_ads_order_item( $id = false ) {
        global $wpdb;

        if ( false == $id ) {
            return;
        }

        $query = "DELETE FROM {$wpdb->prefix}ads_orders WHERE ID=" . $id;

        $wpdb->query( $query );
    }
}

/**
 * Delete expired items
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'delete_expired_ads' ) ) {
    function delete_expired_ads(  ) {
        global $wpdb;

        $today = date("Y-m-d");

        $query = "DELETE FROM {$wpdb->prefix}ads_orders WHERE end_date < '" . $today . "' AND delete_on_expire = 1";

        $wpdb->query( $query );
    }
}

/**
 * Change Item Status by ID
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'change_ads_order_item_status' ) ) {
    function change_ads_order_item_status( $id = false, $status = '0' ) {
        global $wpdb;

        if ( false == $id ) {
            return;
        }

        $query = "UPDATE {$wpdb->prefix}ads_orders SET status=" . $status . " WHERE ID=" . $id;

        $wpdb->query( $query );
    }
}

/**
 * Get ads data
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'get_ads_data' ) ) {
    function get_ads_data() {
        return array(
            'Start Page' => array(
                array(
                    "pos" => 0,
                    'name' => esc_html__('Slot Banner 1', 'hnsbrg_backend'),
                    'width' => 970,
                    'height' => 250
                ),
                array(
                    "pos" => 1,
                    'name' => esc_html__('Slot Banner 2', 'hnsbrg_backend'),
                    'width' => 970,
                    'height' => 250
                ),
                array(
                    "pos" => 2,
                    'name' => esc_html__('Slot Banner 3', 'hnsbrg_backend'),
                    'width' => 300,
                    'height' => 600,
                    'mobile' => false,
                ),
                array(
                    "pos" => 3,
                    'name' => esc_html__('Slot Banner 4', 'hnsbrg_backend'),
                    'width' => 300,
                    'height' => 600,
                    'mobile' => false,
                ),
                array(
                    "pos" => 4,
                    'name' => esc_html__('Slot Banner 5', 'hnsbrg_backend'),
                    'width' => 970,
                    'height' => 250
                ),
            ),
            'Blog Page' => array(
                array(
                    "pos" => 5,
                    'name' => esc_html__('Slot Banner 6', 'hnsbrg_backend'),
                    'width' => 970,
                    'height' => 250
                ),
                array(
                    "pos" => 6,
                    'name' => esc_html__('Slot Banner 7', 'hnsbrg_backend'),
                    'width' => 300,
                    'height' => 600,
                    'mobile' => false,
                ),
                array(
                    "pos" => 7,
                    'name' => esc_html__('Slot Banner 8', 'hnsbrg_backend'),
                    'width' => 300,
                    'height' => 600,
                    'mobile' => false,
                ),
                array(
                    "pos" => 8,
                    'name' => esc_html__('Slot Banner 9', 'hnsbrg_backend'),
                    'width' => 970,
                    'height' => 250
                ),
                array(
                    "pos" => 9,
                    'name' => esc_html__('Slot Banner 10', 'hnsbrg_backend'),
                    'width' => 970,
                    'height' => 250
                ),
            ),
        );
    }
}

/**
 * Get ads size
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'get_ads_size' ) ) {
    function get_ads_size( $pos ) {
        switch($pos) {
            case '0':
            case '6':
            case '8':
            case '10':
            case '12':
            case '18':
                return array(
                    'width' => 970,
                    'height' => 90,
                );
            case '1':
            case '7':
            case '9':
            case '11':
            case '13':
            case '19':
                return array(
                    'width' => 970,
                    'height' => 250,
                );
            case '2':
            case '4':
            case '14':
            case '16':
                return array(
                    'width' => 160,
                    'height' => 600,
                );
            default:
                return array(
                    'width' => 300,
                    'height' => 600
                );
        }
    }
}

/**
 * Get selected dates by position
 * 
 * @since 1.0.0
 * 
 * @param $position {string} Postion of ads banner.
 * @return $locked_dates {array} Ranges of locked dates
 */
if ( ! function_exists( 'get_selected_dates_by_position' ) ) {
    function get_selected_dates_by_position( $position ) {
        global $wpdb;

        $today = date("Y-m-d");
        $query = "SELECT * FROM {$wpdb->prefix}ads_orders WHERE end_date > '" . $today . "' AND position='" . $position . "' AND status='1'";

        $orders = $wpdb->get_results( $query, ARRAY_A );

        $locked_dates = array();

        // foreach( $orders as $order ) {
        //     $start_date = date( $order['start_date'] );
        //     $end_date   = date( $order['end_date'] );
        //     while ( $start_date <= $end_date ) {
        //         $locked_dates[] = $start_date;

        //         date_add( $start_date, date_interval_create_from_date_string( "1 day" ) );
        //     }
        // }

        foreach ( $orders as $order ) {
            $locked_dates[] = array(
                $order['start_date'],
                $order['end_date'],
            );
        }

        return $locked_dates;
    }
}

/**
 * Get banner url from dates and position
 * 
 * @since 1.0.0
 * @param position {string} Position of Banner
 * @return url of banner.
 */
if ( ! function_exists( 'get_banner_url_from_position' ) ) {
    function get_banner_url_from_position( $position ) {
        global $wpdb;

        $today = date("Y-m-d");
        $query = "SELECT banner,mobile_banner,link,display_time FROM {$wpdb->prefix}ads_orders WHERE end_date >= '" . $today . "' AND start_date <= '" . $today . "'  AND position='" . $position . "'";

        $banner = $wpdb->get_results( $query, ARRAY_A );

        return $banner;
    }
}
