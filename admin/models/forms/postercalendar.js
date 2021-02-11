jQuery(function() {
    document.formvalidator.setHandler('image',
        function (value) {
            regex=/https?:\/\/((?:[\w\d-]+\.)+[\w\d]{2,})/i;
            return regex.test(value);
        });
});