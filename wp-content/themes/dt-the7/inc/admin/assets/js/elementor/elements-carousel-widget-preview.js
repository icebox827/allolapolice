(function ($) {

    // Make sure you run this code under Elementor.
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/the7_elements_carousel.default", function ($scope, $) {
            $scope.find(".dt-owl-carousel-call").each(function () {
                $(this).the7OwlCarousel();
            });
        });
    });

})(jQuery);