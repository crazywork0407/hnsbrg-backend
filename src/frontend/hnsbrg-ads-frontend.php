<?php
/**
 * Hnsbrg Advertisement Frontend
 * 
 * @since 1.0.0
 */

if ( ! class_exists( 'Hnsbrg_Ads_Frontend' ) ) {
    class Hnsbrg_Ads_Frontend {
        private $tempate_url =  __DIR__ . '/templates';

        private $header_steps;

        private $steps;

        public $positions;

        public function __construct() {
            delete_expired_ads();
            $this->positions = get_ads_data();

            // Variables
            $this->header_steps = array(
                'choose-campaign'   => esc_html__( 'Choose campaigns & time slot', 'hnsbrg-backend' ),
                'upload-campaign'   => esc_html__( 'Upload campaign', 'hnsbrg-backend' ),
                'wait-for-approval' => esc_html__( 'Wait for approval', 'hnsbrg-backend' ),
                'pay-and-go'        => esc_html__( 'Pay & Go', 'hnsbrg-backend' ),
            );

            $this->steps = array(
                'choose-campaign' => array(
                    'template' => __DIR__ . '/templates/choose-campaign.php',
                    'prev'    => false,
                    'next'    => 'date-picker',
                    'parent'  => 'choose-campaign',
                ),
                'date-picker' => array(
                    'template' => __DIR__ . '/templates/date-picker.php',
                    'prev'    => 'choose-campaign',
                    'next'    => 'upload-campaign',
                    'parent'  => 'choose-campaign',
                ),
                'upload-campaign' => array(
                    'template' => __DIR__ . '/templates/upload-campaign.php',
                    'prev'     => 'date-picker',
                    'next'     => 'wait-for-approval',
                    'parent'   => 'upload-campaign',
                ),
                'wait-for-approval' => array(
                    'template' => __DIR__ . '/templates/wait-for-approval.php',
                    'prev'    => 'upload-campaign',
                    'next'    => false,
                    'parent'  => 'wait-for-approval',
                ),
            );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
            add_shortcode( 'hnsberg_ads_frontend', array( $this, 'render' ) );
            add_shortcode( 'hnsberg_ads_banner', array( $this, 'render_ads_banner') );
        }

        public function enqueue() {
            // Get Current Step.
            $current_step = false;
            if ( empty( $_REQUEST['step'] ) ) { 
                $current_step = array_keys( $this->steps )[0];
            } else {
                $current_step = $_REQUEST['step'];
            }

            if ( 'upload-campaign' == $current_step ) {
                wp_enqueue_style( 'hnsbrg-file-upload-fancy-fileupload', HNSBRG_PLUGIN_VENDOR_URL . '/fancy-file-uploader/fancy_fileupload.css', array(), '1.0.0' );

                wp_enqueue_script( 'hnsbrg-file-upload-ui-widget', HNSBRG_PLUGIN_VENDOR_URL . '/fancy-file-uploader/jquery.ui.widget.js', array( 'jquery-core' ), '1.0.0' );
                wp_enqueue_script( 'hnsbrg-file-upload-fileupload', HNSBRG_PLUGIN_VENDOR_URL . '/fancy-file-uploader/jquery.fileupload.js', array( 'jquery-core' ), '1.0.0' );
                wp_enqueue_script( 'hnsbrg-file-upload-iframe-transport', HNSBRG_PLUGIN_VENDOR_URL . '/fancy-file-uploader/jquery.iframe-transport.js', array( 'jquery-core' ), '1.0.0' );
                wp_enqueue_script( 'hnsbrg-file-upload-fancy-fileupload', HNSBRG_PLUGIN_VENDOR_URL . '/fancy-file-uploader/jquery.fancy-fileupload.js', array( 'jquery-core' ), '1.0.0' );
            }

            if ( 'date-picker' == $current_step ) {
                wp_enqueue_style( 'hnsbrg-date-picker-lightpick', HNSBRG_PLUGIN_VENDOR_URL . '/lightpick/css/lightpick.css', array(), '1.0.0' );

                wp_enqueue_script( 'hnsbrg-date-picker-moment', HNSBRG_PLUGIN_VENDOR_URL . '/moment/moment.js', array(), '1.0.0' );
                wp_enqueue_script( 'hnsbrg-date-picker-lightpick', HNSBRG_PLUGIN_VENDOR_URL . '/lightpick/lightpick.js', array(), '1.0.0' );
            }

            // wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-1.2.1.min.js', array('jquery-core'), '1.0.0');
            wp_enqueue_style('slick', HNSBRG_PLUGIN_VENDOR_URL . '/slick/slick.css', array(), '1.0.0');
            wp_enqueue_script('slick', HNSBRG_PLUGIN_VENDOR_URL . '/slick/slick.min.js', array('jquery-core'), '1.0.0');
            wp_enqueue_style( 'hnsbrg-ads-frontend', HNSBRG_PLUGIN_ASSETS_URL . '/css/frontend.css', array(), '1.0.0' );
            wp_enqueue_script( 'hnsbrg-ads-frontend', HNSBRG_PLUGIN_ASSETS_URL . '/js/frontend.js', array('jquery-core'), '1.0.0' );
        }

        public function submit_order($request) {
            $request['name'] = empty( $request['campaign_name'] ) ? '' : $request['campaign_name'];

            $item = shortcode_atts(
                array(
                    'name'          => 'Unnamed',
                    'position'      => '0',
                    'banner'        => '',
                    'start_date'    => '',
                    'end_date'      => '',
                    'wallet'        => '',
                    'amount'        => '0.00',
                    'purchase_date' => date('Y-m-d'),
                    'status'        => '0',
                    'user'          => '',
                ),
                $request
            );

            add_ads_order_item( $item );
        }

        public function render() {
            // Get Current Step.
            $current_step = false;
            if ( empty( $_REQUEST['step'] ) ) {
                $current_step = array_keys( $this->steps )[0];
            } else {
                $current_step = $_REQUEST['step'];
            }

            // Selected dates
            if ( 'date-picker' == $current_step ) {
                $position = empty( $_REQUEST['position'] ) ? '0' : $_REQUEST['position'];

                $locked_dates = get_selected_dates_by_position( $position );
            }
            
            // Wait For Approval Step.
            if ( 'wait-for-approval' == $current_step && ! empty( $_REQUEST['campaign_name'] ) ) {
                $this->submit_order( $_REQUEST );
            }
           
            $action_url = false;
            if ( false !== $this->steps[ $current_step ]['next'] ) {
                $action_url =  get_permalink() . '?step=' . $this->steps[ $current_step ]['next'];
            }

            ob_start();

 
            if ( false !== $action_url ) {
                echo '<form action="' . esc_url( $action_url ) . '" class="hnsbrg-' . esc_attr( $current_step ) . '-form" method="post">';
            }
            
            require_once $this->tempate_url . '/header.php';

            require_once $this->steps[ $current_step ]['template'];

            require_once $this->tempate_url . '/footer.php';

            if ( false !== $action_url ) {
                echo '</form>';
            }

            return ob_get_clean();
        }

        public function render_ads_banner( $atts, $content = "" ) {
            extract( 
                shortcode_atts(
                    array(
                        'position' => '0',
                        'vertical' => false,
                        'class'    => '',
                        'mobile'   => true,
                    ),
                    $atts
                )
            );

            $ads = get_transient( 'hnsberg_banner_url_position' . $position );

            if ( empty($ads) ) {
                $ads     = get_banner_url_from_position( $position );
                $expiration = strtotime("tomorrow") - strtotime("now");

                set_transient(  'hnsberg_banner_url_position' . $position, json_encode( $ads ), $expiration );
            } else {
                $ads = json_decode( $ads, true );
            }

            if ( empty($ads) || ( wp_is_mobile() && false == $mobile ) ) {
                return  '';
            }

            ob_start();
            echo  '<div class="hnsbrg-ads-wrapper">';
            foreach($ads as $ad) {
                extract( shortcode_atts(
                    array(
                        'banner' => '',
                        'mobile_banner' => '',
                        'link'   => '#',
                        'display_time' => ''
                    ),
                    $ad
                ) );

                $class  = 'hnsbrg-banner hnsbrg-banner-pos-' . $position . ' ' . ( $vertical ? 'vertical-banner' : '' ) . ' ' . $class;
                $img_url = wp_is_mobile() ? $mobile_banner : $banner;

                if (empty($img_url)) continue;

                ?>
                    <figure class="<?php echo esc_attr( $class ); ?>" data-duration="<?php echo esc_attr($display_time); ?>">
                        <a href="<?php echo esc_url( $link ); ?>" target="_blank">
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="Banner" width="980" height="120" />
                        </a>
                    </figure>
                <?php
            }
            echo  '</div>';

            $html = ob_get_clean();

            return $html;
        }
    }
}

new Hnsbrg_Ads_Frontend();
