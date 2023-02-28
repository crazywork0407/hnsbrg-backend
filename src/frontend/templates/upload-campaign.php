<?php
/**
 * Upload Campaign Template
 * 
 * @since 1.0.0
 */
 
$pos_id = empty( $_REQUEST['position'] ) ? '0' : $_REQUEST['position'];
$pos_name = $this->positions[ $pos_id ];
$start_date = empty( $_REQUEST['start_date'] ) ? '' : $_REQUEST['start_date'];
$end_date = empty( $_REQUEST['end_date'] ) ? '' : $_REQUEST['end_date'];
$amount = empty( $_REQUEST['amount'] ) ? '0.00' : $_REQUEST['amount'];
?>

<div class="hnsbrg-ads-upload-campaign-wrapper">
    <h1 class="hnsbrg-ads-step-title">
        <?php echo esc_html__( 'Upload campaign', 'hnsbrg-backend' ); ?>
    </h1>
    <div class="hnsbrg-campaign-name-form-wrapper">
        <h3 class="hnsbrg-campaign-name-form-title">
            <?php echo esc_html__( 'Campaign Name', 'hnsbrg-backend' ); ?>
            <div class="hnsbrg-campaign-name-form-price">
                <label><?php echo esc_html__( 'Estimated costs:', 'hnsbrg-backend' ); ?></label>
                <span><?php echo esc_html( $amount ); ?> BNB</span>
            </div>
        </h3>
        <input class="hnsbrg-campaign-name-form" type="text" name="campaign_name" placeholder="<?php echo esc_html__( 'Campaign name', 'hnsbrg-backend' ); ?>" required/>
        <span class="hnsbrg-campaign-name-form-desc"><?php echo esc_html__( 'Maximum 75 characters', 'hnsbrg-backend' ); ?></span>
        <input class="hnsbrg-campaign-link-form" type="text" name="link" placeholder="<?php echo esc_html__( 'Link to advertised page', 'hnsbrg-backend' ); ?>" required/>
    </div>
    <div class="hnsbrg-campaign-items-wrapper">
        <div class="hnsbrg-campaign-item">
            <h4 class="hnsbrg-campaign-item-title"><?php echo esc_html( $pos_name ); ?></h4>
            <div class="hnsbrg-campaign-upload-wrapper">
                <input class="hnsbrg-campaign-upload" type="file" name="files" accept=".jpg, .png, image/jpeg, image/png" multiple>
            </div>
        </div>
    </div>
    
    <input type="text" class="hnsbrg-hidden-control" name="position" value="<?php echo esc_attr( $pos_id ); ?>">
    <input type="text" class="hnsbrg-hidden-control" name="start_date" value="<?php echo esc_attr( $start_date ); ?>">
    <input type="text" class="hnsbrg-hidden-control" name="end_date" value="<?php echo esc_attr( $end_date ); ?>">
    <input type="text" class="hnsbrg-hidden-control" name="amount" value="<?php echo esc_attr( $amount ); ?>">
    <input type="text" class="hnsbrg-hidden-control" id="hnsbrg-ads-banner-url" name="banner">
    <input type="text" class="hnsbrg-wallet-adress hnsbrg-hidden-control" name="wallet">
    <input type="text" class="hnsbrg-transaction hnsbrg-hidden-control" name="user">

    <script>
        jQuery(document).on('ready', function(e) {
            $ = jQuery;
            $('.hnsbrg-campaign-upload').FancyFileUpload({
                params : {
                    fileuploader: '1'
                },
                url: '<?php echo HNSBRG_PLUGIN_URL . 'uploader/hnsbrg-banner-uploader.php'; ?>',
                uploadcompleted: function (e, data) {
                    var uploadURL = '<?php echo wp_upload_dir()['baseurl'] . '/hnsbrg/'; ?>';
                    
                    if (undefined != data['result']['filename']) {
                        $('#hnsbrg-ads-banner-url').val(uploadURL + data['result']['filename']);
                    }
                }
            });

            setTimeout(() => {
                $('.hnsbrg-campaign-upload-wrapper .ff_fileupload_dropzone').each(function() {
                    $(this).html('<div class="hnsbrg-file-uploader-inner"><button class="hnsbrg-ads-button">Add Image</button><p class="hnsbrg-ads-file-upload-description">Upload file or drag it here.</p><ul class="hnsbrg-ads-file-upload-conditions"><li class="hnsbrg-ads-file-upload-condition"><label>File formats:</label>PNG, JPG</li><li class="hnsbrg-ads-file-upload-condition"><label>File size:</label>max. 10 MB</li><li class="hnsbrg-ads-file-upload-condition"><label>Image size:</label>980x120px</li></ul></div>');
                });    
            }, 100);
        });
    </script>
</div> 
