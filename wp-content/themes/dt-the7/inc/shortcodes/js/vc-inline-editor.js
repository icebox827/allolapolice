(function ($) {
    $(window).on( 'vc_reload', function() {
        // Mini blog.
        $('.layzr-loading-on, .vc_single_image-img').layzrInitialisation();
        //Blog list 
        $(".layzr-loading-on .blog-shortcode.jquery-filter.mode-list .visible").layzrBlogInitialisation();
       
        $(" .vc_pie_chart .vc_pie_wrapper").css("visibility", "visible");
    } );
})(window.jQuery);