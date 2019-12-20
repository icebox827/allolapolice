function the7PortfolioMasonryIconsDependencyCallback() {
    var $ = jQuery;
    var $dependentBlocks = $('.the7-icons-dependent', this.$content);

    var $show_details = $(".wpb_vc_param_value[name=show_details]", this.$content);
    var $show_link = $(".wpb_vc_param_value[name=show_link]", this.$content);
    var $show_zoom = $(".wpb_vc_param_value[name=show_zoom]", this.$content);

    function handleDependency() {
        var show_details = $show_details.val();
        var show_link = $show_link.val();
        var show_zoom = $show_zoom.val();

        if ( show_details === 'y' || show_link === 'y' || show_zoom === 'y' ) {
            $dependentBlocks.removeClass('vc_dependent-hidden');
        } else {
            $dependentBlocks.addClass('vc_dependent-hidden');
        }
        var event = $.Event('change');
        event.extra_type = "vcHookDepended";
        $dependentBlocks.find('.wpb_vc_param_value').trigger(event);
    }

    [$show_zoom, $show_link, $show_details].map(function(element) {
        element.on('change', function () {
            handleDependency();
        });
    });

    handleDependency();
}