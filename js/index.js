$(function() {
    toggleDarkmode(parseInt(localStorage.getItem('darkmode')));

    $('#darkmode-toggle').click(function() {
        toggleDarkmode(($('#darkmode').attr('href') !== 'css/darkmode.css'));
    });

    function toggleDarkmode(setDark) {
        if (setDark) {
            localStorage.setItem('darkmode', '1');
            $('#darkmode').attr('href', 'css/darkmode.css');
        } else {
            localStorage.setItem('darkmode', '0');
            $('#darkmode').attr('href', '');
        }
    }
});