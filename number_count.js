jQuery('.number').each(function () {
    jQuery(this).prop('Counter',0).animate({
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

// number count
 jQuery(document).ready(function() {
    jQuery('.btc_yeaer_title span').each(function () {
        console.log("working------------>");
        jQuery(this).prop('Counter',0).animate({
            Counter: jQuery(this).text()
        }, {
            duration: 5000,
            easing: 'swing',
            step: function (now) {
                jQuery(this).text(Math.ceil(now));
            }
        });
    });
});


//  secound code

var counted = 0;
jQuery(window).scroll(function() {

  var oTop = jQuery('.ds_we_use_section').offset().top - window.innerHeight;
  if (counted == 0 && jQuery(window).scrollTop() > oTop) {
    jQuery('.ds_filler_num').each(function() {
      var $this = jQuery(this),
        countTo = $this.attr('data-count');
      jQuery({
        countNum: $this.text()
      }).animate({
          countNum: countTo
        },
        {
          duration: 4000,
          easing: 'swing',
          step: function() {
            $this.text(Math.floor(this.countNum));
          },
          complete: function() {
            $this.text(this.countNum);
          }

        });
    });
    counted = 1;
  }

});
