$(document).ready(function () {
    var open = false;
    $('#cn-button').click(function () {
        if (!open) {
            $(this).addClass('open');
            setTimeout(
                function () {
                    $('#cn-wrapper').addClass("opened-nav");
                }, 600);
        } else {
            $('#cn-wrapper').removeClass('opened-nav');
            setTimeout(
                function () {
            $('#cn-button').removeClass('open');
                }, 200);
        }
        open = !open;

    })
})
