<?php
/*
  Plugin Name: Pushbullet Visitors Notification
  Description: Send Pushbullet notification whenever a user visits the blog, notification includes data like IP and GeoIP info using an API by geoplugin.net .
  Version: 1.1.4
  Author: Mahmoud Tantawy
  Author URI: https://mtantawy.com
  License: GPLv2 or later
 */

namespace Mtantawy\PushbulletVisitorsNotification;

// if u want to load a function only in the front end
add_action('wp_loaded', function () {
    if (!is_admin()) { // Only target the front end
        $access_token = get_option('mtantawy_pushbullet_access_token');
        $ip = getVisitorIp();
        $path = plugin_dir_path(__FILE__);

        exec('cd "'.$path.'"; php cli.php '.$access_token.' '.$ip.' >> output');
    }
});

function getVisitorIp()
{
    $ip=$_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {               // check ip from share internet
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   // to check ip is pass from proxy
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    $ips = explode(",", $ip);
    return $ips[0];
}
