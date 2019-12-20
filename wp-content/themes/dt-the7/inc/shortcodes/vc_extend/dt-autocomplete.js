!function($) {
    // VC Autocomplete on click.
    $('input.vc_auto_complete_param')
        .on('click', function() {
            var $this = $(this);

            if (!$this.data('autocompleteIsOpen')) {
                $this.autocomplete('search', '');
            }
        })
        .on('autocompleteopen', function() {
            $(this).data('autocompleteIsOpen', true);
        })
        .on('autocompleteclose', function() {
            $(this).data('autocompleteIsOpen', false);
        });
}(window.jQuery);
