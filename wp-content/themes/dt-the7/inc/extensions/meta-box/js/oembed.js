jQuery( document ).ready( function( $ )
{
	$( '.the7-mb-input' ).on( 'click', 'a.show-embed', function() {
		var $this = $( this ),
			$input = $this.siblings( ':input.the7-mb-oembed' );
			$embed_container = $this.siblings( '.embed-code' ),
			data = {
				action : 'the7_mb_get_embed',
				oembed_url: $input.val(),
				post_id : $( '#post_ID' ).val()
			};
		$embed_container.html( "<img class='the7-mb-loader' height='64' width='64' src='" + RWMB_OEmbed.url + "img/loader.gif'>" );
		$.post( ajaxurl, data, function( r )
		{
			var res = wpAjax.parseAjaxResponse( r, 'ajax-response' );

			if ( res.errors )
				alert( res.responses[0].errors[0].message );
			else
				$embed_container.html( res.responses[0].data );

		}, 'xml' );


		return false;

	});
} );
