$(document).ready(function () {

    /**
     * gtag
     *
     * push the permission to google
     */
    function gtag() {
        window.dataLayer.push(arguments);
    }

    /**
     * get cookie value by name
     * @param cname
     * @returns {null}
     */
    function getCookie(cname) {
        var b = document.cookie.match('(^|;)\\s*' + cname + '\\s*=\\s*([^;]+)');

        return b ? b.pop() : null;
    }

    gtag('consent', 'default', {
        ad_storage: 'denied',
        analytics_storage: 'denied',
        wait_for_update: 500
    });
    if(typeof gtm4IdGlobal !== 'undefined') {
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                "gtm.start": new Date().getTime(),
                event: "gtm.js"
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l !== "dataLayer" ? "&l=" + l : "";
            j.async = true;
            j.src = "https://www.googletagmanager.com/gtm.js?id=" + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, "script", "dataLayer", gtm4IdGlobal);
    }

    var cbCookie = getCookie('cb');
    var cbCookieJson = JSON.parse(cbCookie);

    if (cbCookie && (cbCookieJson.statisticsCookies === 1 || cbCookieJson.gtm === 1)) {

        gtag('consent', 'update', {
            ad_storage: 'granted',
            analytics_storage: 'granted'
        });

        window.dataLayer.push({
            'event': 'consent_update'
        })
    }
});
