// ====================
jQuery('a[href*=\\#]:not([href=\\#])').click(function() {
  if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
      if (target.length) {                   
          jQuery('html, body').animate({
              scrollTop: target.offset().top - 120
          }, 500);
          return false;
      }
  }
});   


jQuery(function() {
  jQuery('a[href*=#]:not([href=#])').click(function() {
      var target = jQuery(this.hash);
      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
          setTimeout(function() {

              jQuery('html,body').animate({
                  scrollTop: target.offset().top - 150 //offsets for fixed header
              }, 1000);
          }, 10);
          return false;
      }


  });

});