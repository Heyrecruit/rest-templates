$(document).ready(function () {
    $('#lang button').click(function () {
       if ($(this).parent().hasClass('active')){
           $(this).parent().removeClass('active');
           $(this).removeClass('primary-color');
       }
       else{
           $(this).parent().addClass('active');
           $(this).addClass('primary-color');
       }
    });
    $('section').click(function () {
        $('#lang').removeClass('active');
        $('#lang i').removeClass('primary-color');
    });
    $('#mobile-social-bar-trigger').click(function () {
        if ($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
        } else {
            $(this).parent().addClass('active');
        }
    });
    $('#mobile-nav-trigger').click(function () {
        if ($(this).siblings('#nav').hasClass('active')) {
            $(this).siblings('#nav').removeClass('active');
            $(this).siblings('#nav').height(0);
        } else {
            $(this).siblings('#nav').addClass('active');
            let countNav = $(this).siblings('#nav').find('li').length;
            $(this).siblings('#nav').height(countNav * 42);
        }
    });

    $('.datepicker').datepicker({
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        changeMonth: true,
        changeYear: true,
        yearRange: "-70:+20",
        dayNamesMin: ['So', 'Mo','Di','Mi','Do','Fr','Sa'],
        monthNames: ['Januar','Februar','März','April','Mai','Juni',
            'Juli','August','September','Oktober','November','December']
    });

    // Locationselect
    $('.locationTrigger').click(function(){
        $('#locationWrapper').toggleClass('active');
        $('#locationList').slideToggle('fast');
    });
});

$(document).off('click', 'a[href^=\\#]:not(.scope_open_modal)').on('click', 'a[href^=\\#]:not(.scope_open_modal)', function (e) {
    e.preventDefault();
    var href = $(this).attr('href');

    if (typeof href !== 'undefined') {
        if ($(href).length){
            $('html, body').animate({
                scrollTop: $(href).offset().top - 0
            }, 600);
        }else{
            $('html, body').animate({
                scrollTop: $('.scope-jobs-list-section').offset().top - 0
            }, 600);
        }
    }
});
