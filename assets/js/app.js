(jQuery)($ => {
    $(document).ready(function($) {

        $('#wfTriggerUpdate').click(e => {
            e.preventDefault();

            $('#loading-indicator').show();

            const data = {
                'action': 'fetch_whise'
            };
    
            $.post(ajaxurl, data, function(response) {
                $('#loading-indicator').hide();
                $('#message-text').show().text(response);
            });
        });

    });
});