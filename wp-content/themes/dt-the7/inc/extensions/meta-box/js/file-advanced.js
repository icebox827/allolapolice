jQuery( function( $ )
{
	var template =  wp.media.template('the7-mb-file-advanced');

	$( 'body' ).on( 'click', '.the7-mb-file-advanced-upload', function( e )
	{
		e.preventDefault();

		var $uploadButton = $( this ),
			$fileList = $uploadButton.siblings( '.the7-mb-uploaded' ),
			maxFileUploads = $fileList.data( 'max_file_uploads' ),
			mimeType = $fileList.data( 'mime_type' ),
			msg = maxFileUploads > 1 ? the7mbFile.maxFileUploadsPlural : the7mbFile.maxFileUploadsSingle,
			frame,
			frameOptions = {
				className: 'media-frame the7-mb-file-frame',
				multiple: true,
				title: the7mbFileAdvanced.frameTitle
			};

		msg = msg.replace( '%d', maxFileUploads );

		// Create a media frame
		if ( mimeType )
		{
			frameOptions.library = {
				type: mimeType
			};
		}
		frame = wp.media( frameOptions );

		// Open media uploader
		frame.open();

		// Remove all attached 'select' event
		frame.off( 'select' );

		// Handle selection
		frame.on( 'select', function()
		{
			// Get selections
			var selection = frame.state().get( 'selection' ).toJSON(),
				uploaded = $fileList.children().length,
				ids;

			if ( maxFileUploads > 0 && ( uploaded + selection.length ) > maxFileUploads )
			{
				if ( uploaded < maxFileUploads )
					selection = selection.slice( 0, maxFileUploads - uploaded );
				alert( msg );
			}

			// Get only files that haven't been added to the list
			// Also prevent duplication when send ajax request
			selection = _.filter( selection, function( attachment )
			{
				return $fileList.children( 'li#item_' + attachment.id ).length == 0;
			} );
			ids = _.pluck( selection, 'id' );

			if ( ids.length > 0 )
			{
				// Attach attachment to field and get HTML
				var data = {
					action: 'the7_mb_attach_file',
					post_id: $( '#post_ID' ).val(),
					field_id: $fileList.data( 'field_id' ),
					attachment_ids: ids,
					_ajax_nonce: $uploadButton.data( 'attach_file_nonce' )
				};
				$.post( ajaxurl, data, function( r )
				{
					if ( r.success )
					{
						$fileList
							.append( template( { attachment: selection[0] } ) )
							.trigger( 'update.the7mbFile' );
					}
				}, 'json' );
			}
		} );
	} );
} );
