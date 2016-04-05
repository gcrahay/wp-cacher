(function( $ ) {
    var $postCacheabilitySelect = $("#post-cacheability-select");
    var $postCacheability = $('#cacheability');
    function updateCacheability() {
       var checked_input_id = $("input[name=cacheability]:checked").attr("id");
       $postCacheability.find('#cacheability-label').text($("label[for='" + checked_input_id + "']").text())
    }
    $("input[name=cacheability]").on('change', function() {
        updateCacheability();
    });
    $( '#cacheability .edit-cacheability').click( function( e ) {
            e.preventDefault();
            if ( $postCacheabilitySelect.is(':hidden') ) {
                    $postCacheabilitySelect.slideDown( 'fast', function() {
                            $postCacheabilitySelect.find( 'input[type="radio"]:checked' ).first().focus();
                    } );
                    $(this).hide();
            }
    });
    $postCacheabilitySelect.find('.cancel-post-cacheability').click( function( event ) {
            $postCacheabilitySelect.slideUp('fast');
            $('#cacheability-radio-' + $('#hidden-post-cacheabililty').val()).prop('checked', true);
            $('#cacheability .edit-cacheability').show().focus();
            updateCacheability();
            event.preventDefault();
    });
    $postCacheabilitySelect.find('.save-post-cacheability').click( function( event ) {
            $postCacheabilitySelect.slideUp('fast');
            $('#cacheability .edit-cacheability').show().focus();
            updateCacheability();
            event.preventDefault();
    });
})( jQuery );