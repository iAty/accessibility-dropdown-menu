/*
 * Letiltjuk az egérmutatókat az almenüben, most csak kattintással elérhetők az almenük.
 */
jQuery(document).ready(function ($) {
  jQuery("button.szmjv-navigation-toggle").each(function (index, button) {
    var ul = jQuery(this).closest("ul");
    var li = jQuery(this).closest("li");
    jQuery("ul.sub-menu", ul).css("display", "none");
    jQuery("ul.sub-menu", ul).css("opacity", "1");
    jQuery("ul.sub-menu", ul).css("visibility", "visible");
    jQuery("li:hover ul.sub-menu", ul).css("display", "none");

    var color = jQuery("a", li).css("color");
    jQuery(this).css("color", color);
  });
});

/*
 * Hozzárendel egy almenü gombot
 */
jQuery(document).ready(function ($) {
  jQuery("button.szmjv-navigation-toggle").on("click", function () {
    var was_toggled = false;
    var ul = jQuery(this).closest("ul");
    var listitem = jQuery(this).parent();
    if (jQuery(this).hasClass("szmjv-toggled")) {
      was_toggled = true;
    }

    // visszaállítja az összes almenüt
    jQuery("ul.sub-menu", ul).css("display", "none");
    jQuery("button.szmjv-navigation-toggle", ul).removeClass("szmjv-toggled");

    if (was_toggled == false) {
      jQuery(this).addClass("szmjv-toggled");
      jQuery("ul.sub-menu", listitem).fadeIn(300);
      jQuery("ul.sub-menu", listitem).css("display", "block");
    }

    return false;
  });
});
