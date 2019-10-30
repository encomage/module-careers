define([
    'jquery',
    'domReady!'
], function ($) {
    'use strict';
    return function (config, element) {

        var form = $(element),
            resume = $('.js-resume'),
            sendButton = $('.js-send-button'),
            maxSize = config.max_size,
            fileName = $('.file-name');

        $(resume).bind('change', function () {
            if (!_isAllowedExtansion(this)) {
                return false;
            }
            var uploadFile = this.files[0];
            if (uploadFile && uploadFile.size > maxSize) {
                $(this).parent().children('span').show();
                sendButton.attr('disabled', true);
                return false;
            } else {
                $(this).parent().children('span').hide();
                if (resume[0].files.length) {
                    if (resume[0].files[0].size < maxSize || letter[0].files[0].size < maxSize) {
                        sendButton.removeAttr('disabled');
                    }
                } else {
                    sendButton.attr('disabled', true);
                }
            }
            fileName.text(uploadFile.name);
            fileName.show();
            form.validation().valid();
        });

        $(sendButton).on('click', function () {
            var validator = form.validation();
            if (validator.valid()) {
                sendButton.attr('disabled', true);
                form.submit();
            }
        });

        function _isAllowedExtansion(file) {

            var extensions = config.allowed_extensions,
                result = false;
            if (file.value) {
                var ext = $(file).val().substring($(file).val().lastIndexOf('.') + 1);
                $.each(extensions, function (value, element) {
                    if (ext === $.trim(element)) {
                        result = true;
                        $('#resume-error').remove();
                        $('#attachFileUpload').remove();
                        $('#attachFileUpload').hide();
                    }
                });
            }
            if (!result) {
                $(file).val('');
                fileName.hide();
                form.validation().valid();
                $('#resume-error').hide();
                $('#attachFileUpload').append("<span class='tooltip'>" + $.mage.__('Filetype is not allowed! Please, use ' + extensions.join(', ')) + "</span>")
            }
            return result;
        }
    }
});