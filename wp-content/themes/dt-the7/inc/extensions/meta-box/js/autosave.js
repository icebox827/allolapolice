jQuery( function( $ )
{
	$( document ).ajaxSend( function( e, xhr, s )
	{
		if ( -1 != s.data.indexOf( 'action=autosave' ) )
		{
			$( '.the7-mb-meta-box').each( function()
			{
				var $meta_box = $( this );
				if ( $meta_box.data( 'autosave' ) == true )
				{
					s.data += '&' + $meta_box.find( ':input' ).serialize();
				}
			} );
		}
	} );
} );
