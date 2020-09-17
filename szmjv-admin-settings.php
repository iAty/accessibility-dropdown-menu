<?php

/*
 * Opcióoldalt ad hozzá a Beállításokhoz.
 */
function szmjv_options()
{
    add_options_page(esc_html__('szmjv', 'szmjv'), esc_html__('szmjv', 'szmjv'), 'manage_options', 'szmjv.php', 'szmjv_options_page');
}
add_action('admin_menu', 'szmjv_options', 11);

function szmjv_options_page()
{

    $locations = get_nav_menu_locations();
    ?>
<div class="wrap szmjv">
    <h1><?php esc_html_e('SZMJV - Az akadálymentes legördülő menük beállításai', 'szmjv');?></h1>
    <?php
if (isset($_POST['szmjv_options_page'])) {
        if (function_exists('current_user_can') && !current_user_can('manage_options')) {
            die(esc_html__('Cheatin&#8217; uh?', 'szmjv'));
        }

        /* Check Nonce */
        $verified = false;
        if (isset($_POST['szmjv_options_nonce'])) {
            $verified = wp_verify_nonce($_POST['szmjv_options_nonce'], 'szmjv_options_nonce');
        }
        if ($verified == false) {
            // Nonce is invalid.
            echo '<div id="message" class="error fade notice is-dismissible"><p>' . esc_html__('The Nonce did not validate. Please try again.', 'szmjv') . '</p></div>';
        } else {
            if (isset($_POST['szmjv_locations'])) {
                $postdata = $_POST['szmjv_locations'];
                $szmjv_locations = array();
                foreach ($locations as $location => $id) {
                    $location = sanitize_text_field($location);
                    $id = sanitize_text_field($id);
                    $postdata["$location"] = sanitize_text_field($postdata["$location"]);
                    // We don't store $postdata, only the locations from the theme.
                    if (isset($postdata["$location"]) && $postdata["$location"] == 'on') {
                        $szmjv_locations[] = $location;
                    }
                }
                update_option('szmjv_locations', $szmjv_locations);
                echo '<div id="message" class="updated fade notice is-dismissible"><p>' . esc_html__('Settings updated successfully.', 'szmjv') . '</p></div>';
            } else {
                update_option('szmjv_locations', '');
                echo '<div id="message" class="updated fade notice is-dismissible"><p>' . esc_html__('Settings updated successfully.', 'szmjv') . '</p></div>';
            }
        }
    }
    ?>

    <div id="poststuff" class="metabox-holder">

        <p><?php esc_html_e('Menu Locations', 'szmjv');?></p>
        <form name="szmjv_options_page" action="#" method="POST">
            <?php
/* Nonce */
    $nonce = wp_create_nonce('szmjv_options_nonce');
    echo '
				<input type="hidden" id="szmjv_options_nonce" name="szmjv_options_nonce" value="' . $nonce . '" />';

    $locations_settings = get_option('szmjv_locations');
    if (is_array($locations)) {
        foreach ($locations as $location => $id) {
            $on = '';
            if (is_array($locations_settings) && in_array($location, $locations_settings)) {
                $on = 'checked="checked"';
            }?>
            <label>
                <input type="checkbox" <?php echo $on; ?> name="szmjv_locations[<?php echo $location; ?>]"
                    class="szmjv-locations" />
                <?php echo $location; ?>
            </label><br />
            <?php
}
    }
    ?><br />

            <span class="setting-description">
                <?php
esc_html_e('These are the menu locations that are part of your theme. You will probably have a navigation menu set for some locations.', 'szmjv');
    echo '<br />';
    esc_html_e('You can select for which locations you want the szmjv buttons added.', 'szmjv');
    ?>
            </span><br /><br />

            <input type="hidden" class="form" value="szmjv_options_page" name="szmjv_options_page" />
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save', 'szmjv');?>" />
        </form><br /><br />

        <h2 class="widget-top"><?php esc_html_e('Support.', 'szmjv');?></h2>



    </div>
</div>
<?php
}

/*
 * Regisztrálja a beállításokat.
 */
function szmjv_register_settings()
{
    register_setting('szmjv_options', 'szmjv_locations', 'array');
}
add_action('admin_init', 'szmjv_register_settings');

/*
 * A Beállítások link hozzáadása a bővítmény főoldalához.
 */
function szmjv_links($links, $file)
{
    if ($file == plugin_basename(dirname(__FILE__) . '/szmjv.php')) {
        $links[] = '<a href="' . admin_url('options-general.php?page=szmjv.php') . '">' . esc_html__('Settings', 'szmjv') . '</a>';
    }
    return $links;
}
add_filter('plugin_action_links', 'szmjv_links', 10, 2);