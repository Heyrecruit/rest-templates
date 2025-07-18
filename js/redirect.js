$(document).ready(function () {

    let redirect = findGetParameter('redirect_url');

    if(redirect !== null) {
        let decodedUrl = decodeURIComponent(redirect); // decode it back

        // Send page_view event with callback for redirect
        gtag('event', 'page_view', {
            'event_callback': function() {
                window.location.href = decodedUrl;
            }
        });

        // Fallback redirect after 500 ms in case callback fails
        setTimeout(function() {
            window.location.href = decodedUrl;
        }, 500);
    }

    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        var items = location.search.substr(1).split("&");
        for (var index = 0; index < items.length; index++) {
            tmp = items[index].split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        }
        return result;
    }
});
