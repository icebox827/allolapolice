jQuery(document).ready( function($) {

    function updatePresetsList(newPresetsList) {
        var newOptionsHTML = newPresetsList.reduce(function (str, presetName) {
            return str + '<option value="' + presetName.id + '">' + presetName.name + '</option>';
        }, '');
        $('#the7-post-meta-presets').html(newOptionsHTML);
    }

    function isError(response) {
        return !response.success;
    }

    function alertError(response) {
        try {
            alert(response.data.msg);
        } catch (e) {
            console.log(e);
        }
    }

    function getPostMeta() {
        return $('.the7-mb-field').find(':input').serializeArray();
    }

    function presetActionsVisibilityCheck() {
        var id = $('#the7-post-meta-presets').val();
        var $buttons = $('#the7-post-meta-save-preset, #the7-post-meta-delete-preset, #the7-post-meta-apply-preset');

        if (id) {
            $buttons.removeAttr('disabled');
        } else {
            $buttons.attr('disabled', 'disabled');
        }
    }

    $('#the7-post-meta-apply-preset').on('click', function (event) {
        event.preventDefault();

        var postID = $('#post_ID').val();
        var id = $('#the7-post-meta-presets').val();

        if (id === '') {
            return;
        }

        var $this = $(this);
        var originText = $this.text();
        $this.addClass('active ready').text(the7MetaPresetsStrings.applyingPreset);

        $.post(ajaxurl, {
            action: 'the7_meta_preset',
            preset_action: 'apply_preset',
            _ajax_nonce: the7MetaPresetsNonces._ajax_nonce,
            postID: postID,
            id: id
        })
            .done(function (response) {
                if ( isError(response) ) {
                    $this.removeClass('active ready').text(originText);
                    alertError(response);
                    return;
                }

                window.location.reload();
            })
            .fail(function () {
                $this.removeClass('active ready').text(originText);
            });
    });

    $('#the7-post-meta-delete-preset').on('click', function (event) {
        event.preventDefault();

        var postID = $('#post_ID').val();
        var id = $('#the7-post-meta-presets').val();

        if (id === '') {
            return;
        }

        $.post(ajaxurl, {
            action: 'the7_meta_preset',
            preset_action: 'delete_preset',
            _ajax_nonce: the7MetaPresetsNonces._ajax_nonce,
            postID: postID,
            id: id
        })
            .done(function (response) {
                if ( isError(response) ) {
                    alertError(response);
                    return;
                }

                try {
                    updatePresetsList(response.data.presetsNames);
                    presetActionsVisibilityCheck();
                } catch (e) {
                    // Some error handling.
                    console.log(e);
                }
            });
    });

    $('#the7-post-meta-add-preset').on('click', function (event) {
        event.preventDefault();

        var title = prompt(the7MetaPresetsStrings.enterName, '');
        title = title.trim();
        if (!title) {
            return;
        }

        var postID = $('#post_ID').val();

        $.post(ajaxurl, {
            action: 'the7_meta_preset',
            preset_action: 'add_preset',
            _ajax_nonce: the7MetaPresetsNonces._ajax_nonce,
            postID: postID,
            title: title,
            meta: getPostMeta()
        })
            .done(function (response) {
                if ( isError(response) ) {
                    alertError(response);
                    return;
                }

                try {
                    updatePresetsList(response.data.presetsNames);
                    presetActionsVisibilityCheck();
                } catch (e) {
                    // Some error handling.
                    console.log(e);
                }
            });
    });

    $('#the7-post-meta-save-preset').on('click', function (event) {
        event.preventDefault();

        var postID = $('#post_ID').val();
        var id = $('#the7-post-meta-presets').val();

        if (id === '') {
            return;
        }

        $.post(ajaxurl, {
            action: 'the7_meta_preset',
            preset_action: 'save_preset',
            _ajax_nonce: the7MetaPresetsNonces._ajax_nonce,
            postID: postID,
            id: id,
            meta: getPostMeta()
        })
            .done(function (response) {
                if ( isError(response) ) {
                    alertError(response);
                    return;
                }

                alert(the7MetaPresetsStrings.presetSaved);
            });
    });

    $('#the7-post-meta-save-defaults').on('click', function (event) {
        event.preventDefault();

        var postID = $('#post_ID').val();

        $.post(ajaxurl, {
            action: 'the7_meta_preset',
            preset_action: 'save_defaults',
            _ajax_nonce: the7MetaPresetsNonces._ajax_nonce,
            postID: postID,
            meta: getPostMeta()
        })
            .done(function (response) {
                if ( isError(response) ) {
                    alertError(response);
                    return;
                }

                alert(the7MetaPresetsStrings.defaultsSaved);
            });
    });
});