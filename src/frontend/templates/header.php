<?php
/**
 * Header Template for Advertisement Order page.
 * 
 * @since 1.0.0
 */

?>
<div class="hnsbrg-ads-steps-wrapper">
    <ul class="hnsbrg-ads-steps">
        <?php 
        $index = 1;
        $current_index = -1;
        foreach( $this->header_steps as $id => $name ) {
            if ( $index > 1 ) {
                ?>
                <li class="hnsbrg-ads-step-arrow">
                    <i class="fa-angle-right fas"></i>
                </li>
                <?php
            }

            $additional_class = '';
            if ( $this->steps[ $current_step ]['parent'] == $id ) {
                $additional_class .= ' active';
                $current_index = $index;            
            }

            if ( -1 == $current_index ) {
                $additional_class .= ' done';
            }

            if ( $current_index + 1 == $index ) {
                $additional_class .= ' before';
            }

            $back_url = false;
            
            if ( -1 == $current_index ) {
                $back_url =  get_permalink() . '?step=' . $id;
            }

            ?>
            <li class="hnsbrg-ads-step <?php echo esc_attr( $id ); echo esc_attr( $additional_class ); ?>">
                <?php if ( $back_url ) { ?>
                    <a href="<?php echo esc_url( $back_url ); ?>">
                <?php } ?>
                    <span><?php echo esc_html( $index ); ?></span>
                    <label><?php echo esc_html( $name ); ?></label>
                <?php if ( $back_url ) { ?>
                    </a>
                <?php } ?>
            </li>
            <?php
            $index ++;
        }
        ?>
    </ul>
</div>