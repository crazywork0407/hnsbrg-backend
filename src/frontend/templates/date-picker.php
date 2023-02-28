<?php
/**
 * Date Picker Tempate
 * 
 * @since 1.0.0
 */

$pos_id = empty( $_REQUEST['position'] ) ? '0' : $_REQUEST['position'];
$pos_name = $this->positions[ $pos_id ];
?>

<div class="hnsbrg-ads-date-picker-wrapper">
    <h1 class="hnsbrg-ads-step-title">
        <?php echo esc_html__( 'Select a Time Slot', 'hnsbrg-backend' ); ?>
    </h1>
    <div class="hnsbrg-ads-date-pickers">
        <div class="hnsbrg-ads-date-picker">
            <div class="hnsbrg-ads-header">
                <h3 class="hnsbrg-ads-title"><?php echo esc_html( $pos_name ); ?></h3>
                <span class="hnsbrg-ads-info">
                    <span class="date">0</span><?php echo esc_html__( 'days selected, est. costs: ', 'hnsbrg-backend' ); ?><span class="cost">0.00 BNB</span>
                </span>
            </div>
            <div class="hnsbrg-ads-date-range-controller-wrapper">
                <input type="text" class="hnsbrg-hidden-control" name="position" value="<?php echo esc_attr( $pos_id ); ?>" require>
                <input type="text" class="hnsbrg-hidden-control hnsbrg-ads-date-range-controller" id="hnsbrg-start-date" name="start_date" require>
                <input type="text" class="hnsbrg-hidden-control hnsbrg-ads-date-range-controller" id="hnsbrg-end-date" name="end_date" require>
                <input type="text" class="hnsbrg-hidden-control hnsbrg-ads-price" name="amount" require>
                <input type="text" class="hnsbrg-wallet-adress hnsbrg-hidden-control" name="wallet"require>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function(e) {
            $ = jQuery;

            var picker = new Lightpick({
                field: document.getElementById('hnsbrg-start-date'),
                secondField: document.getElementById('hnsbrg-end-date'),
                format: 'YYYY-MM-DD',
                singleDate: false,
                minDate: moment(),
                inline: true,
                disableDates: <?php echo json_encode( $locked_dates, true ); ?>,
                onSelect: function() {
                    var startDate = picker.getStartDate(),
                        endDate   = picker.getEndDate();

                    if ( startDate && endDate ) {
                        days = (endDate.toDate() - startDate.toDate()) / (1000 * 60 * 60 * 24) + 1;
                        $('.hnsbrg-ads-info .date').html(days);

                        var price = <?php echo get_ads_price( $pos_id ); ?>;

                        $('.hnsbrg-ads-info .cost').html((price * days).toFixed(2) + ' BNB');
                        $('input.hnsbrg-ads-price').val((price * days).toFixed(2));
                    }
                }
            });
        });
    </script>
</div>