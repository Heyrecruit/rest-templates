$(document).ready(function () {
    setPagination();
});

function setPagination() {
    var rowsShown = 10;
    var rowsTotal = $('.cp-job-list .row').length;

    if (rowsTotal > rowsShown){
        $('.btn-outline-info').show();
        if ($('#pagination').length) {
            $('#pagination').html('');
        } else {
            $('.cp-job-list').after('<div id="pagination" class="text-center"></div>');
        }


        var numPages = rowsTotal / rowsShown;
        for (i = 0; i < numPages; i++) {
            var pageNum = i + 1;
            /*$('#pagination').append('<a href="#" class="btn-outline-info" rel="' + i + '">&emsp;' + pageNum + '&emsp;</a> ');*/
            $('#pagination').append('<button class="btn-outline-info" rel="' + i + '">' + pageNum + '</button>');
        }
        $('.cp-job-list .row').hide();
        $('.cp-job-list .row').slice(0, rowsShown).show();
        $('#pagination button:first').addClass('active');
        $('#pagination button').bind('click', function (e) {
            e.preventDefault();
            $('#pagination button').removeClass('active');
            $(this).addClass('active');
            var currPage = $(this).attr('rel');
            var startItem = currPage * rowsShown;
            var endItem = startItem + rowsShown;
            $('.cp-job-list .row').css('opacity', '0').hide().slice(startItem, endItem).css('display', 'flex').animate({
                opacity: 1
            }, 300);
        });
    }else{
        $('.btn-outline-info:not(.active)').hide();
        $('.btn-outline-info.active').text('1');
    }
}
