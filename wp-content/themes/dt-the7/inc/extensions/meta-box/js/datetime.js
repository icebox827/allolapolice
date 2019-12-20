/**
 * Update datetime picker element
 * Used for static & dynamic added elements (when clone)
 */
jQuery( document ).ready( function( $ )
{
	$( ':input.the7-mb-datetime' ).each( the7_mb_update_datetime_picker );
	$( '.the7-mb-input' ).on( 'clone', ':input.the7-mb-datetime', the7_mb_update_datetime_picker );
	
	function the7_mb_update_datetime_picker()
	{
		var $this = $( this ),
			options = $this.data( 'options' );
	
		$this.siblings( '.ui-datepicker-append' ).remove();         // Remove appended text
		$this.removeClass( 'hasDatepicker' ).attr( 'id', '' ).datetimepicker( options );
	
	}
} );
