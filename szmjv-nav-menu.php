<?php


/*
 * A menü HTML objektumainak létrehozása előtt kiszűri a menüpont objektumok rendezett listáját.
 * A felső szintű menüpontok listáját a szmjv_get_nav_items () oldalra fogja tölteni.
 * A szűrt adatokban semmit sem változtat.
 *
 * @sience 1.0.0
 *
 * @param array    $sorted_menu_items A menüpontok, az egyes menüpontok menürendje szerint rendezve.
 * @param stdClass $args              A wp_nav_menu () argumentumokat tartalmazó objektum.
 * @return array   $sorted_menu_items A menüpontok változatlanok.
 */
function szmjv_wp_nav_menu_objects( $sorted_menu_items, $args ) {

	$location = $args->theme_location;
	$container = $args->container;
	$container_class = $args->container_class;
	if ( strlen( $container_class ) > 0 ) {
		$element = $container . '.' . $container_class;
	} else {
		$element = 'ul.' . $args->menu_class;
	}
	$locations = get_nav_menu_locations();
	$locations_settings = get_option('szmjv_locations');

	szmjv_get_container_element( $location, $element );

	if ( strlen( $location ) > 0 && is_array( $locations ) && is_array( $locations_settings ) ) {
		if ( in_array( $location, $locations_settings ) ) {
			$nav_items = array();
			foreach ( $sorted_menu_items as $item ) {
				if ( $item->menu_item_parent == 0 ) {
					if ( isset( $item->classes ) && ! empty( $item->classes ) ) {
						foreach ( $item->classes as $class ) {
							if ( $class == 'menu-item-has-children' ) {
								$nav_items[] = $item->ID;
							}
						}
					}
				}
			}
			szmjv_get_nav_items( $location, $nav_items );
		}
	}

	return $sorted_menu_items;

}
add_filter( 'wp_nav_menu_objects', 'szmjv_wp_nav_menu_objects', 99, 2 );



/*
 * Szűri a navigációs menük HTML-listájának tartalmát, és egy gombot ad a menüszintek felső szintjéhez.
 * @see wp_nav_menu()
 *
 * @param string   $items A menüelemek HTML-listájának tartalma.
 * @param stdClass $args  A wp_nav_menu () argumentumokat tartalmazó objektum.
 * @return string  $items A menüelemek HTML-listájának tartalma.
 */
function szmjv_wp_nav_menu_items( $items, $args ) {

	$location = $args->theme_location;
	$button = szmjv_get_button( $location );
	$nav_items = szmjv_get_nav_items( $location );

	if ( isset( $nav_items ) && ! empty( $nav_items ) ) {
		foreach ( $nav_items as $nav_item ) {
			$pattern = '#(<li.+id=["|\']menu-item-' . $nav_item . '(.*)[^>]+>)(.+)(</a>)#msiU';
			$replacement = "$0 $button";
			$items = preg_replace($pattern, $replacement, $items);
		}
	}

	return $items;

}
add_filter( 'wp_nav_menu_items', 'szmjv_wp_nav_menu_items', 10, 2 );


/*
 * A felső szintű navigációs elemek azonosítóinak beállítása/lekérése.
 *
 */
function szmjv_get_nav_items( $location, $nav_items = array() ) {

	static $items;

	if ( empty( $items ) ) {
		$items = array();
	}

	if ( strlen( $location ) == 0 ) {
		return array();
	}

	if ( ! isset( $items["$location"] ) || empty( $items["$location"] ) ) {
		$items["$location"] = array();
	}

	if ( isset( $nav_items ) && ! empty( $nav_items ) ) {
		$items["$location"] = $nav_items;
	}

	return $items["$location"];

}


/*
 * A nav-menü konténer elemének beállítása/beolvasása a nav-menü $args-ában meghatározottak szerint.
 * Lehet a div.primary-menu formátumban.
 *
 */
function szmjv_get_container_element( $location, $element = '' ) {

	static $locations;

	if ( ! isset( $locations ) ) {
		$locations = array();
	}

	if ( ! isset( $locations["$location"] ) ) {
		$locations["$location"] = '';
	}

	if ( strlen( $element ) > 0 ) {
		$locations["$location"] = $element;
	}

	return $locations["$location"];

}


/*
 * hozzárendeli a HTML-t menügombhoz, amely hozzáadódik a felső szint ul után.
 *
 */
function szmjv_get_button( $location ) {

	$html = '
		<button class="szmjv-navigation-toggle szmjv-navigation-' . $location . '-toggle" aria-expanded="false" aria-controls="nav-submenu-content">
			><span class="screen-reader-text">' . esc_html__('Toggle submenu', 'szmjv' ) . '</span>
		</button>';

	$html = apply_filters( 'szmjv_get_button', $html );
	return $html;

}


/*
 * A CSS és a JavaScript előfeldolgozása.
 *
 */
function szmjv_enqueue() {

	wp_register_script( 'szmjv_frontend_js', plugins_url('szmjv-frontend.js', __FILE__), 'jquery', szmjv_VER, true );
	wp_enqueue_script('szmjv_frontend_js');

}
add_action( 'wp_enqueue_scripts', 'szmjv_enqueue' );