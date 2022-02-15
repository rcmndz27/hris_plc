function CheckInputValue(varObject) {

    var ctr = 0;

    $.each(varObject, function (index, objval) {
        objval.next($('.errmsg')).remove();

        if (objval.hasClass('inputemail')) {

            var reg_exp = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

            if (reg_exp.test(objval.val())) {
                objval.removeClass('error');
            } else {
                objval.addClass('error');
                objval.after('<span class="errmsg">Invalid email</span>');
                ctr++;
            }

        } else if (objval.hasClass('inputnumber')) {
            if (isNaN(objval.val())) {
                objval.addClass('error');
                objval.after('<span class="errmsg text-danger">Invalid contact number</span>');
                ctr++;
            } else {
                if (objval.val() === '' || objval.val() === ' ') {
                    objval.addClass('error');
                    objval.after('<span class="errmsg text-danger">Invalid contact number</span>');
                    ctr++;
                } else {
                    objval.removeClass('error');
                }
            }
        } else if (objval.hasClass('inputnumberformatted')) {
            if (isNaN(objval.val())) {
                objval.addClass('error');
                objval.after('<span class="errmsg text-danger">Invalid format</span>');
                ctr++;
            } else {
                if (objval.val() === '' || objval.val() === ' ') {
                    objval.addClass('error');
                    objval.after('<span class="errmsg text-danger">Invalid format</span>');
                    ctr++;
                } else {
                    objval.removeClass('error');
                }
            }
        } else if (objval.hasClass('inputtext')) {

            if (objval.val() === '' || objval.val() === ' ') {
                objval.addClass('error');
                objval.after('<span class="errmsg text-danger"></span>');
                ctr++;
            } else {
                objval.removeClass('error');
            }
        } else if (objval.hasClass('inputtextformatted')) {

            if (objval.val() === '' || objval.val() === ' ') {
                objval.addClass('error');
                objval.after('<span class="errmsg text-danger">Invalid format</span>');
                ctr++;
            } else {
                objval.removeClass('error');
            }
        }
    });

    return (ctr === 0) ? '0' : ctr;
}