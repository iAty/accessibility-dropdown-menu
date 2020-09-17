<?php


/*
 * Hozzáadja a CSS-t a frontendhez.
 *
 */
function szmjv_css() {

	$locations = get_option('szmjv_locations');

	if ( ! is_array( $locations ) || empty( $locations ) ) {
		return;
	}
	?>
<style type="text/css" id="szmjv-css">
/*
	 * szmjv: Akadálymentes legördülő menük
	 */

<?php foreach ($locations as $location) {
    $element=szmjv_get_container_element($location);
    echo '
html body ' . $element . 'li.menu-item-has-children: hover, ';

}

echo '
html body ' . $element . 'li.menu-item-has-children:hover {
    ';
?>box-shadow: none;
}

<?php foreach ($locations as $location) {
    $element=szmjv_get_container_element($location);
    echo '
html body ' . $element . 'li.menu-item-has-children ul,
    html body ' . $element . 'li.menu-item-has-children: hover ul, ';

}

echo '
html body ' . $element . 'li.menu-item-has-children:hover ul {
    ';
?>display: none;
    opacity: 1;
    visibility: visible;
    transition: none;
}

html body button.szmjv-navigation-toggle {
    display: inline-block;
    width: 20px;
    height: 20px;
    font-size: 22px;
    line-height: 0px;
    font-weight: bold;
    font-stretch: expanded;
    text-align: center;
    border: solid 0px transparent;
    padding: 13px 0 13px 0;
    margin: 0 8px 0 -4px;
    background-color: transparent;
    box-shadow: none;
    transform: rotate(-270deg) scale(.8, 2);
}

html body button.szmjv-navigation-toggle:hover {
    box-shadow: none;
}

html body button.szmjv-navigation-toggle.szmjv-toggled {
    transform: rotate(-90deg) scale(.8, 2);
}

html body button.szmjv-navigation-toggle:focus {
    outline: 1px solid #fff;
}
</style>
<?php
}
add_action( 'wp_footer', 'szmjv_css', 1 );