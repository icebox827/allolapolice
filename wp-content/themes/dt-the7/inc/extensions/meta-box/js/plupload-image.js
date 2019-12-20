jQuery( function( $ )
{
	// Hide "Uploaded files" title if there are no files uploaded after deleting files
	$( '.the7-mb-images' ).on( 'click', '.the7-mb-delete-file', function()
	{
		// Check if we need to show drop target
		var $dragndrop = $( this ).parents( '.the7-mb-images' ).siblings( '.the7-mb-drag-drop' );

		// After delete files, show the Drag & Drop section
		$dragndrop.removeClass('hidden');
	} );

	$('.the7-mb-drag-drop').each(function()
	{
		// Declare vars
		var $dropArea = $( this ),
			$imageList = $dropArea.siblings( '.the7-mb-uploaded' ),
			uploaderData = $dropArea.data( 'js_options' ),
			the7mbUploader = {};

		// Extend uploaderData
		uploaderData.multipart_params = $.extend(
			{
				_ajax_nonce	:  $dropArea.data( 'upload_nonce' ),
				post_id 	: $( '#post_ID' ).val()
			},
			uploaderData.multipart_params
		);

		// Create uploader
		the7mbUploader = new plupload.Uploader( uploaderData );
		the7mbUploader.init();

		// Add files
		the7mbUploader.bind( 'FilesAdded', function( up, files )
		{
			var maxFileUploads = $imageList.data('max_file_uploads'),
				uploaded = $imageList.children().length,
				msg = maxFileUploads > 1 ? the7mbFile.maxFileUploadsPlural : the7mbFile.maxFileUploadsSingle;

			msg = msg.replace( '%d', maxFileUploads );

			// Remove files from queue if exceed max file uploads
			if ( maxFileUploads > 0  && ( uploaded + files.length ) > maxFileUploads )
			{
				if ( uploaded < maxFileUploads )
				{
					var diff = maxFileUploads - uploaded;
					up.splice( diff - 1, files.length - diff );
					files = up.files;
				}
				alert( msg );
			}

			// Hide drag & drop section if reach max file uploads
			if ( uploaded + files.length >= maxFileUploads )
				$dropArea.addClass( 'hidden' );

			max = parseInt( up.settings.max_file_size, 10 );

			// Upload files
			plupload.each( files, function( file )
			{
				addLoading( up, file, $imageList );
				addThrobber( file );
				if ( file.size >= max )
					removeError( file );
			} );
			up.refresh();
			up.start();

		} );

		the7mbUploader.bind( 'Error', function( up, e )
		{
			addLoading( up, e.file, $imageList );
			removeError( e.file );
			up.removeFile( e.file );
		} );

		the7mbUploader.bind( 'FileUploaded', function( up, file, response )
		{
			var res = wpAjax.parseAjaxResponse( $.parseXML( response.response ), 'ajax-response' );
			false === res.errors ? $( 'li#' + file.id ).replaceWith( res.responses[0].data ) : removeError( file );
		} );
	});

	/**
	 * Helper functions
	 */

	/**
	 * Removes li element if there is an error with the file
	 *
	 * @return void
	 */
	function removeError( file )
	{
		$( 'li#' + file.id )
			.addClass( 'the7-mb-image-error' )
			.delay( 1600 )
			.fadeOut( 'slow', function()
			{
				$( this ).remove();
			}
		);
	}

	/**
	 * Adds loading li element
	 *
	 * @return void
	 */
	function addLoading( up, file, $ul )
	{
		$ul.removeClass('hidden').append( "<li id='" + file.id + "'><div class='the7-mb-image-uploading-bar'></div><div id='" + file.id + "-throbber' class='the7-mb-image-uploading-status'></div></li>" );
	}

	/**
	 * Adds loading throbber while waiting for a response
	 *
	 * @return void
	 */
	function addThrobber( file )
	{
		$( '#' + file.id + '-throbber' ).html( "<img class='the7-mb-loader' height='64' width='64' src='" + RWMB.url + "img/loader.gif'/>" );
	}
} );
