<?php
/*
  Plugin Name: Pushbullet Visitors Notification
  Description: Send Pushbullet notification whenever a user visits the blog, notification includes data like IP and GeoIP info using an API by geoplugin.net .
  Version: 1.0.0
  Author: Mahmoud Tantawy
  Author URI: https://mtantawy.com
  License: GPLv2 or later
 */

namespace Mtantawy\PushbulletVisitorsNotification;

// if u want to load a function only in the front end
add_action('wp_loaded', function () {
    if (!is_admin()) { // Only target the front end
        if (checkUserAgent()) {
            return false;
        }
        $ip = getVisitorIp() ?: false;
        if (false === $ip) {
            return false;
        }
        $path = plugin_dir_path(__FILE__);
        $access_token = get_option('mtantawy_pushbullet_access_token');
        
        exec('cd "'.$path.'"; php cli.php '.$access_token.' '.$ip.' >> output');
    }
});

function getVisitorIp()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {               // check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   // to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    $ips = explode(',', $ip);

    return isset($ips[0]) ? $ips[0] : false;
}

function checkUserAgent()
{
    $user_agent_strings = ['jetpack', 'bot', 'wordpress'];
    foreach ($user_agent_strings as $string) {
        if (false !== strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $string)) {
            return false;
        }
    }
    return true;
}
