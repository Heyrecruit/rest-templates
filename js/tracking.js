console.log(TRACKING_SETTINGS);

function getCookie (name) {
    return ('; '+document.cookie).split('; '+name+'=').pop().split(';').shift() || '';
}
function hasConsent(group) {
    // Erwartet CookieBot-ähnliches JSON im "cb"-Cookie
    try {
        const c = JSON.parse(getCookie('cb') || '{}');
        if (group === 'analytics')  return c.statisticsCookies === 1 || c.gtm === 1;
        if (group === 'marketing')  return c.marketingCookies  === 1;
    } catch(_) {}
    return false;
}
/* GTM-Container nachladen -------------------------------------------------- */
function loadGTM(containerId) {
    (function(w,d,s,l,i){
        w[l]=w[l]||[]; w[l].push({ 'gtm.start':Date.now(), event:'gtm.js' });
        const f=d.getElementsByTagName(s)[0], j=d.createElement(s), dl=l!='dataLayer'?'&l='+l:'';
        j.async=true; j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
        f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer',containerId);
}
/* Meta-Pixel --------------------------------------------------------------- */
function loadMeta(id){
    !function(f,b,e,v,n,t,s){ if(f.fbq)return; n=f.fbq=function(){ n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments) }; if(!f._fbq)f._fbq=n;
        n.push=n; n.loaded=!0; n.version='2.0'; n.queue=[]; t=b.createElement(e); t.async=!0;
        t.src=v; s=b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s);
    }(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', id); fbq('track', 'PageView');
}
/* LinkedIn Insight --------------------------------------------------------- */
function loadLinkedIn(pid){
    window._linkedin_partner_id = pid;
    window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
    window._linkedin_data_partner_ids.push(pid);
    const s=document.createElement('script'); s.async=true;
    s.src='https://snap.licdn.com/li.lms-analytics/insight.min.js';
    document.head.appendChild(s);
}
/* TikTok Pixel ------------------------------------------------------------- */
function loadTikTok(id){
    !function(w,d,t){ w.TiktokAnalyticsObject=t;
        const ttq=w[t]=w[t]||[]; ttq.methods=["page","track","identify","instances",
            "debug","on","off","once","ready","alias","group","enableCookie","disableCookie"];
        ttq.setAndDefer=function(a,b){a[b]=function(){a.push([b].concat(
            Array.prototype.slice.call(arguments,0)))}}; for(let i=0;i<ttq.methods.length;i++)
            ttq.setAndDefer(ttq,ttq.methods[i]); ttq.load=function(i){
            const e=d.createElement("script"); e.async=!0;
            e.src="https://analytics.tiktok.com/i18n/pixel/events.js?sdkid="+i+"&lib="+t;
            d.head.appendChild(e); ttq._i=ttq._i||{}; ttq._i[i]=[]; ttq._t=ttq._t||{};
            ttq._t[i]=+new Date(); ttq._o=ttq._o||{}; ttq._o[i]={}; }; }(window,document,'ttq');
    ttq.load(id); ttq.page();
}
/* Google Ads Conversion ---------------------------------------------------- */
function loadGoogleAds(cfg){
    // Basistag kommt über denselben gtag-Loader wie GA4 (GTM-Container)
    gtag('config', cfg.awId);   // Remarketing-Basis
    // Conversion-Event z. B. auf "Thank-You"-Seite auslösen:
    // gtag('event','conversion',{ send_to: cfg.awId+'/'+cfg.label, value:1.0, currency:'EUR' });
}

/* ------------------------------------------------------------------
   Consent-Mode V2 ➜ Defaults VOR Banner
------------------------------------------------------------------ */
window.dataLayer = window.dataLayer || [];
function gtag(){
    dataLayer.push(arguments);
}

gtag('consent','default',{
    ad_storage        : 'denied',
    analytics_storage : 'denied',
    ad_user_data      : 'denied',
    ad_personalization: 'denied',
    wait_for_update   : 500        // ms – blockt Requests kurz, bis update erfolgt
});

/* ------------------------------------------------------------------
   Warten bis DOM ready  ➜ Consent prüfen ➜ Tags laden
------------------------------------------------------------------ */
document.addEventListener('DOMContentLoaded', () => {

    const grantedAnalytics = hasConsent('analytics');
    const grantedMarketing = hasConsent('marketing');

    /* 4a) Consent-Update an Google senden ----------------------------- */
    if (grantedAnalytics || grantedMarketing){
        gtag('consent','update',{
            analytics_storage : grantedAnalytics ? 'granted' : 'denied',
            ad_storage        : grantedMarketing ? 'granted' : 'denied',
            ad_user_data      : grantedMarketing ? 'granted' : 'denied',
            ad_personalization: grantedMarketing ? 'granted' : 'denied'
        });
        dataLayer.push({ event:'consent_update' });
    }

    /* Tags abhängig von den Rechten laden ------------------------ */
    if (grantedAnalytics) {
        if (TRACKING_SETTINGS.google_ga4)  loadGTM(TRACKING_SETTINGS.google_ga4.measurementId);
    }
    if (grantedMarketing) {
        if (TRACKING_SETTINGS.google_ads)       loadGoogleAds(TRACKING_SETTINGS.google_ads);
        if (TRACKING_SETTINGS.meta_pixel)       loadMeta(TRACKING_SETTINGS.meta_pixel.id);
        if (TRACKING_SETTINGS.linkedin_insight) loadLinkedIn(TRACKING_SETTINGS.linkedin_insight.partnerId);
        if (TRACKING_SETTINGS.tiktok_pixel)     loadTikTok(TRACKING_SETTINGS.tiktok_pixel.id);
    }

    if(typeof GTM4_GLOBAL_ID !== 'undefined') {
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
        })(window, document, "script", "dataLayer", GTM4_GLOBAL_ID);
    }
});