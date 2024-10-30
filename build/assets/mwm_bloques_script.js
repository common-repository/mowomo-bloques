jQuery(document).ready(function() {
    var imagenes = [];

    // Bloque de parallax
    jQuery(
        ".mwm-bloques-imagen-parallax .imagen-parallax-img.mwm-parallax"
    ).each(function(e) {
        imagenes.push(jQuery(this));
    });

    // Animaciones de transición
    AOS.init();
    jQuery(".bloque-descripcion-boton")
        .find(".enlace.hover")
        .hover(function(e) {
            jQuery(this)
                .css(
                    "background-color",
                    e.type === "mouseenter"
                        ? jQuery(this).attr("color-background-boton-hover")
                        : jQuery(this).attr("color-background-boton")
                )
                .css(
                    "color",
                    e.type === "mouseenter"
                        ? jQuery(this).attr("color-boton-hover")
                        : jQuery(this).attr("color-boton")
                );
        });

    // Bloque de parallax
    jQuery(window).on("scroll", function(e) {
        var scrolled = jQuery(this).scrollTop();
        jQuery(
            ".mwm-bloques-imagen-parallax .imagen-parallax-img.mwm-parallax"
        ).each(function(index) {
            var initY = imagenes[index].offset().top;
            var height = imagenes[index].height();
            var diff = scrolled - initY;
            var ratio = Math.round((diff / height) * 100);
            imagenes[index].css(
                "background-position",
                "center " + parseInt(-(ratio * 0.7)) + "px"
            );
        });
    });
});
