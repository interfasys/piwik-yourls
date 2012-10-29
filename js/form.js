/*Some JavaScript for the form*/
$(function () {
    'use strict';
    $('#options h3 a').click(function () {
        var a = $(this).attr('href');
        $(a).slideToggle();
        return false;
    });
    $(".parameter").hide();

    $('A[rel="external"]').click(function () {
        window.open($(this).attr('href'));
        return false;
    });

    setTimeout(function () {
        $('.message_success').slideToggle();
    }, 2000);

    // Enable uniform.js. Select cannot be used in a hidden layer...yet
    $("input, button").uniform();
    //$("select, input, button").uniform();
});