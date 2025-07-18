$(document).ready(function () {
    if (/android|iphone|ipod|ipad|windows phone/i.test(navigator.userAgent)
        && !/mobile|touch|android/i.test(navigator.userAgent)) {
        $('#whatsapp_toggle_button').remove();
        $('#whatsapp_apply_btn_mobile').removeClass('d-none');
    } else {
        $('#whatsapp_apply_btn_mobile').remove();
        whatsAppToggle();
    }
});

function whatsAppToggle() {

    $(document).off("click", "#whatsapp_toggle_button").on("click", "#whatsapp_toggle_button", function () {

        $(this).toggleClass( 'whatsapp_apply_btn back-to-form-btn');

        if ($(this).hasClass('whatsapp_apply_btn')) {
            $('#whatsapp_toggle_button .bt-show').addClass( 'd-none');
            $('#whatsapp_toggle_button .wa-show').removeClass( 'd-none');
        } else {
            $('#whatsapp_toggle_button .bt-show').removeClass( 'd-none');
            $('#whatsapp_toggle_button .wa-show').addClass( 'd-none');
        }

        $('.form-main').fadeToggle();
        $('.wa-divide').toggleClass( 'd-none');
        $('.wa-link-container').fadeToggle().toggleClass( 'd-none d-block');
    });


}