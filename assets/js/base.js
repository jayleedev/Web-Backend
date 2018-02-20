//
// Base.js
// -----------------------------------------------


// handle links with @href started with '#' only
$(document).on('click', 'a[href^="#"]', function(e) {
    // target element id
    var id = $(this).attr('href');

    // target element
    var $id = $(id);
    if ($id.length === 0) {
        return;
    }

    // prevent standard hash navigation (avoid blinking in IE)
    e.preventDefault();

    // top position relative to the document
    var pos = $(id).offset().top;

    // animated top scrolling
    $('body, html').animate({scrollTop: pos});
});


//
// Animations
// -----------------------------------------------

$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $(this).addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});


//
// Mailing list
// -----------------------------------------------

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function subscribeToNewsletter(ele) {
    var newsletter = ele.parent().parent('.newsletter');
    var newsletterForm = ele.parent('form');

    // Email field and data
    var emailField = newsletterForm.children('input.newsletter-email');
    var email = emailField.val();
    var interest = 'Bear,Shiny Frog';

    // Invalid Email
    if ( !validateEmail(email) ) {
        newsletterForm.animateCss('bounce');

        newsletter.find('p').hide();
        newsletter.find('.newsletter-text-invalid-email').show().animateCss('fadeInDown');

        return;
    }

    // encoding the email address in order to have the + sign treated correctly
    email = encodeURIComponent(email);
    
    // annotation if exists
    var annotationField = newsletterForm.children('input.newsletter-annotation');
    var annotation = annotationField.val();
    annotation = encodeURIComponent(annotation);

    // Calling the server for registering the email
    $.ajax({
        url: "http://apps.shinynode.com/data/add_email/?email=" + email + "&interest=" + interest + "&annotation=" + annotation,
        error: function (xhr, status) {
            newsletterForm.animateCss('bounce');

            newsletter.find('p').hide();
            newsletter.find('.newsletter-text-error').show().animateCss('fadeInDown');

        },
        success: function (data) {

            var returnData = JSON.parse(data);
            // hide any other message
            newsletter.find('p').hide();
            // generic error
            var messageContainer = newsletter.find('.newsletter-error');

            if (returnData.result === "true") {
                // yay!
                messageContainer = newsletter.find('.newsletter-text-success');
            }
            else {
                if (returnData.error === "alreadyRegistered") {
                    // welcome back!
                    messageContainer = newsletter.find('.newsletter-text-already-registered');
                }
            }

            // showing the message
            messageContainer.show().animateCss('fadeInDown');
        },
        type: "GET",
        context: document.body,
        dataType: "text"
    });

}

$('.newsletter-email').keydown(function(event){
    if(event.keyCode == 13) {
        event.preventDefault();
        subscribeToNewsletter($(this));
        return false;
    }
});


$('.newsletter-submit').click(function(event){
    subscribeToNewsletter($(this));
});

