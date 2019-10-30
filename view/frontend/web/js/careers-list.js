define([
    'jquery'
], function ($) {
    'use strict';
    return function (config, element) {
        $.ajax({
            type: 'POST',
            url: config.ajaxCategoryUrl,
            data: {is_ajax: true},
            showLoader: true
        }).done(function (xhr) {
            if (xhr.success) {
                $('.js-category-button-list').html(xhr.html);
            }
        }).fail(function (xhr) {
            location.reload();
        });

        _ajaxItems(0);


        $(document).on('click', '.open-vacancies-menu', function () {
            $(this).parent().toggleClass('opened');
        });

        $(document).on('click','.navigation ul li', function () {
            $('.navigation ul li').removeClass('active');
            $(this).addClass('active');
        });

        $(document).on('click', '.js-load-careers-category-items', function (e) {
            e.preventDefault();
            if ($(this).data('categoryId')) {
                _ajaxItems($(this).data('categoryId'));
            }
        });

        function _ajaxItems(categoryId) {
            $.ajax({
                type: 'POST',
                url: config.ajaxItemsUrl,
                data: {id: categoryId},
                showLoader: true
            }).done(function (xhr) {
                if (xhr.success) {
                    $('.js-ajax-items-container').html(xhr.html);
                 }
            }).fail(function (xhr) {
                location.reload();
            });
        }
    }
});