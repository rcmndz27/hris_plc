$(document).ready(function() {

    // CLASSES

    if ($(window).width() > 991)
    {
        $('.travelorderContainer .subtitle').css("padding-left", "2rem");
        $('.leaveapplicationContainer .subtitle').css("padding-left", "2rem");

        $('.profileSettingsContainer #settingsOption').addClass('h-100');
        $('.profileSettingsContainer #settingsOption .btn').addClass('w-100 text-left');
    }
    else
    {
        $('.travelorderContainer .subtitle').css("padding-left", "");
        $('.leaveapplicationContainer .subtitle').css("padding-left", "");

        $('.profileSettingsContainer #settingsOption').removeClass('h-100');
        $('.profileSettingsContainer #settingsOption .btn').removeClass('w-100 text-left');
    }

    if ($(window).width() > 767)
    {
        $('.dtrContainer .dtrButtonContainer').addClass('justify-content-start');
        $('.dtrContainer .dtrButtonContainer').removeClass('justify-content-end');
    }
    else
    {
        $('.dtrContainer .dtrButtonContainer').addClass('justify-content-end');
        $('.dtrContainer .dtrButtonContainer').removeClass('justify-content-start');
    }

    // STYLES

    // if ($(window).width() > 720)
    // {
    //     $(".navbar-brand").text("Employee Web Portal");
    // }
    // else
    // {
    //     $(".navbar-brand").text("");
    // }
});

$(window).resize(function() {

    // CLASSES

    if ($(window).width() > 991)
    {
        $('.travelorderContainer .subtitle').css("padding-left", "2rem");
        $('.leaveapplicationContainer .subtitle').css("padding-left", "2rem");

        $('.profileSettingsContainer #settingsOption').addClass('h-100');
        $('.profileSettingsContainer #settingsOption .btn').addClass('w-100 text-left');
    }
    else
    {
        $('.travelorderContainer .subtitle').css("padding-left", "");
        $('.leaveapplicationContainer .subtitle').css("padding-left", "");

        $('.profileSettingsContainer #settingsOption').removeClass('h-100');
        $('.profileSettingsContainer #settingsOption .btn').removeClass('w-100 text-left');
    }

    if ($(window).width() > 767)
    {
        $('.dtrContainer .dtrButtonContainer').addClass('justify-content-start');
        $('.dtrContainer .dtrButtonContainer').removeClass('justify-content-end');
    }
    else
    {
        $('.dtrContainer .dtrButtonContainer').addClass('justify-content-end');
        $('.dtrContainer .dtrButtonContainer').removeClass('justify-content-start');
    }

    // STYLES

    // if ($(window).width() > 720)
    // {
    //     $(".navbar-brand").text("Employee Web Portal");
    // }
    // else
    // {
    //     $(".navbar-brand").text("");
    // }
});