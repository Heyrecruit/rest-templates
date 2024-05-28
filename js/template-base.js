function TemplateHandler(addEventHandler) {

    this.scopeOuterContainerTag = 'div[data-scope-outer-container="true"]';

    this.init = function (addEventHandler) {
        if (addEventHandler) {
            this.setEventHandler();
        }
        this.sendIframeHeight();

        if (this.inIframe()) {
            $('body').addClass('scope-inside-iframe');
        }
    };

    this.setEventHandler = function () {
        var _this = this;

        $(window).on("load", function (e) {
            _this.sendIframeHeight();
        });

        $(document).on('click', '#faq .questionWrapper', function () {
            $(this).find('.answer').slideToggle();
        });

        $(document).on('click', '.mobile_nav_trigger', function () {
            $(this).toggleClass('open');
            $(this).parents('.mobile_nav').siblings('ul:not(.cta_nav)').slideToggle();
        });

        $(document).on('change', '#scope-location-select', function () {
            window.location.href = _this.updateQueryStringParameter(window.location.href, 'location', $(this).val());
        });

        $(document).on('click', '.hey_pagination button', function (e) {
            e.preventDefault();

            if (!$(this).hasClass('active')) {
                $('.btn-outline-info').removeClass('active');
                $(this).addClass('active');
                _this.filter()
            }
        });


        // Animated scrolling -> Click of every a with an beginning hash tag and not .scope_open_modal class.
        $(document).on('click', 'a[href^=\\#]:not(.scope_open_modal)', function (e) {
            e.preventDefault();

            var href = $(this).attr('href');

            if (href !== '#' && typeof href !== 'undefined' && $(href).length) {

                $('html, body').animate({
                    scrollTop: $(href).offset().top - 100
                }, 600);

            }
        });

        // On click of job detail url inside iframe
        $(document).on('click', 'a[href*="location="]', function (e) {

            if (window.name === 'scopeFrame' && $(this).attr('target') !== '_parent' && $(this).attr('target') !== '_blank') {
                e.preventDefault();
                _this.sendJobDetailParams($(this));
            }
        });

        // Switch language
        $(document).on('click', '#lang a', function (e) {
            e.preventDefault();
            let language = $(this).attr('data-language');
            sendLanguage(language)  // dataLayerPusher
            let url = _this.updateURLParameter(window.location.href, 'language', language);
            window.location.href = url;
        });

        // Open modal
        $(document).on('click', '.scope_open_modal', function (e) {
            e.preventDefault();

            var modal = $($.attr(this, 'href'));
            if (modal.length) {
                modal.fadeIn();
            }
        });

        // Close modal
        $(document).on('click', '.modal .close', function () {
            $(this).closest('.modal').fadeOut();
        });
        $(document).on('click', '.modal', function (e) {
            if (e.target !== this)
                return;

            $(this).fadeOut();
        });

        // Filter jobs table -> branche
        $(document).on('change', '#branche', function () {
            if ($(this).val() !== 'Branche wählen') {
                window.location.href =
                    location.protocol + '//' + location.host + location.pathname + '?page=job&id=' + $(this).val() + '&location=' + $("#branche option:selected").attr('data-location-id');
            }
        });

        // Filter jobs table -> einstellungsart
        $(document).off('change', '#einstellungsart').on('change', '#einstellungsart', function (event) {
            _this.filter();
            const selectedOption = event.target.options[event.target.selectedIndex];
            const content = selectedOption.textContent.trim();
            // TODO should it be event.target.value (id), instead?
            jobTypeFilterEventListener(content)  // dataLayerPusher
        });

        // Filter jobs table -> fachabteilung
        $(document).off('change', '#fachabteilung').on('change', '#fachabteilung', function (event) {
            _this.filter();
            departmentFilterEventListener(event.target.value)  // dataLayerPusher
        });

        // Filter jobs table -> standort
        $(document).off('change', '#location-list').on('change', '#location-list', function (event) {
            _this.filter();
            locationFilterEventListener(event.target.value)  // dataLayerPusher
        });

        // Filter jobs table -> standort
        var typingTimer;
        $(document).on('keyup', '#standort', function (event) {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function doneTyping() {
                _this.filter();
                locationInputFilterEventListener(event.target.value) // dataLayerPusher
            }, 1500);
        });

        // Location change

        $(document).on('click', '.locationTriggerLi', function (e) {
            e.preventDefault();
            window.location.href = _this.updateURLParameter(window.location.href, 'location', $(this).attr('data-location-id'));
        });
    };

    this.sendIframeHeight = function () {
        var height = $(this.scopeOuterContainerTag).innerHeight();
        var postMessageHeight = {
            iframe_height: height + 95
        };

        //console.log(postMessageHeight);

        if (typeof window.parent.postMessage != 'undefined') {

            window.parent.postMessage(postMessageHeight, "*");

            $(this.scopeOuterContainerTag).bind('iframeHeightChange', function () {

                var height = $(this.scopeOuterContainerTag).outerHeight(true);

                postMessageHeight['iframe_height'] = height; // Footer height

                window.parent.postMessage(postMessageHeight, "*");
            });
        }
    };

    this.updateQueryStringParameter = function(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }

    this.sendJobDetailParams = function ($element) {

        var url = $($element).attr('href');

        if (typeof url !== 'undefined' && url.charAt(0) !== '#') {

            var jobId = this.getParameterByName('id', url);
            var companyLocationId = this.getParameterByName('location', url);
            var name = $($element).text();

            jobId = jobId != null ? jobId : this.getParameterByName('job', url);
            companyLocationId = companyLocationId != null ? companyLocationId : this.getParameterByName('companyLocationId', url);

            var messageData = {
                scope_job_details: {
                    job_id: jobId,
                    company_location_id: companyLocationId,
                    job_title: name,
                }
            };

            if (typeof window.parent.postMessage != 'undefined') {
                window.parent.postMessage(messageData, "*");
            }

            var w = window.location;
            var url = w.protocol + "//" + w.host;

            location.href = url + '?page=job&id=' + jobId + '&location=' + companyLocationId;
        }
    };

    this.setMetaDescriptionAndTitle = function (description, title) {
        var meta = document.getElementsByTagName("meta");
        for (var i = 0; i < meta.length; i++) {
            if (meta[i].name.toLowerCase() == "description") {
                meta[i].content = description;
            }
        }

        document.title = title;
    };

    this.ajaxCall = function (url, data, async, success, error, header) {
        var url = url.indexOf('http') !== -1 ? url : this.getBaseUrl() + url;

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            async: async,
            dataType: 'json',
            beforeSend: function (xhr) {
                var defaultHeader = {'Content-type': 'application/x-www-form-urlencoded'};

                if (typeof header !== 'undefined' && Object.entries(header).length !== 0) {
                    defaultHeader = header;
                }
                $.each(defaultHeader, function (key, value) {
                    xhr.setRequestHeader(key, value);
                });
            },
            success: function (response) {
                if (typeof success !== 'undefined') {
                    success(response);
                }
            },
            error: function (response) {

                if (typeof response.responseText !== 'undefined') {
                    try {
                        var responseText = JSON.parse(response.responseText);
                        if (typeof error !== 'undefined') {
                            error(responseText);
                        }
                    } catch (e) {
                       //console.log("JSON parsing error:", e);
                        if (typeof error !== 'undefined') {
                            error(response);
                        }
                    }
                }
            }
        });
    };

    this.filter = function (location, employment, department, areaSearchDistance) {
        let _this = this;
        let url = this.getBaseUrl();
        let searchParams = '';
        let locationType = 'search';
        let page = $('.btn-outline-info').length ?  parseInt($('.btn-outline-info.active').attr('data-rel')) : 1;

        let locationQuery = '';
        if (typeof $('#standort').val() !== 'undefined') {
            locationQuery = $('#standort').val();
        }

        if (typeof location !== 'undefined' && location !== null) {
            if ($('#standort').length) {
                $('#standort').val(location)
            }
            locationQuery = location;
        }

        if (typeof $('#location-list').val() !== 'undefined') {
            locationQuery = $('#location-list').val();
            locationType = 'list';
        }

        if (typeof location !== 'undefined' && location !== null) {
            if ($('#location-list').length) {
                $('#location-list').val(location)
            }
            locationType = 'list';
            locationQuery = location;
        }

        if (locationType === 'list') {
            searchParams += '?company_location_ids=' + encodeURIComponent(locationQuery) + '&locationType=' + locationType;
        } else {
            searchParams += '?address=' + encodeURIComponent(locationQuery) + '&locationType=' + locationType;
        }

        if (typeof areaSearchDistance !== 'undefined') {
            searchParams += '&area_search_distance=' + encodeURIComponent(areaSearchDistance);
        }

        if (typeof $('#einstellungsart option:selected').val() !== 'undefined' && $('#einstellungsart option:selected').val() !== 'all') {
            if (typeof employment !== 'undefined' && employment !== null) {
                $('#einstellungsart').val(employment)
            }
            searchParams += searchParams.indexOf('?') !== -1 ? '&' : '?';
            searchParams += 'employments=' + encodeURIComponent($('#einstellungsart option:selected').val());
        }
        if (typeof $('#einstellungsart option:selected').val() !== 'undefined' && $('#einstellungsart option:selected').val() === 'allTraining') {
            searchParams += '&employments=6&employments=7';
        }
        if (typeof $('#fachabteilung option:selected').val() !== 'undefined' && $('#fachabteilung option:selected').val() !== 'all') {
            if (typeof department !== 'undefined' && department !== null) {
                $('#fachabteilung').val(department)
            }
            searchParams += searchParams.indexOf('?') !== -1 ? '&' : '?';
            searchParams += 'departments=' + encodeURIComponent($('#fachabteilung option:selected').val());
        }

        var $jobsContainer = $('*[data-jobs-container="true"]').length ? $('*[data-jobs-container="true"]') : $('#scope_jobs_table');

        if (_this.findGetParameter('language') !== null) {
            searchParams += searchParams.indexOf('?') !== -1 ? '&' : '?';
            searchParams += 'language=' + _this.findGetParameter('language');
        }

        url += $jobsContainer.find('.table-location-wrapped').length ? 'elements/jobs_table_locations_wrapped.php' : 'elements/jobs_table.php';

        $jobsContainer.load(url + searchParams + '&page='+page, function () {
            if (typeof makeAutomatedTranslation == "function") {
                makeAutomatedTranslation();
            }
            _this.sendIframeHeight();

            if (typeof setPagination !== 'undefined') {
                setPagination();
            }
        });
    };

    this.inIframe = function () {
        try {
            return window.self !== window.top;
        } catch (e) {
            return true;
        }
    };

    this.getBaseUrl = function () {
        var baseURL = '';
        var basePath = '';

        if (typeof $('body').attr('data-base-path') != 'undefined') {
            basePath = $('body').attr('data-base-path').replace(/\W+/, "");
        }

        try {

            var w = window.location;
            var url = w.protocol + "//" + w.host + "/";
            baseURL = url.match(/^(([a-z]+:)?(\/\/)?[^\/]+\/).*$/)[1];
            baseURL += basePath + '/';

        } catch (e) {
        }
        return baseURL;
    };

    this.arrayCompare = function (a1, a2) {
        if (a1.length != a2.length) return false;
        var length = a2.length;
        for (var i = 0; i < length; i++) {
            if (a1[i] !== a2[i]) return false;
        }
        return true;
    };

    this.inArray = function (needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (typeof haystack[i] == 'object') {
                if (arrayCompare(haystack[i], needle)) return true;
            } else {
                if (haystack[i] == needle) return true;
            }
        }
        return false;
    };

    this.empty = function (mixedVar) {

        var undef
        var key
        var i
        var len
        var emptyValues = [undef, null, false, 0, '', '0']

        for (i = 0, len = emptyValues.length; i < len; i++) {
            if (mixedVar === emptyValues[i]) {
                return true
            }
        }

        if (typeof mixedVar === 'object') {
            for (key in mixedVar) {
                if (mixedVar.hasOwnProperty(key)) {
                    return false
                }
            }
            return true
        }

        return false
    };

    this.setCookie = function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    };

    this.getCookie = function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    };

    this.getCookiesArray = function () {

        var cookies = {};

        if (document.cookie && document.cookie != '') {
            var split = document.cookie.split(';');
            for (var i = 0; i < split.length; i++) {
                var name_value = split[i].split("=");
                name_value[0] = name_value[0].replace(/^ /, '');
                cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1].replace(/%(?![0-9][0-9a-fA-F]+)/g, '%25'));
            }
        }

        return cookies;
    };

    this.updateURLParameter = function (url, param, paramVal) {
        var newAdditionalURL = "";
        var tempArray = url.split("?");

        var baseURL = tempArray[0];
        var additionalURL = tempArray[1];
        var temp = "";
        if (additionalURL) {
            tempArray = additionalURL.split("&");
            for (var i = 0; i < tempArray.length; i++) {
                if (tempArray[i].split('=')[0] != param) {
                    newAdditionalURL += temp + tempArray[i];
                    temp = "&";
                }
            }
        }

        var rows_txt = temp + "" + param + "=" + paramVal;
        return baseURL + "?" + newAdditionalURL + rows_txt;
    };

    this.getParameterByName = function (name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    };

    this.findGetParameter = function (parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    };

    this.secondIndexOf = function (Val, Str) {
        var Fst = Str.indexOf(Val);
        var Snd = Str.indexOf(Val, Fst + 1);
        return Snd;
    };

    this.getGaSessionId = function () {
        var sessionId = false;
        var cookieName = $('body').attr('data-ga4-measurement-id');

        if (cookieName && cookieName.length > 0) {
            // Entferne die ersten beiden Zeichen
            cookieName = cookieName.slice(2);

            var cookie = "_ga_" + cookieName;
            var pattern = new RegExp(cookie + "=GS1\\.1\\.(\\d+)\\.\\d+\\.\\d+\\.\\d+\\.\\d+\\.\\d+\\.\\d+");
            var match = document.cookie.match(pattern);
            sessionId = match && match[1];

        }

        if (!sessionId) {
            console.log("Session ID not found");
            return;
        }

        return sessionId;
    };

    this.init(addEventHandler);
}

if (typeof templateHandler == 'undefined') {
    var templateHandler = new TemplateHandler(true);

} else {
    templateHandler = new TemplateHandler(false);
}


// job click
window.HeyJobID = "";
window.HeyJobTitle = "";
window.HeyJobLocationID = "";
window.HeyJobLocationTitle = "";
window.HeyJobIndustry = "";
window.HeyJobCareerLevel = "";
window.HeyJobFunction = "";
window.HeyJobDepartment = "";
window.HeyJobType = "";
window.HeyJobHomeoffice = "";

// dataLayerPusher
window.onload = () => {
    languageEventListener();
    externalLinkEventListener();
    clickSendApplicationButtonEventListener();
    viewAllJobsEventListener();
    nameFormInteractionEventListener();
    emailFormInteractionEventListener();
    shareJobEventListener();
    galleryInteraction();

    if(typeof cookieBanner !== 'undefined') {
        cookieBanner.init();
    }
};

