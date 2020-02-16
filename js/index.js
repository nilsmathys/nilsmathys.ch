$(function() {
    toggleDarkmode(parseInt(localStorage.getItem('darkmode')));

    $('#darkmode-toggle').click(function() {
        toggleDarkmode(($('#darkmode').attr('href') !== 'css/darkmode.css'));
        return false;
    });

    function toggleDarkmode(setDark) {
        if (setDark) {
            localStorage.setItem('darkmode', '1');
            $('#darkmode').attr('href', 'css/darkmode.css');
            grecaptcha.render("recaptcha", {
                "theme": "dark"
            })
        } else {
            localStorage.setItem('darkmode', '0');
            $('#darkmode').attr('href', '');
            grecaptcha.render("recaptcha", {
                "theme": "light"
            })
        }
    }
});