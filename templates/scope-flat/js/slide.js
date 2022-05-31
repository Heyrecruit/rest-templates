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
               '<a class="slider-control no-opacity-hover left">' +
               '<i class="fal fa-angle-left primary-color-hover white-color"></i>' +
               '</a>' +
               '<a class="slider-control no-opacity-hover right">' +
               '<i class="fal fa-angle-right primary-color-hover white-color"></i>' +
               '</a>' +
               '<div class="slider">' +
               slideImgHtml +
               '</div>' +
               '<ul class="slider-dots">' +
               slideDotsHtml +
               '</ul>'
            );
            slideWrap.find('.slider').width(slideElementWidth * slideElements).height(slideElementWidth*.66);
            slideWrap.height(slideElementWidth*.66);

            //slideWrap.find('.slider').find('img').width(slideElementWidth);

            //slide on control click
            let slideControlClickHandler = function () {
                // check if there is an ongoing animation
                if (slideWrap.find('.slider').is(':animated')) {
                    return false
                }

                //get dot index
                let currentActiveDotIndex = slideWrap.find('.slider-dots .active').index()

                //check which control is clicked
                if ($(this).hasClass('right')) {
                    if (!slideWrap.find('.slider-dots .dot').last().hasClass('active')) {
                        // if any image but last is active
                        slideWrap.find('.slider').animate({'left': '-=100%'}, 300)
                        slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex + 1).addClass('active primary-bg')
                    } else {
                        // if last image is the active image
                        slideWrap.find('.slider').animate({'left': '0'}, 300)
                        slideWrap.find('.slider-dots .dot').eq(0).addClass('active primary-bg')
                    }
                } else {
                    if (!slideWrap.find('.slider-dots .dot').first().hasClass('active')) {
                        // if any image but first is active
                        slideWrap.find('.slider').animate({'left': '+=100%'}, 300)
                        slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex - 1).addClass('active primary-bg')
                    } else {
                        // if first image is active
                        slideWrap.find('.slider').animate({'left': '-=' + (slideElements - 1) + '00%'}, 300)
                        slideWrap.find('.slider-dots .dot').eq(slideElements - 1).addClass('active primary-bg')
                    }
                }

                // remove active class from previous active dot
                slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active primary-bg')
            }
            //slide on dot click
            let slideControlDotsClickHandler = function () {
                var nextActiveDotIndex = $(this).index();
                var currentActiveDotIndex = slideWrap.find('.slider-dots .active').index();
                slideWrap.find('.slider').animate({'left': '-' + nextActiveDotIndex + '00%'}, 300);
                slideWrap.find('.slider-dots .dot').eq(nextActiveDotIndex).addClass('active primary-bg');
                slideWrap.find('.slider-dots .dot').eq(currentActiveDotIndex).removeClass('active primary-bg');
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
        } else {
            // Get on screen image
            let screenImage = slideWrap.find('img')
            slideWrap.height(slideElementWidth*.66);
            // Create new offscreen image to test
            let theImage = new Image()
            theImage.src = screenImage.attr('src')

            // Get accurate measurements from that.
            let imageWidth = theImage.width
            let imageHeight = theImage.height

            if (imageWidth < imageHeight) {
                slideWrap.addClass('vertical-img')
            }
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
            slideWrap.find('img').width(slideWidth);
            //let slideElementHeight = slideWrap.find('img').first().height();
            let slideElements = slideWrap.find('img').length;
            let slideElementWidth = slideWidth;
            slideWrap.find('.slider').width(slideElementWidth * slideElements).height(slideElementWidth*.66);
            slideWrap.height(slideElementWidth*.66);
        });
    }, 150)

}
$(document).ready(function () {
    slides();
});
$(window).resize(function () {
    slidesUpdate();
});
