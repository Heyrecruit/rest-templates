/**
 * initialization
 */
const initializeDataLayerOnPageLoad = (page, company, language, job) => {
    window.dataLayer = window.dataLayer || [];
    window.currentPage = page;

    if (page === "job" && job) {
        const location = getLocation(job)
        const heyData = {
            HeyPageType: "stellenanzeige",
            HeyClientID: company['id'] ?? "",
            HeyClientName: company['name'] ?? "",
            HeyLanguage: language ?? "",
            HeyJobID: job['id'] ?? "",
            HeyJobTitle: job['job_strings'][0]['title'] ?? "",
            HeyJobDepartment: job['job_strings'][0]['department'] ?? "",
            HeyJobType: job['job_strings'][0]['employment'] ?? "",
            HeyJobHomeoffice: job["remote"] ?? "",

            HeyJobLocationID: location?.id ?? "",
            HeyJobLocationTitle: location?.address ?? "",
        }

        localStorage.setItem("heyData", JSON.stringify(heyData));
        dataLayer.push(heyData);
    }

    if (page === "jobs") {
        dataLayer.push({
            HeyPageType: "karriereseite",
            HeyClientID: company['id'],
            HeyClientName: company['name'],
            HeyLanguage: language,
        });
    }

    // TODO
    if (page === "danke") {
        dataLayer.push({
            HeyPageType: "danke-seite",
            HeyClientID: company['id'],
            HeyClientName: company['name'],
            HeyLanguage: language,
            //  HeyClientStatus: company["Company"]["is_test"] === true ? "Test" : "Kunde",
        });
    }
}

/**
 * Location
 */
const getLocation = (job) => {
    let location = ""
    let address = ""

    location = job["company_location_jobs"][0]['company_location'];
    if (location['title']) {
        address = location['title']
    } else if (location['full_address']) {
        address = location['full_address']
    } else {
        let locStr = [];
        location["street"] && locStr.push(location["street"]);
        location["street_number"] && locStr.push(location["street_number"]);
        location["postal_code"] && locStr.push(location["postal_code"]);
        location["city"] && locStr.push(location["city"]);
        location["country"] && locStr.push(location["country"]);
        address = locStr.join(", ");
    }
    let id = location["id"];

    return {id, address};
}

/**
 * Language
 */
const sendLanguage = (language) => {
    dataLayer.push({
        'event': 'language_switch',
        'HeyLanguage': language,
    });
}

const languageEventListener = () => {
    const languageOptions = document.getElementsByClassName("_language");
    Array.from(languageOptions).forEach((option) => {
        option.addEventListener("click", (event) => {
            let selectedLanguage = event.target.textContent;

            if (!selectedLanguage) {
                try {
                    // for meyer-logistik
                    const anchorElement = event.target.closest("a[data-lang]");
                    selectedLanguage = anchorElement.dataset.lang

                } catch (e) {
                    selectedLanguage = ""
                }
            }

            dataLayer.push({
                event: "language_switch",
                HeyLanguage: selectedLanguage,
            });
        });
    });
};

/**
 * Application / Form
 */
const clickSendApplicationButtonEventListener = () => {
    const saveApplicantButton = document.getElementById("saveApplicant");
    if (saveApplicantButton) {
        saveApplicantButton.addEventListener("click", function (event) {
            dataLayer.push({
                event: "cta_apply_click",
            });
        });
    }
    const saveApplicantWhatsaAppDesktopButton = document.getElementById("whatsapp_apply_btn_event");
    if (saveApplicantWhatsaAppDesktopButton) {
        saveApplicantWhatsaAppDesktopButton.addEventListener("click", function (event) {
            dataLayer.push({
                event: "cta_apply_whatsapp_click",
            });
        });
    }
    const saveApplicantWhatsaAppMobileButton = document.getElementById("whatsapp_apply_btn_mobile");
    if (saveApplicantWhatsaAppMobileButton) {
        saveApplicantWhatsaAppMobileButton.addEventListener("click", function (event) {
            dataLayer.push({
                event: "cta_apply_whatsapp_click",
            });
        });
    }
};
const applicationFailed = () => {
    dataLayer.push({
        event: "cta_apply_fail",
    });
}
const nameFormInteractionEventListener = () => {
    const firstname = document.querySelector('input[name="first_name"]');
    let isFirstLetterEntered = false;

    if (firstname) {
        firstname.addEventListener("input", function (event) {
            if (!isFirstLetterEntered && event.target.value.length >= 1) {
                dataLayer.push({
                    event: "form_interaction_name",
                });
                isFirstLetterEntered = true;
            }
        });
    }
};
const emailFormInteractionEventListener = () => {
    const email = document.querySelector('input[name="first_name"]');
    let firstLetterEntered = false;
    if (email) {
        email.addEventListener("input", function (event) {
            if (!firstLetterEntered && event.target.value.length >= 1) {
                dataLayer.push({
                    event: "form_interaction_email",
                });
                firstLetterEntered = true;
            }
        });
    }
};
const applicationSentEventListener = () => {
    dataLayer.push({
        event: "application_sent",
    });
};

/**
 * Filter
 */
const jobTypeFilterEventListener = (jobType) => {
    HeyJobType = jobType;

    dataLayer.push({
        event: "job_type_filter_select",
    });
};

const departmentFilterEventListener = (department) => {
    HeyJobDepartment = department;

    dataLayer.push({
        event: "department_filter_select",
    });
};

const locationFilterEventListener = (locationID, locationTitle = "") => {
    HeyJobLocationID = locationID;
    HeyJobLocationTitle = locationTitle;

    dataLayer.push({
        event: "location_filter_select",
    });
};

const locationInputFilterEventListener = (location) => {
    dataLayer.push({
        event: "location_filter_search",
        HeySearchJobLocation: location,
    });
};


/**
 * Job/s
 */
const jobClickEventListener = (job) => {
    const location = getLocation(job)

    HeyJobID = job['id'] ?? "";
    HeyJobTitle = job['job_strings'][0]['title'] ?? "";
    HeyJobLocationID = location?.id ?? "";
    HeyJobLocationTitle = location?.address ?? "";
    HeyJobDepartment = job['job_strings'][0]['department'] ?? "";
    HeyJobType = job['job_strings'][0]['employment'] ?? "";

    dataLayer.push({
        'event': currentPage === "job" ? 'related_job_click' : 'job_click',
    });
}

const viewAllJobsEventListener = () => {
    const viewAllJobsButton = document.getElementById("all-vacancies-button");
    if (viewAllJobsButton) {
        viewAllJobsButton.addEventListener("click", function (event) {
            dataLayer.push({
                event: "view_all_jobs_click",
            });
        });
    }
};

const shareJobEventListener = () => {
    const shareLinks = document.querySelectorAll(
        "#social-bar a, #mobile-social-bar a, #job-share-links a"
    );

    shareLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            try {
                const url = new URL(link.href);
                let websiteName = url.hostname;

                if (url.protocol === "mailto:") {
                    websiteName = "Email";
                }
                if (url.protocol === "whatsapp:") {
                    websiteName = "Whatsapp";
                }
                if (url.protocol === "http:" || url.protocol === "https:") {
                    websiteName = websiteName.replace(/^www\./i, "");
                    websiteName = websiteName.replace(/^https?:\/\//i, "");
                    const dotIndex = websiteName.indexOf(".");
                    if (dotIndex !== -1) {
                        websiteName = websiteName.substring(0, dotIndex);
                    }
                }
                dataLayer.push({
                    event: "job_share",
                    HeyChannel: websiteName,
                });
            } catch (e) {
                console.log("An error occurred: ", e.message);
            }
        });
    });
};


/**
 * Misc
 */

//  social links
const externalLinkEventListener = () => {
    const socialLinks = document.querySelectorAll(
        "#scope-job-about-section-social a, #social a, #social-links a," +
        "._social-links a"
    );

    socialLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            const url = new URL(link.href);
            let websiteName = url.hostname;
            let content = "";

            if (link.textContent && link.textContent.trim().length > 0) {
                content = link.textContent;
            } else {
                if (url.protocol === "http:" || url.protocol === "https:") {
                    websiteName = websiteName.replace(/^www\./i, "");
                    websiteName = websiteName.replace(/^https?:\/\//i, "");
                    const dotIndex = websiteName.indexOf(".");
                    if (dotIndex !== -1) {
                        content = websiteName.substring(0, dotIndex);
                    }
                }
            }
            if (content) {

                dataLayer.push({
                    event: "external-link_click",
                    HeyDestination: content,
                });
            }
        });
    });
};

const galleryInteraction = () => {
    let sliders = document.querySelectorAll('.slider-control');

    sliders.forEach(function (slider) {
        slider.addEventListener('click', function () {
            dataLayer.push({
                event: "gallery_interaction",
            });
        });
    });
}

const interactPaginationEventListener = () => {
    dataLayer.push({
        event: "pagination_interaction",
    });
};