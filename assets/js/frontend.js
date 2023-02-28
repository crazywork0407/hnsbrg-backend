/**
 * hnsbrg Ads
 * 
 * @since 1.0.0
 * @author Eugene Lee
 */
(function ($) {
    $(document).ready(function () {
        $('.hnsbrg-ads-wrapper').on('init', function (event, slick) {
            var currentSlideElement = $(slick.$slides.get(slick.currentSlide));
            var duration = currentSlideElement.attr('data-duration');

            if (duration > 0) {
                setTimeout(() => {
                    $(this).slick('slickNext');
                }, duration * 1000);
            }
        });

        var slider = $('.hnsbrg-ads-wrapper').slick({
            accessibility: false,
            arrows: false,
        });

        $(slider).on('afterChange', function (event, slick, currentSlide) {
            var currentSlideElement = $(slick.$slides.get(currentSlide));
            var duration = currentSlideElement.attr('data-duration');

            if (duration > 0) {
                setTimeout(() => {
                    $(this).slick('slickNext');
                }, duration * 1000);
            }
        });
    })
})(window.jQuery)