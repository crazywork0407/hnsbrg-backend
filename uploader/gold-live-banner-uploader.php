    <?php
    /**
     * Hnsbrg Banner Image Uploader
     * 
     * @since 1.0.0
     */

    require_once "fancy-file-uploader-helper.php";

    /**
     * Modify Result after Upload
     * 
     * @since 1.0.0
     */
    function ModifyUploadResult( &$result, $filename, $name, $ext, $fileinfo ) {
        // Add more information to the result here as necessary (e.g. a URL to the file that a callback uses to link to or show the file).

        $result['filename'] = $fileinfo['name'];
    }

    $upload_dir = str_replace( "/plugins/hnsbrg-backend/uploader", "/uploads/hnsbrg", __DIR__ );

    if ( !file_exists( $upload_dir ) || !is_dir( $upload_dir ) ) {
        mkdir( $upload_dir );       
    }

    $options = array(
        "allowed_exts"    => array("jpg", "png"),
        "filename"        => $upload_dir . "/{name}.{ext}",
        "result_callback" => "ModifyUploadResult",
    );

    FancyFileUploaderHelper::HandleUpload( "files", $options );
