
(function ($) {
    
    var outer;
    
    $('.post_preview').click(function () {
        outer = $(this).next().find('.img-outer');
        $.ajax({
            url: "/index/img",
            success: function (data) {
                data = $.parseJSON(data);
                outer.html('');

                for (i = 0; i < data.length; i++) {
                    outer.append('<div class="img-name">' + data[i] + '</div>');
                }

                outer.slideDown(300);
            }
        });
        
        outer.on('click', '.img-name', function () {
            $('.post_preview').val($(this).text());
            outer.slideUp(300);
        });
        
    });

})(jQuery);




