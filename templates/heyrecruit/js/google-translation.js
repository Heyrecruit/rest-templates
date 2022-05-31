// Enter an API key from the Google API Console:
//   https://console.developers.google.com/apis/credentials
var apiKey = "";

// Set endpoints
var endpoints = {
    translate: "",
    detect: "detect",
    languages: "languages"
};

// Abstract API request function
function makeApiRequest(endpoint, data, type, authNeeded, callback) {
    url = "https://www.googleapis.com/language/translate/v2/" + endpoint;
    url += "?key=" + apiKey;

    // If not listing languages, send text to translate
    if (endpoint !== endpoints.languages) {
        url += "&q=" + encodeURI(data.textToTranslate);
    }

    // If translating, send target and source languages
    if (endpoint === endpoints.translate) {
        url += "&target=" + data.targetLang;
        url += "&source=" + data.sourceLang;
    }

    // Return response from API
    return $.ajax({
        url: url,
        type: type || "GET",
        data: data ? JSON.stringify(data) : "",
        dataType: "json",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json"
        },
        error: function (a,b,c) {
            console.log(a);
            console.log(b);
            console.log(c);
        },
        success(response){

            var translatedText = response.data.translations[0].translatedText.split(',');
            callback(translatedText);
        }
    });
}

// Translate
function translate(data, callback) {
    makeApiRequest(endpoints.translate, data, "GET", false, callback);
}

function makeAutomatedTranslation(){
    var translationObj = {};
    var targetLang = templateHandler.findGetParameter('language');
    var introHeadline = $('#scope-jobs-table-intro-section h2').length ? $('#scope-jobs-table-intro-section h2').text() : '';
    var introSlogan = $('#scope-jobs-table-intro-section p').length ? $('#scope-jobs-table-intro-section p').text() : '';

    var translateTextArray = [introHeadline, introSlogan, 'Standort', 'Fachabteilung', 'Einstellungsart', 'offene Stellen', 'Alle', 'PLZ/Ort'];
    var elementsToSearchFor = ['h1', 'h2', 'h3', 'p', 'span', 'label', 'option', 'th', 'placeholder'];

    if (targetLang != null && targetLang !== 'de') {

        translationObj = {
            sourceLang: 'de',
            targetLang: targetLang,
            textToTranslate: translateTextArray
        };


        if (translationObj.targetLang !== null) {
            translate(translationObj, function (response) {
                $.each(response, function (key, value) {
                    $.each(elementsToSearchFor, function (a, b) {
                        if (b !== 'placeholder') {
                            if ($(b + ':contains("' + translateTextArray[key] + '")').length >= 1) {
                                $(b + ':contains("' + translateTextArray[key] + '")').text(value);
                            }
                        } else {
                            if ($('*[placeholder="' + translateTextArray[key] + '"]').length >= 1) {
                                $('*[placeholder="' + translateTextArray[key] + '"]').attr('placeholder', value);
                            }
                        }
                    });
                });
            });
        }
    }
}
