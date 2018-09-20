// Contact Form Scripts

$(function() {

    $("#contactForm input,#contactForm textarea").jqBootstrapValidation({
        preventSubmit: false,
        submitError: function($form, event, errors) {
            // additional error messages or events
        },
        submitSuccess: function($form, event) {

        },
        filter: function() {
            return $(this).is(":visible");
        },
    });
});
