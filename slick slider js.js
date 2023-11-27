jQuery(document).ready(function(){

//  arrow biji ye mukaya hoi to
jQuery(".doc_pup_arrow .bk_arrow_right").on("click", function(){
    jQuery(".doc_popup_slider .slick-next").click();
});
jQuery(".doc_pup_arrow .bk_arrow_left").on("click", function(){
    jQuery(".doc_popup_slider .slick-prev").click();
});



     // slider 
 jQuery('.client_otr').slick({
      arrows:true,
      infinite: true,
      prevArrow: '<div class="slick-prev slick-arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
      nextArrow: '<div class="slick-next slick-arrow"><i class="fa fa-angle-right " aria-hidden="true"></i></div>',
      speed: 1000,
      slidesToShow: 9,
      slidesToScroll: 9,
      responsive: 
      [
           {
                breakpoint: 1140,
                settings: {
                     slidesToShow: 7,
                     slidesToScroll: 7,
                }
           },
      ]
 });

});




.slick-arrow::before {
    display: none;
}
.slick-arrow {
    font-size: 27px;
    color: #000;
    background: #F5F5F5;
    border: 1px solid #DDDDDD;
    width: 40px;
    height: 40px;
    line-height: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: 1s;
    z-index: 2;
}

.slick-arrow:hover {
    background: #E3000F;
    color: #ffff;
}