(jQuery)($ => {
    $(document).ready(function($) {

        $('#wfTriggerUpdate').click(e => {
            const data = {
                'action': 'fetch_whise'
            };
    
            $.post(ajaxurl, data, function(response) {
                alert('Got this from the server: ' + response);
            });
        });
        
    });
});