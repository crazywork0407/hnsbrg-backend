<?php
/**
 * Platform Backend View
 * 
 * @since 1.0.0
 */

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Ads_List {
    public $items;

    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items() {
        $data = $this->table_data();
        $this->items = $data;
        wp_localize_script( 'hnsbrg-admin-ads', 'hnsbrgAdminvars', array(
            'items' => $data,
        ) );
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data() {
        $data = get_ads_order_items();
        
        if ( ! $data ) {
            return array();
        }
        return array_reduce($data, function ( $arr, $item ) {
            if ( empty($arr) ) { $arr = array(); }
            $arr[$item['position']][] = $item;
            return $arr;
        });
    }

    /**
     * Render the specific item
     * 
     * @param string $pos
     * @return Array
     */
    public function render_item($pos, $pos_data) {
        $data = empty($this->items[$pos]) ? array() : $this->items[$pos];
        ?>
            <div class="hnsbrg-ads-item" data-pos="<?php echo esc_attr($pos); ?>">
                <div class="hnsbrg-ads-title"><?php echo esc_html($pos_data['name']); ?></div>
                <?php foreach($data as $ad) { ?>
                    <div class="hnsbrg-ads-wrapper">
                        <div class="hnsbrg-ads-img">
                            <img src="<?php echo esc_url($ad['banner']); ?>" alt="Ads"  >
                        </div> 
                        <div class="hnsbrg-ads-detail">
                            <p>
                                <?php echo esc_html($ad['name']); ?><br  />
                                <?php echo date('m.d.Y', strtotime($ad['start_date'])) . '-' . date('m.d.Y', strtotime($ad['end_date'])); ?><br />
                                <?php echo esc_html($ad['display_time']); ?> seconds<br />
                                Active
                            </p>
                            <div class="hnsbrg-ads-action">
                                <a href="#" data-id="<?php echo esc_attr( $ad['ID'] ); ?>" class="hnsbrg-ads-edit"><span class="dashicons dashicons-edit"></span></a>
                                <a href="<?php echo sprintf("?page=%s&action=delete&id=%s", $_REQUEST['page'], $ad['ID'] ); ?>" class="hnsbrg-ads-delete"><span class="dashicons dashicons-trash"></span></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="hnsbrg-ads-img">
                    <a href="#" class="hnsbrg-ads-add">Add an Ad<span>+</span></a>
                </div>
            </div>
        <?php
    }
}

$table = new Ads_List();

$table->prepare_items();
// var_dump($table->items);
// die;
?>
<div class="hnsbrg-ads-list-wrapper">
    <div class="hnsbrg-ads-list-header">
        <h1 class="hnsbrg-ads-list-title"><?php esc_html_e( 'Advertisement Order List',  'hnsbrg-backend' ); ?></h1>

        <ul class="hnsbrg-ads-nav">
            <?php foreach( $this->positions as $page => $ads ) { ?>
                <li class="hnsbrg-ads-nav-item">
                    <a class="hnsbrg-ads-nav-link" href="#" data-target="#<?php echo esc_attr(str_replace(' ', '_', strtolower($page))); ?>"><?php echo esc_html($page); ?></a>
                </li>
            <?php } ?> 
        </ul>  
    </div>
    <div class="hnsbrg-ads-items-list">
        <?php
            $pos = 0;
            foreach( $this->positions as $page => $ads ) {
        ?>
            <div class="hnsbrg-ads-tab" id="<?php echo esc_attr(str_replace(' ', '_', strtolower($page))); ?>">
                <div class="hnsbrg-ads-grid">
                    <?php
                        foreach( $ads as $ad ) {
                            echo $table->render_item($pos++, $ad);
                        }
                    ?>
                </div>
            </div>
        <?php } ?> 
    </div>
</div>

<div class="hnsbrg-ads-modal" id="hnsbrg-ads-modal">
    <?php include( __DIR__ .  '/modal.php'); ?>
</div>
