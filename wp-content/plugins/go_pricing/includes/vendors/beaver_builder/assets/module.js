;(function ($, undefined) {
    'use strict';

    $(function () {

		if (typeof FLBuilder !== 'undefined') {
			FLBuilder.addHook( 'settings-form-init', function () {
				$('.go-pricing_btn-edit-table').on('click', function(e) {
					e.preventDefault();
				var $select = $('select[name="go_pricing--id"]');
					if (!$select.length || $select.val() === null || $select.val().split('--')[0] == "0" ) return;
					window.open($(this).data('url-base') + '='+$select.val().split('--')[0], "_blank");
				});
			});
		}
		
		function disableAnimation(timeOut) {
			setTimeout(function() {
				$.GoPricing.$wrap =  $('.gw-go');
				$.GoPricing.disableAnim();
			}, timeOut)
		}

		disableAnimation(5);
				
		$( '.fl-builder-content' ).on( 'fl-builder.layout-rendered', function() {
			disableAnimation(500);
		});				
		
    });

})(jQuery);