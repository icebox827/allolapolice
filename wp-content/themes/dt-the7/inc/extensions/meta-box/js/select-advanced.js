/**
 * Update select2
 * Used for static & dynamic added elements (when clone)
 */
jQuery( document ).ready( function ( $ )
{	
	$( ':input.the7-mb-select-advanced' ).each( the7_mb_update_select_advanced );
	$( '.the7-mb-input' ).on( 'clone', ':input.the7-mb-select-advanced', the7_mb_update_select_advanced );
	
	function the7_mb_update_select_advanced()
	{
		var $this = $( this ),
			options = $this.data( 'options' );
		$this.siblings('.select2-container').remove();
		$this.select2( options );	
	}
} );