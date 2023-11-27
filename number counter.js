    // counter
    jQuery('.number').each(function () {
        jQuery(this).prop('Counter', 0).animate({
            Counter: jQuery(this).text()
        },
            {
                duration: 5000,
                easing: 'swing',
                step: function (now) {
                    jQuery(this).text(Math.ceil(now));
                }
            });
    });

    // <span class="number">500</span>+