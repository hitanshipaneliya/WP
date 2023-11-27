// sub menu dynamic
jQuery(document).ready(function(){
    var  main_menu_class  = jQuery("ul#menu-main-menu .sub-menu li").length;
    console.log("main_menu_class",main_menu_class);
    var css_append = "";
    var k = 0;
    for (let i = 0; i < main_menu_class; i++) {
        k++;
        var css_transition = k + 2;
        css_append += '#menu-main-menu li:hover ul li:nth-child('+k+') {transition: 0.'+css_transition+'s;}';
    }
    console.log("css_append",css_append);

    jQuery("footer").append("<style>"+css_append+"</style>");
});

