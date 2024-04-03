var cookieBanner = {
    /**
     * load cookieBanner init function
     */
    init: function cookieBanner() {

        var bodyData = document.querySelector('body').dataset,
            ga4MeasurementId = bodyData.ga4MeasurementId,
            gtmPropertyId = bodyData.gtmPropertyId,
            domain = bodyData.domain,
            companyName = bodyData.companyName,
            datenschutzUrl = bodyData.datenschutzUrl,
            datenschutzClass = bodyData.datenschutzClass,
            // cookieBanner options object
            cbo = {
                essentialCookies: {
                    active: true,
                    title: 'Unbedingt erforderliche Cookies',
                    info: 'Essenzielle Cookies ermöglichen grundlegende Funktionen und sind für die' +
                        ' einwandfreie Funktion der Website erforderlich.',
                    group: {
                        cookieBanner: {
                            active: true,
                            closeable: false,
                            expires: 180,
                            cookies: {
                                cb: {
                                    company: companyName,
                                    infoText: 'Speichert Ihre Cookie-Einstellungen',
                                    expires: '180 Tage',
                                    type: 'HTTP Cookie'
                                }
                            }
                        },
                        PHPSESSID: {
                            active: true,
                            cookies: {
                                PHPSESSID: {
                                    company: 'Scope Recruiting',
                                    infoText: 'Enthält eine anonyme Nutzer-ID, um mehrere Anfragen eines Nutzers derselben' +
                                        ' HTTP-Session zuordnen zu können. Dieses Cookie wird vom Scope Recruiting verwendet.',
                                    expires: 'Wird beim Schließen des Browsers gelöscht.',
                                    type: 'HTTP-Session'
                                }
                            }
                        },
                        'scope_analytics[current_page]': {
                            active: true,
                            cookies: {
                                'scope_analytics[current_page]': {
                                    company: 'Scope Recruiting',
                                    infoText: 'Speichert die aktuelle aufgerufene Url.',
                                    expires: '1 Tag',
                                    type: 'HTTP Cookie'
                                }
                            }
                        },
                        'scope_analytics[referrer]': {
                            active: true,
                            cookies: {
                                'scope_analytics[referrer]': {
                                    company: 'Scope Recruiting',
                                    infoText: 'Speichert den aktuellen Referer.',
                                    expires: '1 Tag',
                                    type: 'HTTP Cookie'
                                }
                            }
                        },
                        'Google Maps': {
                            active: true,
                            cookies: {
                                NID: {
                                    company: 'Google',
                                    infoText: 'Wird zum Entsperren von Google Maps-Inhalten verwendet.',
                                    expires: '6 Monate',
                                    type: 'HTTP Cookie'
                                }
                            }
                        },
                        'ga4MeasurementId': {
                            active: true,
                            cookies: {
                                'ga4MeasurementId': {
                                    company: 'Google',
                                    infoText: 'Enthält die GA4-Mess-ID',
                                    expires: 'Wird beim Schließen des Browsers gelöscht.',
                                    type: 'HTTP-Session'
                                }
                            }
                        },
                    }
                },
                statisticsCookies: {
                    active: true,
                    title: 'Statistiken',
                    info: 'Statistik Cookies erfassen Informationen anonym.' +
                        ' Diese Informationen helfen uns zu verstehen, wie unsere Besucher unsere Website nutzen.',
                    group: {
                        gtm: {
                            active: true,
                            groupName: 'Google Tag Manager',
                            containerId: ga4MeasurementId,
                            loadGtmIframe: true,
                            loadIframe: true,
                            activeCookie: function () {
                                setGtmCookies();
                            },
                            deleteCookie: function () {
                                deleteGroupCookie(this.cookies);
                            },
                            cookies: {
                                _ga: {
                                    company: 'Google Tag Manager, Google',
                                    infoText: 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten zu erheben (z. B. Besucher einer Webseite).',
                                    expires: '2 Jahre',
                                    type: 'HTTP Cookie',
                                    domain: '.' + domain,
                                    path: '/'
                                },
                                _gid: {
                                    company: 'Google Tag Manager, Google',
                                    infoText: 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten zu erheben (z. B. Besucher einer Webseite).',
                                    expires: '1 Tag',
                                    type: 'HTTP Cookie',
                                    domain: '.' + domain,
                                    path: '/'
                                },
                                'Google_UA_ID': {
                                    company: 'Google Tag Manager, Google',
                                    infoText: 'Registriert eine eindeutige ID, die verwendet wird, um statistische Daten zu erheben (z. B. Besucher einer Webseite).',
                                    expires: '1 Minute',
                                    type: 'HTTP Cookie',
                                    domain: '.' + domain,
                                    path: '/'
                                }
                            }
                        }
                    }
                },
                marketingCookies: {
                    active: false,
                    title: 'Marketing',
                    info: 'Marketing Cookies erfassen Informationen anonym.' +
                        'Diese Informationen helfen uns zu verstehen, wie unsere Besucher unsere Website nutzen.',
                    group: {}
                }
            };
        var cboc = cbo.essentialCookies.group.cookieBanner,
            cboExpires = cboc.expires,
            cbCookie = getCookie('cb'),
            cbCookieJson = JSON.parse(cbCookie);

        // check if cookieBanner is active
        if (!cboc.active)
            return false;

        // check cookie state from CookieBanner
        if (!checkBannerState())
            return loadCookieBanner();

        // add clickEvent to open cookie info-modal
        addEvent('#openCookieInfoModal', 'click', loadCbInfoModal);

        // loads activeted cookies
        activeGroupCookies();

        /**
         * check banner state
         * @returns {null}
         */
        function checkBannerState() {
            return getJsonCookie('cb', 'state');
        }

        /**
         * show or hide cookie-banner
         * @param state
         */
        function showHideCb(state) {
            if (state) {
                if (!cboc.closeable)
                    removeClass('.cookie', 'closeable');
                addClass('.cookieHinweisWrapper', 'view');
            } else {
                removeClass('.cookieHinweisWrapper', 'view');
            }
        }

        /**
         * show cookie-banner
         */
        function showCb() {
            return showHideCb(true);
        }

        /**
         * add event to selector(s)
         * @param selectors
         * @param eventType
         * @param functionName
         */
        function addEvent(selectors, eventType, functionName) {
            var querySelector = document.querySelectorAll(selectors);
            querySelector.forEach(function (key) {
                key.addEventListener(eventType, functionName);
            })
        }

        /**
         * add or remove class(es) from all selectors
         * @param selector
         * @param className
         * @param type
         */
        function addRemoveClass(selector, className, type) {
            var querySelector = document.querySelectorAll(selector);
            querySelector.forEach(function (key) {
                var classList = key.classList,
                    newClassName = className.replace(' ', ''),
                    newClassNameSplit = newClassName.split(',');
                newClassNameSplit.forEach(function (cnKey) {
                    type ? classList.add(cnKey) : classList.remove(cnKey);
                });
            });
        }

        /**
         * add class(es) from all selectors
         * @param selector
         * @param className
         */
        function addClass(selector, className) {
            return addRemoveClass(selector, className, true);
        }

        /**
         * remove class(es) from all selectors
         * @param selector
         * @param className
         */
        function removeClass(selector, className) {
            return addRemoveClass(selector, className, false);
        }

        /**
         * load cookie-banner
         */
        function loadCookieBanner() {
            loadCookieModal();
            loadEvents2Cookie();
            setTimeout(showCb, 500);
        }

        /**
         * active or delete cookies from category group
         * @param type
         */
        function activeDeleteGroupCookies(type) {
            var cbc = {};
            Object.keys(cbo).forEach(function (key) {
                    var cboCategories = cbo[key];
                    if (cboCategories.active && key !== 'essentialCookies') {
                        var cboGroup = cboCategories['group'];
                        cbc[key] = 1;
                        Object.keys(cboGroup).forEach(function (groupKey) {
                            var cboCookie = cboGroup[groupKey];
                            if (cboCookie.active) {
                                type ? cboCookie.activeCookie() : cboCookie.deleteCookie();
                            }
                        });
                    }
                }
            );
            setCbCookie(cbc);
        }

        /**
         * accept all Cookies
         */
        function acceptAllCookies() {
            activeDeleteGroupCookies(true);
            var element = document.querySelector('.cookieHinweisWrapper');
            element.parentNode.removeChild(element);
            addEvent('#openCookieInfoModal', 'click', loadCbInfoModal);
            fadeOut('.cookie', 200);
        }

        /**
         * read active groups from cb-cookies and load them
         */
        function activeGroupCookies() {
            var cbc = getCookie('cb'),
                json = JSON.parse(cbc),
                key;
            delete json['state'];
            for (key in json) {
                if (json.hasOwnProperty(key) && key !== 'essentialCookies') {
                    if (cbo.hasOwnProperty(key) && cbo[key].active) {
                        var cboGroups = cbo[key].group;
                        Object.keys(cboGroups).forEach(function (groupKey) {
                            var cboGroup = cboGroups[groupKey];
                            if (cboGroup.active) {
                                cboGroup.activeCookie();

                            }
                        });
                    } else {
                        Object.keys(cbo).forEach(function (groupKey) {
                            var group = cbo[groupKey]['group'];
                            if (group !== 'cookieBanner' && group.hasOwnProperty(key) && group[key]['active']) {
                                group[key].activeCookie();
                            }
                        });
                    }
                }

            }
        }

        /**
         * delete cookies in group
         * @param group
         */
        function deleteGroupCookie(group) {
            Object.keys(group).forEach(function (groupKey) {
                var cboGroup = group[groupKey],
                    groupPath = cboGroup.path ? cboGroup.path : '',
                    groupDomain = cboGroup.domain ? cboGroup.domain : '';
                deleteCookie(groupKey, groupPath, groupDomain);

                if (groupKey === '_ga') {
                    gtag('consent', 'update', {
                        ad_storage: 'denied',
                        analytics_storage: 'denied'
                    });

                    window.dataLayer.push({
                        'event': 'consent_update'
                    })
                }

            });
        }


        /**
         * save cookie settings
         */
        function saveCookieSettings() {
            var checkedBoxes = document.querySelectorAll('#cbSettings input:checked'),
                checked = {};
            checked['state'] = 1;
            if (checkedBoxes.length > 0) {
                checkedBoxes.forEach(function (element) {
                    checked[element.name] = 1;
                });
            }
            Object.keys(cbo).forEach(function (key) {
                    var cboCategories = cbo[key];
                    if (key !== 'essentialCookies') {
                        var cboGroup = cboCategories['group'];
                        Object.keys(cboGroup).forEach(function (groupKey) {
                            var cboCookie = cboGroup[groupKey];
                            if (cboCookie.active) {
                                checked.hasOwnProperty(key) ? cboCookie.activeCookie() : cboCookie.deleteCookie();
                            }
                        });
                    }
                }
            );
            setCbCookie(checked);
            fadeOut('.cookie');
        }

        /**
         * set the CookieBanner cookie
         * @param cbc
         */
        function setCbCookie(cbc) {
            cbc['state'] = 1;
            setJsonCookie('cb', cbc, cboExpires);
        }

        /**
         * load events to cookie modal
         */
        function loadEvents2Cookie() {
            if (cboc.closeable) {
                addEvent('.cookie .close', 'click', function () {
                    fadeOut('.cookie', 200);
                });
            }
            addEvent('.modalTrigger', 'click', function () {
                fadeOut('.cookieHinweisWrapper', 100);
                loadCbInfoModal();
            });
            addEvent('.button.acceptAll', 'click', function () {
                acceptAllCookies();
            });
        }

        /**
         * delete cookie
         * @param cName
         * @param cPath
         * @param cDomain
         */
        function deleteCookie(cName, cPath, cDomain) {
            cName = cName.replace('Google_UA_ID', gtmPropertyId);
            document.cookie = encodeURIComponent(cName) +
                '=; expires=Thu, 01 Jan 1970 00:00:00 GMT' +
                (cDomain ? '; domain=' + cDomain : '') +
                (cPath ? '; path=' + cPath : '');
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

        /**
         * set a cookie
         * @param cname
         * @param cvalue
         * @param exdays
         */
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = 'expires=' + d.toUTCString();
            document.cookie = cname + '=' + cvalue + ';' + expires + '/; SameSite=None; Secure';
        }

        /**
         * set cookie value in JSON format
         * @param cname
         * @param cvalue
         * @param cexp
         */
        function setJsonCookie(cname, cvalue, cexp) {
            setCookie(cname, JSON.stringify(cvalue), cexp);
        }

        /**
         * get JSON value from cookie, find by cookie name and JSON key
         * @param cname
         * @param ckey
         * @returns {null|*}
         */
        function getJsonCookie(cname, ckey) {
            var cookieValue = getCookie(cname);

            if (cookieValue) {
                var jValue = JSON.parse(cookieValue);
                if (jValue)
                    return jValue.hasOwnProperty(ckey) ? jValue[ckey] : null;
            }
            return null;
        }

        /**
         * get own host domain
         * @returns {string}
         */
        function getOwnHostDomain() {
            var host = window.location.host;
            return host.split('.').slice(-2).join('.');
        }

        /**
         * checks if a script was loaded
         * @param src
         * @returns {boolean}
         */
        function isScriptLoaded(src) {
            return !!document.querySelector('script[src="' + src + '"]');
        }

        /**
         * load events to cookie info modal
         */
        function loadEvents2InfoModal() {
            if (cboc.closeable) {
                addEvent('.cookieModal .close', 'click', function () {
                    fadeOut('.cookie', 200);
                });
            }
            addEvent('.infoTrigger', 'click', function () {
                slideToggle(this.nextSibling);
            });
            addEvent('.cookieModal .button.acceptAll', 'click', function () {
                activeDeleteGroupCookies(true);
                fadeOut('.cookie', 200);
            });
            addEvent('.cookieModal .button.safe', 'click', function () {
                saveCookieSettings();
                fadeOut('.cookie', 200);
            });
            addEvent('.switchGroup', 'click', function () {
                enableOrDisableAllCookiesInGroup(this);
            });
            addEvent('.ownSwitch', 'click', function () {
                enableOrDisablCookieGroup(this);

            });
            addEvent('.open_policy', 'click', function () {
                fadeIn('#popup', 200);
                fadeIn('#policy', 100);
            });

            addEvent('#openCookieInfoModal', 'click', loadCbInfoModal);

            if (datenschutzUrl === '#scope_datenschutz') {
                addEvent('.scope_open_modal', 'click', function () {
                    document.querySelector(datenschutzUrl).style.zIndex = '10000';
                });
            }
        }

        /**
         * Enable or disable all checkboxes in group
         * @param checkbox
         */
        function enableOrDisableAllCookiesInGroup(checkbox) {
            var groupCheckbox = checkbox.closest('.descrption')
                .querySelector('.cookieTable')
                .querySelectorAll('input[type=checkbox]');
            Object.keys(groupCheckbox).forEach(function (key) {
                groupCheckbox[key].checked = checkbox.checked;
            });
        }

        /**
         * Enable or disable the group checkbox
         * @param checkbox
         */
        function enableOrDisablCookieGroup(checkbox) {
            var groupCheckbox = checkbox.closest('.cookieTable')
                .querySelectorAll('input[type=checkbox]');
            var checkboxState = true;
            Object.keys(groupCheckbox).forEach(function (key) {
                checkboxState = !!(checkboxState && groupCheckbox[key].checked);
            });
            checkbox.closest('.cGroup').querySelector('.switchGroup').checked = checkboxState;
        }

        /**
         * slideUp
         * @param element
         * @param ms
         */
        function slideUp(element, ms) {
            var nms = ms ? ms : 1000,
                estyle = element.style;
            estyle.height = element.offsetHeight + 'px';
            estyle.transitionProperty = 'height, margin, padding';
            estyle.transitionDuration = nms + 'ms';
            element.offsetHeight;
            estyle.overflow = 'hidden';
            estyle.height = '0';
            estyle.paddingTop = '0';
            estyle.paddingBottom = '0';
            estyle.marginTop = '0';
            estyle.marginBottom = '0';
            window.setTimeout(function () {
                estyle.display = 'none';
                estyle.removeProperty('height');
                estyle.removeProperty('padding-top');
                estyle.removeProperty('padding-bottom');
                estyle.removeProperty('margin-top');
                estyle.removeProperty('margin-bottom');
                estyle.removeProperty('overflow');
                estyle.removeProperty('transition-duration');
                estyle.removeProperty('transition-property');
            }, nms)
        }

        /**
         * SlideDown
         * @param element
         * @param ms
         */
        function slideDown(element, ms) {
            var nms = ms ? ms : 1000,
                estyle = element.style,
                display = window.getComputedStyle(element).display;

            estyle.removeProperty('display');
            if (display === 'none')
                display = 'block';
            estyle.display = display;
            var height = element.offsetHeight;
            estyle.overflow = 'hidden';
            estyle.height = '0';
            estyle.paddingTop = '0';
            estyle.paddingBottom = '0';
            estyle.marginTop = '0';
            estyle.marginBottom = '0';
            element.offsetHeight;
            estyle.transitionProperty = 'height, margin, padding';
            estyle.transitionDuration = nms + 'ms';
            estyle.height = height + 'px';
            estyle.removeProperty('padding-top');
            estyle.removeProperty('padding-bottom');
            estyle.removeProperty('margin-top');
            estyle.removeProperty('margin-bottom');
            window.setTimeout(function () {
                estyle.removeProperty('height');
                estyle.removeProperty('overflow');
                estyle.removeProperty('transition-duration');
                estyle.removeProperty('transition-property');
            }, nms)
        }

        /**
         * slideToggle
         * @param element
         * @param ms
         */
        function slideToggle(element, ms) {
            var nms = ms ? ms : 1000;
            if (window.getComputedStyle(element).display === 'none') {
                return slideDown(element, nms);
            } else {
                return slideUp(element, nms);
            }
        }

        /**
         * fade in or out elements
         * @param elem
         * @param ms
         * @param type
         */
        function fadeInOut(elem, ms, type) {
            var querySelector = document.querySelectorAll(elem);
            querySelector.forEach(function (key) {
                var estyle = key.style,
                    opacity = 0,
                    nms = ms ? ms : 1000;
                if (type) {
                    estyle.opacity = '0';
                    estyle.filter = "alpha(opacity=0)";
                    estyle.display = "inline-block";
                    estyle.visibility = "visible";
                    var timer = setInterval(function () {
                        opacity += 50 / nms;
                        if (opacity >= 1) {
                            clearInterval(timer);
                            opacity = 1;
                        }
                        estyle.opacity = opacity;
                        estyle.filter = "alpha(opacity=" + opacity * 100 + ")";
                    }, 50);
                } else {
                    opacity = 1;
                    timer = setInterval(function () {
                        opacity -= 50 / nms;
                        if (opacity <= 0) {
                            clearInterval(timer);
                            opacity = 0;
                            estyle.display = "none";
                            estyle.visibility = "hidden";
                        }
                        estyle.opacity = opacity;
                        estyle.filter = "alpha(opacity=" + opacity * 100 + ")";
                    }, 50);
                }
            });
        }

        /**
         * fade in a element
         * @param elem
         * @param ms
         */
        function fadeIn(elem, ms) {
            if (!elem)
                return;
            fadeInOut(elem, ms, true)
        }

        /**
         * fade out a element
         * @param elem
         * @param ms
         */
        function fadeOut(elem, ms) {
            if (!elem)
                return;
            fadeInOut(elem, ms, false);
        }

        // ### CookieBanner template functions ###
        /**
         * load the cookie modal
         */
        function loadCookieModal() {
            var cookieTemplate =
                '<!-- Erweiterter Cookie-Hinweis -->' +
                '<div class="cookie backdrop closeable">' +
                '<div class="cookieHinweisWrapper">' +
                '<i class="fas fa-times close"></i>' +
                '<h2>Cookie-Hinweis</h2>' +
                '<p>' +
                'Wir nutzen Cookies auf unserer Website. Einige von ihnen sind essenziell,' +
                ' während andere uns helfen, diese Website und Ihre Erfahrung zu verbessern.' +
                '</p>' +
                '<div class="cookieControls">' +
                '<a class="button modalTrigger plain settings">Einstellungen</a>' +
                '<a class="button color accept acceptAll">Alle akzeptieren</a>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<!-- ende erweiterter Cookie-Hinweis -->';
            document.querySelector('body')
                .insertAdjacentHTML('beforeend', cookieTemplate);
        }

        /**
         * load only the cookie info-modal
         */
        function loadCbInfoModal() {
            var element = document.querySelector('.cookieModal'),
                celement = document.querySelector('.cookie'),
                policy_link;
            if (!element) {
                if (datenschutzClass !== '')
                    datenschutzClass = ' class="' + bodyData.datenschutzClass + '"';
                if (datenschutzUrl === '#scope_datenschutz') {
                    policy_link = '<a href="#scope_datenschutz" class="primary-color scope_open_modal"' +
                        'data-toggle="modal">Datenschutz</a>';
                } else {
                    policy_link = ' <a href="' + datenschutzUrl + '"' + datenschutzClass +
                        ' target="_blank">Zu den Datenschutzhinweisen</a>';
                }
                var closeable = cboc.closeable ? '<i class="fas fa-times close"></i>' : '',
                    cookieTemplate =
                        '<!-- Erweiterter Cookie-Hinweis -->' +
                        '<div class="cookieModal">' +
                        closeable +
                        '<h1>Datenschutz-Präferenz-Center</h1>' +
                        '<p id="metanav">' +
                        'Wir verarbeiten die Daten der Benutzer, um Inhalte oder Anzeigen bereitzustellen und' +
                        ' analysieren die Bereitstellung solcher Inhalte oder Anzeigen, extrahieren Erkenntnisse und' +
                        ' erstellen Berichte, um die Nutzung der Dienste zu verstehen und/oder greifen auf' +
                        ' Informationen auf Geräten zu diesem Zweck zu oder speichern Informationen auf Geräten' +
                        ' zu diesem Zweck. Nachfolgend können Sie mehr über die Zwecke erfahren,' +
                        ' für die wir Daten verarbeiten, Ihre Verarbeitungspräferenzen ausüben und/oder' +
                        ' eine Liste unsere Partner einsehen. ' +
                        policy_link +
                        '</p>' +
                        '<a class="button color acceptAll">Alle akzeptieren</a>' +
                        '<h2>Cookie-Einstellungen anpassen</h2>' +
                        '<div id="cbSettings">' +
                        loadCategoryTemplate() +
                        '</div>' +
                        '<a class="button color safe">Einstellungen speichern</a>' +
                        '</div>' +
                        '<!-- ende erweiterter Cookie-Hinweis -->';
                if (!celement)
                    document.querySelector('body')
                        .insertAdjacentHTML('beforeend', '<div class="cookie backdrop"></div>');
                document.querySelector('.cookie')
                    .insertAdjacentHTML('beforeend', cookieTemplate);
                loadEvents2InfoModal();
            }

            if (datenschutzUrl === '#scope_datenschutz')
                document.querySelector(datenschutzUrl).style.display = 'none';

            if (celement && getComputedStyle(celement).display === 'none')
                fadeIn('.cookie');
            fadeIn('.cookieModal');
        }

        /**
         * load all activated categories and return the template
         * @returns {string}
         */
        function loadCategoryTemplate() {
            var categoryTemplate = '';
            Object.keys(cbo).forEach(function (key) {
                if (cbo[key].active) {
                    var cboCategory = cbo[key],
                        cboGroups = cbo[key].group;
                    if (cboCategory.active) {
                        categoryTemplate +=
                            '<div class="cGroup">' +
                            '<div class="descrption">' +
                            '<div class="h3Container">' +
                            '<h3>' +
                            cboCategory.title +
                            '</h3>' +
                            '<div>' +
                            loadCheckboxOrTxtTemplate(key) +
                            '</div>' +
                            '</div>' +
                            '<p>' +
                            cboCategory.info +
                            '</p>' +
                            '<a class="infoTrigger">Cookie-Information‎</a>' +
                            '<div class="cookieTable">' +
                            loadGroupTemplate(cboGroups) +
                            '</div>' +
                            '</div>' +
                            '</div>';
                    }
                }
            });
            return categoryTemplate;
        }

        /**
         * load all activated groups in the category and return the template
         * @param cboGroups
         * @returns {string}
         */
        function loadGroupTemplate(cboGroups) {
            var groupTemplate = '';
            Object.keys(cboGroups).forEach(function (key) {
                var cboGroup = cboGroups[key];
                if (cboGroup.active) {
                    var cboCookies = cboGroup.cookies;
                    if (cboGroup.groupName) {

                        var checked = cbCookieJson ?
                            cbCookieJson.hasOwnProperty(key) ? ' checked="checked"' : '' : '';

                        groupTemplate +=
                            '<div class="descrption">' +
                            '<div class="h3Container">' +
                            '<h3>' + cboGroup.groupName + '</h3>' +
                            '<div>' +
                            '<label class="switch">' +
                            '<input class="ownSwitch" type="checkbox" name="' + key + '"' + checked + '>' +
                            '<span class="slider"></span>' +
                            '</label>' +
                            '</div>' +
                            '</div>';
                    }
                    groupTemplate +=
                        loadCookieTemplate(cboCookies);
                    if (cboGroup.groupName) {
                        groupTemplate += '</div>';
                    }
                }
            });

            return groupTemplate;
        }

        /**
         * load all activated cookies in the group and return the template
         * @param cboCookies
         * @returns {string}
         */
        function loadCookieTemplate(cboCookies) {
            var cookieTemplate = '';
            Object.keys(cboCookies).forEach(function (key) {
                var cboCookie = cboCookies[key];
                cookieTemplate +=
                    '<table style="border-spacing: 0;">' +
                    '<tbody>' +
                    '<tr>' +
                    '<td>Name:</td>' +
                    '<td>' +
                    key.replace('Google_UA_ID', gtmPropertyId) +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Anbieter:</td>' +
                    '<td>' +
                    cboCookie.company +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Zweck:</td>' +
                    '<td>' +
                    cboCookie.infoText +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Ablauf:</td>' +
                    '<td>' +
                    cboCookie.expires +
                    '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Typ</td>' +
                    '<td>' +
                    cboCookie.type +
                    '</td>' +
                    '</tr>' +
                    '</tbody>' +
                    '</table>'
            });
            return cookieTemplate;
        }

        /**
         * check the category and load a checkbox or text
         * @param key
         * @returns {string}
         */
        function loadCheckboxOrTxtTemplate(key) {
            var checked = cbCookieJson ?
                cbCookieJson.hasOwnProperty(key) ? ' checked="checked"' : '' : '';
            return key === 'essentialCookies' ?
                '<span class="info">immer aktiv</span>' :
                '<label class="switch">' +
                '<input type="checkbox" class="switchGroup" name="' + key + '"' + checked + '>' +
                '<span class="slider"></span>' +
                '</label>';
        }

        // ### specific cookie functions ###

        // ### Google Tag Manager ###
        /**
         * set Google tag manager cookies
         */
        function setGtmCookies() {
            var gtmUrl = 'https://www.googletagmanager.com/gtm.js?id=';
            var gtmContainerId = cbo.statisticsCookies.group.gtm.containerId;
            if (!isScriptLoaded(gtmUrl + gtmContainerId)) {

                if (!cbCookie || (cbCookie && !cbCookieJson.statisticsCookies)) {

                    gtag('consent', 'update', {
                        ad_storage: 'granted',
                        analytics_storage: 'granted'
                    });

                    window.dataLayer.push({
                        'event': 'consent_update'
                    })
                }
            }
        }

        /**
         * load the google tag manager iframe
         */
        function loadGtmIframe() {
            var gtm = cbo.statisticsCookies.group.gtm;
            if (gtm.loadIframe) {
                var noscript = document.createElement('noscript');
                document.querySelector('body').appendChild(noscript);
                var iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.style.visibility = 'hidden';
                iframe.width = '0';
                iframe.height = '0';
                iframe.src = 'https://www.googletagmanager.com/ns.html?id=' + gtm.containerId;
                noscript.appendChild(iframe);
            }
        }

        /**
         * gtag
         *
         * push the permission to google
         */
        function gtag() {
            window.dataLayer.push(arguments);
        }

        // ### end Google Tag Manager ###

        // ### end Cookie specific function ###
    }
};
