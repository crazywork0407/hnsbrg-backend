<?php
/**
 * Footer Template
 * 
 * @since 1.0.0
 */

$prev_url = '#';
$next_url = '#';

if ( false !== $this->steps[ $current_step ]['prev'] ) {
    $prev_url =  get_permalink() . '?step=' . $this->steps[ $current_step ]['prev'];
}

if ( false !== $this->steps[ $current_step ]['next'] ) {
    $next_url =  get_permalink() . '?step=' . $this->steps[ $current_step ]['next'];
}

?>
<div class="hnsbrg-ads-step-navigations">
    <a class="hnsbrg-ads-step-navigation prev<?php echo ( false == $this->steps[ $current_step ]['prev'] ? ' disabled' : '' ); ?>" href="<?php echo esc_url( $prev_url ); ?>"><?php echo esc_html__( 'Back', 'hnsbrg-backend' ); ?></a>
        
    <button type="submit" class="hnsbrg-ads-step-navigation next"><?php echo esc_html__( 'Next Step', 'hnsbrg-backend' ); ?></button>
</div>