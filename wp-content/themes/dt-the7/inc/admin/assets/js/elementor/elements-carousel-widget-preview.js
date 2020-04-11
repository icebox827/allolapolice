(function ($) {

    // Make sure you run this code under Elementor.
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/the7_elements_carousel.default", function ($scope, $) {
            $( document ).ready(function() {
                $scope.find(".dt-owl-carousel-call").each(function () {
                    var $this = $(this);

                    $this.the7OwlCarousel();

                    // Trigger lazy loading manually coz onLoad event is not reliable in Elementor preview.
                    if (!$this.hasClass("refreshed")) {
                        $this.addClass("refreshed");
                        $this.trigger("refresh.owl.carousel");
                    }

                    // Stub anchors.
                    $this.find("article a").on("click", function(e) {
                        e.preventDefault();

                        return false;
                    });
                });
            });
        });
    });

})(jQuery);