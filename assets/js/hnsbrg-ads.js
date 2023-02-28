/**
 * hnsbrg Ads
 * 
 * @since 1.0.0
 * @author Eugene Lee
 */
(function ($) {
    function tabClickHandler() {
        var $this = $(this),
            $navItem = $this.parent(),
            $content = $($this.data('target'));

        $content.siblings('.active').hide().addClass('active');
        $content.show().addClass('active');

        $navItem.siblings('.active').removeClass('active');
        $navItem.addClass('active');
    }

    function modalHandler() {
        var pos = $(this).closest('.hnsbrg-ads-item').data('pos'),
            id = $(this).data('id'),
            item = hnsbrgAdminAds.ads.find(ad => ad.ID == id),
            position = hnsbrgAdminAds.positions.find(item => item.pos == pos);

        $('#hnsbrg-ads-action').val(item ? 'update' : 'add');
        $('#hnsbrg-ads-position').val(pos);
        $('#hnsbrg-ads-id').val(item ? item.ID : '');
        $('#hnsbrg-ads-name').val(item ? item.name : '');
        $('#hnsbrg-ads-start-date').val(item ? item.start_date : '');
        $('#hnsbrg-ads-end-date').val(item ? item.end_date : '');
        $('#hnsbrg-ads-display-time').val(item ? item.display_time : '');
        item && item.delete_on_expire == "1" && ($('#hnsbrg-ads-delete-on-expire')[0].checked = true);
        $('#hnsbrg-ads-banner').val(item ? item.banner : '');
        $('#hnsbrg-ads-mobile-banner').val(item ? item.mobile_banner : '');
        $('#hnsbrg-ads-banner').closest('.hnsbrg-banner-image-uploader').find('.smartcat-upload').html(`Upload Banner<span>(Size ${position.width} x ${position.height} )</span>`);

        if (item) {
            $('#hnsbrg-ads-banner').closest('.hnsbrg-banner-image-uploader').addClass('selected').find('img').attr('src', item.banner).show();
            $('#hnsbrg-ads-mobile-banner').closest('.hnsbrg-banner-image-uploader').addClass('selected').find('img').attr('src', item.mobile_banner).show();
        } else {
            $('#hnsbrg-ads-banner,#hnsbrg-ads-mobile-banner').closest('.hnsbrg-banner-image-uploader').removeClass('selected').find('img').attr('src', "").hide();
        }

        $('#hnsbrg-ads-modal').dialog("open");
    }

    $(document).on('ready', function () {
        $.wpMediaUploader({
            target: '.hnsbrg-banner-image-uploader', // The class wrapping the textbox
            uploaderTitle: 'Select or upload image', // The title of the media upload popup
            uploaderButton: 'Set image', // the text of the button in the media upload popup
            multiple: false, // Allow the user to select multiple images
            buttonText: 'Upload Mobile Banner <span>(Size 300 x 250)</span>', // The text of the upload button
            buttonClass: '.smartcat-upload', // the class of the upload button
            previewSize: '150px', // The preview image size
            modal: false, // is the upload button within a bootstrap modal ?
            buttonStyle: { // style the button
                'color': 'inherit',
                'background': '#fff',
                'font-size': '16px',
                'padding': '7px 10px',
                'text-decoration': 'none',
                'border-radius': '3px'
            },
        });

        $('.hnsbrg-ads-nav-link:not(.active)').on('click', tabClickHandler);

        $('.hnsbrg-ads-nav-link').eq(0).click();
        $('.hnsbrg-ads-add, .hnsbrg-ads-edit').on('click', modalHandler);

        $('#hnsbrg-ads-modal').dialog({
            closeText: 'X',
            dialogClass: "hnsbrg-ads-dialog",
            // modal: true,
            title: "Advertisement Details",
            autoOpen: false,
            width: 600,
            classes: {
                "ui-dialog-titlebar-close": "button right"
            }
        });
    });
})(jQuery);