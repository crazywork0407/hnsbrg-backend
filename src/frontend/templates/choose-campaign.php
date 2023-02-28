<?php
/**
 * Choose Campaign Tempate
 * 
 * @since 1.0.0
 */
?>
<div class="hnsbrg-ads-choose-campaign">
    <div class="hnsbrg-ads-wallect-connect">
        <a href="#" class="hnsbrg-ads-connect-metamask">
            <img src="<?php echo esc_attr( HNSBRG_PLUGIN_ASSETS_URL . '/images/metamask.svg'); ?>" alt="Metamask Icon" width="16" height="15"/><span><?php echo esc_html__( 'Connect Metamask', 'hnsbrg-backend' ); ?></span>
        </a>
    </div>
    <div class="hnsbrg-ads-campaign-wrapper">
        <h2 class="hnsbrg-ads-campaign-title"><?php echo esc_html__( 'Choose Campaigns', 'hnsbrg-backend' ); ?></h2>
        <ul class="hnsbrg-ads-campaigns">
            <?php 
            foreach( $this->positions as $key => $position) {
                ?>
                <li class="hnsbrg-ads-campaign" id="<?php echo esc_attr( 'position-' . $key ); ?>" data-value="<?php echo esc_attr( $key ); ?>">
                    <label data-pos="<?php echo esc_attr( 'position-' . $key ); ?>"><?php echo $position; ?></label>
                    <span><?php echo get_ads_price( $key ); ?> BNB</span>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <input type="text" name="position" class="hnsbrg-ads-position hnsbrg-hidden-control" require/>
    <input type="text" name="wallet" class="hnsbrg-wallet-adress hnsbrg-hidden-control" require/>
    <script>
        jQuery(document).on('ready', function(e) {
            $ = jQuery;
            $(document).on('click', '.connected .hnsbrg-ads-campaigns li', function(e) {
                var $this = $(this);

                $this.addClass('active').siblings().removeClass('active');

                $('.hnsbrg-ads-position').val($this.data('value'));
            });
            

            $('.hnsbrg-choose-campaign-form').on('submit', function(e) {
                let $this = $(this);
                if ( '' == $this.find('.hnsbrg-wallet-adress').val() ) {
                    alert('Please connect your wallet to our website!');
                    e.preventDefault();
                }
                if ( '' == $('.hnsbrg-ads-position').val() ) {
                    alert('Please select campaign!');
                    e.preventDefault();
                }
            })
        });
    </script>
</div>