function slides() {
    //define slides wrap
    const slides = $('.scope-img-wrap');
    //handel more than one slide element
    $(slides).each(function () {
        const slideWrap = $(this);
        let slideWidth = slideWrap.width();
        slideWrap.find('img').width(slideWidth);

        let slideElementHeight = slideWrap.find('img').first().height();
        let slideElements = slideWrap.find('img').length;
        let slideElementWidth = slideWidth;
        let slideImgHtml = slideWrap.html();
        let slideDotsHtml = '';
        for (var i = 0; i < slideElements; i++) {
            let activteClass = i == 0 ? 'active primary-bg' : '';
            slideDotsHtml += '<li class="dot primary-bg-hover ' + activteClass + '"></li>'
        }
        //check if more than one img
        if (slideElements > 1) {
            //build html
            slideWrap.html(
                '<a class="slider-control left">' +
                '<i class="far fa-angle-left primary-color white-color-hover"></i>' +
                '</a>' +
                '<a class="slider-control right">' +
                '<i class="far fa-angle-right primary-color white-color-hover"></i>' +
                '</a>' +
                '<div class="slider">' +
                slideImgHtml +
                '</div>' +
                '<ul class="slider-dots">' +
                    slideDotsHtml +
                '</ul>'
            );
            slideWrap.find('.slider').width(slideElementWidth * slideElements).height(slideElementHeight);
            slideWrap.height(slideElementHeight);
            //slideWrap.find('.slider').find('img').width(slideElementWidth);

            //slide on control click
            let slideControlClickHandler = function () {
                //get dot index
                var currentActiveDotIndex = slideWrap.find('.slider-dots .active').index();
                //check which control is clicked
                if ($(this).hasClass('right')) {
                    let slideLeftPosition = slideWrap.find('.slider').css('left');
                    if (slideLeftPosition == '0px') {
                        slideWrap.find('.slider').animate({'left': "-=100%"}, 300);
                        slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex + 1).addClass('active');
                        slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active');
                    } else {
                        if (slideLeftPosition.substring(1, slideLeftPosition.length - 2) < slideElementWidth * (slideElements - 1)) {
                            slideWrap.find('.slider').animate({'left': "-=100%"}, 300);
                            slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex + 1).addClass('active');
                            slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active');
                        } else {
                            slideWrap.find('.slider').animate({'left': '0'}, 300);
                            slideWrap.find('.slider-dots .dot').eq(0).addClass('active');
                            slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active');
                        }
                    }
                } else {
                    let slideLeftPosition = slideWrap.find('.slider').css('left');
                    slideLeftPosition = parseInt(slideLeftPosition);
                    slideLeftPosition = Math.round(slideLeftPosition);

                    if (slideLeftPosition == '0') {
                        slideWrap.find('.slider').animate({'left': '-=' + (slideElements - 1) + '00%'}, 300);

                        slideWrap.find('.slider-dots .dot').eq(slideElements - 1).addClass('active');
                        slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active');
                    } else {
                        slideWrap.find('.slider').animate({'left': "+=100%"}, 300);
                        slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex - 1).addClass('active');
                        slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active');
                    }
                }
            };
            //slide on dot click
            let slideControlDotsClickHandler = function () {
                var nextActiveDotIndex = $(this).index();
                var currentActiveDotIndex = slideWrap.find('.slider-dots .active').index();
                slideWrap.find('.slider').animate({'left': '-' + nextActiveDotIndex + '00%'}, 300);
                slideWrap.find('.slider-dots .dot').eq(nextActiveDotIndex).addClass('active');
                slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active');
            };
            //click trigger
            slideWrap.find('.slider-control').click(slideControlClickHandler);
            slideWrap.find('.slider-dots .dot').click(slideControlDotsClickHandler);
            //swipe trigger
            slideWrap.swipe({
                allowPageScroll: "vertical",
                swipe: function (event, direction) {
                    let siteWidth = $(window).width();
                    //check site width
                    if (siteWidth <= '767'){
                        if (direction == "left") {
                            slideWrap.find('.slider-control.right').click();
                        } else {
                            slideWrap.find('.slider-control.left').click();
                        }
                    }
                }
            });
        }
        //show img after magic
        slides.find('img').addClass('show');
    });
}

function slidesUpdate() {
    //define slides wrap
    const slides = $('.scope-img-wrap');
    //handel more than one slide element
    setTimeout(function () {
        $(slides).each(function () {
            const slideWrap = $(this);
            let slideWidth = slideWrap.width();
            console.log(slideWidth);
            slideWrap.find('img').width(slideWidth);
            let slideElementHeight = slideWrap.find('img').first().height();
            let slideElements = slideWrap.find('img').length;
            let slideElementWidth = slideWidth;
            slideWrap.find('.slider').width(slideElementWidth * slideElements).height(slideElementHeight);
            slideWrap.height(slideElementHeight);
        });
    }, 150)

}
$(document).ready(function () {
   slides();
});
$(window).resize(function () {
    slidesUpdate();
});
