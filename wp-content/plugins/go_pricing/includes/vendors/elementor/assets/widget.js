;(function ($, undefined) {
    'use strict';

    $(function () {

		// Disable animation function
		function disableAnimation(timeOut) {
			setTimeout(function() {
				var iframe = $('#elementor-preview-iframe')[0],
					ifamejQ = (iframe.contentWindow || iframe).jQuery;
				ifamejQ.GoPricing.$wrap = $(iframe).contents().find('.gw-go');
				ifamejQ.GoPricing.disableAnim();
			}, timeOut)
		}
		
        /**
         * After any widget panel is open
         */		
        elementor.hooks.addAction('panel/open_editor/widget', function( self, model, view ) {

            /**
             * After ajax refresh is ready
             */
            model.on( 'remote:render', function() {
				var $html = $('<div/>', { html : model.attributes.htmlCache });
				if ($html.find('.gw-go')) {
					disableAnimation(10);
				}
            });
			
        });		
		
        /**
         * After drag and drop is ready
         */		
		elementor.channels.data.on('drag:after:update', function(model) {
			
			var $html = $('<div/>', { html : model.attributes.htmlCache });
			if ($html.find('.gw-go')) {
				disableAnimation(10);
			}
		})

        /**
         * After preview is loaded
         */
        elementor.on( 'preview:loaded', function(e) {
			
			setTimeout(function() {
				var iframe = $('#elementor-preview-iframe')[0];
				disableAnimation(10);
				var $target = null;
				
				$(iframe).contents().on('mousedown mouseup', '.elementor-editor-element-duplicate', function(e) {
					if (e.type == 'mousedown')  {
						$target = $(this);
						return;
					}
					
					// Do click
					if ($target.is($(this))) {
						disableAnimation(100);						
					}
					
					$target = null;

				});
								
			},10);
			
            $('.elementor-panel').on('click', '.go-pricing_btn-edit-table', function(e) {
				e.preventDefault();
				var $select = $('.elementor-panel').find('select[data-setting="go_pricing--id"]');	
				if (!$select.length || $select.val() === null || $select.val().split('--')[0] == "0" ) return;
				window.open($(this).data('url-base') + '='+$select.val().split('--')[0], "_blank");
            });
        });		

    });

})(jQuery);