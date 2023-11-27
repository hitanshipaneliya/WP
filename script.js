setTimeout(function () {
    
}, 1000); 

// ========== back to top
$(document).on('click', '.back-to-top', function () {
    $("html,body").animate({
        scrollTop: 0
    }, 2000);
});

$(window).on('scroll', function(){
    //back to top show/hide
    var ScrollTop = $('.back-to-top'); 
    if ($(window).scrollTop() > 1000) {
        ScrollTop.fadeIn(1000);
    } else {
        ScrollTop.fadeOut(1000);
    }  
})

var backtoTop = $('.back-to-top')
        backtoTop.fadeOut();



// ===============
//Scroll Down
$(document).on('click', '.scroll-down-area a', function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top}, 500, 'linear');
})

// video play and stop

 jQuery(".video_class i.fa.fa-play").click(function(){
    // console.log("play--------------------");
    jQuery(".video_class").addClass("stop_video");
    jQuery(".video_class  i.fa.fa-stop").show();
    jQuery(".video_class i.fa.fa-play").hide();
    jQuery('.our_unit_video video, .menu_unit_video video').trigger('play');     
});

jQuery(".video_class i.fa.fa-stop").click(function(){
    // console.log("stop---------------------");      
    jQuery(".video_class").removeClass("stop_video");
    jQuery(".video_class  i.fa.fa-stop").hide();
    jQuery(".video_class i.fa.fa-play").show();
    jQuery('.our_unit_video video, .menu_unit_video video').trigger('pause');

});

// ============
jQuery(document).ready(function() {
    //Remove img title and alter
    jQuery('img').removeAttr('title');
    jQuery('img').removeAttr('alt');
    jQuery('a').removeAttr('title');
    jQuery('a').removeAttr('alt');

});


jQuery('.variations select option').eq(1).prop('selected', true);


// =====================google translate

<div id="google_translate_element"><div> 
<div id="google_translate_element_mob"><div> 
<span>
    <script type="text/javascript">

        function googleTranslateElementInit() {
            if(screen.width >= 981){
                new google.translate.TranslateElement({
                    includedLanguages: "en,hi", autoDisplay: false,
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, "google_translate_element");
            }
            else{
                new google.translate.TranslateElement({
                    includedLanguages: "en,hi", autoDisplay: false,
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, "google_translate_element_mob");
            }
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</span>



