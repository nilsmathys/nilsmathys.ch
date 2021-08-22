$(function() {
    // toggleDarkmode(parseInt(localStorage.getItem('darkmode')));
    //
    // $('#darkmode-toggle').click(function () {
    //     toggleDarkmode(($('#darkmode').attr('href') !== 'css/darkmode.css'));
    //     return false;
    // });
    //
    // function toggleDarkmode(setDark) {
    //     if (setDark) {
    //         localStorage.setItem('darkmode', '1');
    //         $('#darkmode').attr('href', 'css/darkmode.css');
    //         grecaptcha.render("recaptcha", {
    //             "theme": "dark"
    //         })
    //     } else {
    //         localStorage.setItem('darkmode', '0');
    //         $('#darkmode').attr('href', '');
    //         grecaptcha.render("recaptcha", {
    //             "theme": "light"
    //         })
    //     }
    // }
    let postop = $("#con").position().top;
$(document).scroll(function (){
    if ($(document).scrollTop() >= 30) {
        $("#navigation-bar").addClass("fixed-top").removeClass("mt-30");
        $("#navigation-bar .navbar").removeClass("rounded-top");
        $("#con").css("margin-top", postop);
        $("#jump-to-top").addClass("visible");
    } else {
        $("#navigation-bar").removeClass("fixed-top").addClass("mt-30");
        $("#navigation-bar .navbar").addClass("rounded-top");
        $("#con").css("margin-top", "");
        $("#jump-to-top").removeClass("visible");
    }
})
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - 80
        }, 500);
    });
});
