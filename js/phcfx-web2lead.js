jQuery(document).ready(function() {

  // UI messages (notices and errors) are stored here
  var ui = {
    // init notices messages
    messages: {
      required: settings.messages.reqmsg   || messages.reqmsg,
      thankyou: settings.messages.thankyou || messages.thankyou
    }
  };

  // get feedback area and spinner
  var feedback = jQuery('#phcfxw2l-feedback');
  var spinner = jQuery('#spinner');

  // catch when user tries to submit the form
  jQuery('#phcfxw2l-form *[type="submit"]').click(function (event) {
    // mark fields with submitted class
    jQuery('#phcfxw2l-form :input').addClass('submitted');

    // check if all are valid
    var valid = jQuery('#phcfxw2l-form :invalid').length==0;

    // clear feedback messages
    feedback.html('').removeClass();

    // show message in case of invalid form
    if (!valid) feedback.html(ui.messages.required).toggleClass('alert alert-error').show('slow');
  });

  // handler that handles form submission
  jQuery('#phcfxw2l-form').submit(function (event) {

    // stop normal form submission handler
    event.preventDefault();

    // get form data as array of JS objects
    var form = jQuery(this).serializeArray();

    // generate data to send
    var data = {};
    jQuery.each(form, function (index, obj) { data[obj.name] = obj.value; });

    // insert backend settings into form data
    jQuery.each(settings.backend, function (key, value) { data[key] = value; });

    // try to send form to backend
    spinner.toggleClass('spin').show();
    jQuery.post(url, data)
    .done(function (response) {
      // get the error messages
      var errors = response ? response.messages : [];

      // check if there are errors
      if (errors && errors.length) {

        // display those errors to the user
        errors.forEach(function (error) {
          feedback.append('<p> - ' + error.messageCodeLocale + '</p>');
        });

        // show error messages
        feedback.toggleClass('alert alert-error').show('slow');

        return false;
      }

      // everything went ok
      feedback.html(ui.messages.thankyou).toggleClass('alert alert-success').show('slow');
    })
    .always(function () {
      // restore spinner
      spinner.removeClass().hide();
    });

    return false;
  });
});
