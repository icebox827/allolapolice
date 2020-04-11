/**
 * Update color picker element
 * Used for static & dynamic added elements (when clone)
 */
jQuery( document ).ready( function( $ )
{	
	$( ':input.the7-mb-color' ).each( the7_mb_update_color_picker );
	$( '.the7-mb-input' ).on( 'clone', ':input.the7-mb-color', the7_mb_update_color_picker )
	.on( 'focus', '.the7-mb-color', function()
	{
		$( this ).siblings( '.the7-mb-color-picker' ).show();
		return false;
	} ).on( 'blur',  '.the7-mb-color', function()
	{
		$( this ).siblings( '.the7-mb-color-picker' ).hide();
		return false;
	} );
	
	function the7_mb_update_color_picker()
	{
		var $this = $( this ),
			$clone_container = $this.closest('.the7-mb-clone'),
			$color_picker = $this.siblings( '.the7-mb-color-picker' );

		if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ){
			if( $clone_container.length > 0 )
			{
				$this.appendTo( $clone_container ).siblings( 'div.wp-picker-container' ).remove();
			}
        	$this.wpColorPicker();
		}
		else {
			//We use farbtastic if the WordPress color picker widget doesn't exist
			$color_picker.farbtastic( $this );			
		}			
	}

} );