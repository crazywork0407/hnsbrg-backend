<?php
/**
 * Add / Update Order Modal
 * 
 * @since 1.0.0
 */
?>

<div class="hnsbrg-ads-order-new-wrapper">
    <form method="post" action="<?php echo sprintf("?page=%s", $_REQUEST['page'] ); ?>" class="hnsbrg-ads-order-form">
        <input type="hidden" name="action" id="hnsbrg-ads-action" required>
        <input type="hidden" name="id" id="hnsbrg-ads-id" required>
        <input type="hidden" name="position" id="hnsbrg-ads-position" required>
        <div class="hnsbrg-options-form-item">
            <label for="hnsbrg-ads-name"><?php esc_html_e( 'Name:', 'hnsbrg-backend' ); ?></label><input type="text" name="name" id="hnsbrg-ads-name" required/>
        </div>

        <div class="hnsbrg-options-form-item">
            <label><?php esc_html_e( 'Time Slot', 'hnsbrg-backend' ); ?></label><input type="date" class="w-half" name="start_date" id="hnsbrg-ads-start-date" required/><input type="date" class="w-half" name="end_date" id="hnsbrg-ads-end-date" required style="margin-left: 20px;"/>
        </div>

        <div class="hnsbrg-options-form-item">
            <label for="hnsbrg-ads-display-time"><?php esc_html_e( 'Display Time:', 'hnsbrg-backend' ); ?></label><input type="number" name="display_time" id="hnsbrg-ads-display-time"/>
        </div>

        <div class="hnsbrg-options-form-item">
            <label for="hnsbrg-ads-link"><?php esc_html_e( 'Externa Link:', 'hnsbrg-backend' ); ?></label><input type="text" name="link" id="hnsbrg-ads-link"/>
        </div>

        <div class="hnsbrg-options-form-item">
            <label for="hnsbrg-ads-delete-on-expire"><?php esc_html_e( 'Delete when expired:', 'hnsbrg-backend' ); ?></label><input type="checkbox" name="delete_on_expire" id="hnsbrg-ads-delete-on-expire" value="yes"/>
        </div>

        <div class="hnsbrg-options-form-item">
            <div class="hnsbrg-banner-image-uploader">
                <input type="hidden" name="banner" id="hnsbrg-ads-banner" required/>
            </div>
            <div class="hnsbrg-banner-image-uploader">
                <input type="hidden" name="mobile_banner" id="hnsbrg-ads-mobile-banner"/>
            </div>
        </div>

        <button type="submit" class="button button-primary"><?php echo esc_html__( 'Publish', 'hnsbrg-backend' ) ?></button>
    </form>
</div>