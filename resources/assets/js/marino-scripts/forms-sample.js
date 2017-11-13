/**
 * @author Batch Themes Ltd.
 */
(function() {
    'use strict';
    $(function() {
        var config = $.localStorage.get('config');
        $('body').attr('data-layout', config.layout);
        $('body').attr('data-palette', config.theme);
        $('body').attr('data-direction', config.direction);
        $('#username-1').floatingLabels({
            errorBlock: 'Please enter your username'
        });
        $('#email-1').floatingLabels({
            errorBlock: 'Введите Ваш E-mail',
            isEmailValid: 'Введите корректный E-mail'
        });
        $('#password-1').floatingLabels({
            errorBlock: 'Введите ваш пароль',
            minLength: 6
        });
        $('#confirm-password-1').floatingLabels({
            errorBlock: 'Подтвердите ваш пароль',
            minLength: 6,
            isFieldEqualTo: $('#password-1')
        });
        $('#email-2').floatingLabels({
            errorBlock: 'Please enter your email',
            isEmailValid: 'Please enter a valid email'
        });
        $('#password-2').floatingLabels({
            errorBlock: 'Please enter a valid password',
            minLength: 6
        });
        $('#email-3').floatingLabels({
            errorBlock: 'Please enter your email',
            isEmailValid: 'Please enter a valid email'
        });
        $('#email-4').floatingLabels({
            errorBlock: 'Please enter your email',
            isEmailValid: 'Please enter a valid email'
        });
        $('#password-4').floatingLabels({
            errorBlock: 'Please enter a valid password',
            minLength: 6
        });
        $(document).on('click', '#email-1', function(e) {
            $(".help-block").html('');
	    
	});
        $('#email-1').focus();
    });
})();
