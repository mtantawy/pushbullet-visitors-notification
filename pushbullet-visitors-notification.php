<?php
/*
  Plugin Name: Pushbullet Visitors Notification
  Description: Send Pushbullet notification whenever a user visits the blog, notification includes data like IP and GeoIP info using an API by http://freegeoip.net/ .
  Version: 1.1.4
  Author: Mahmoud Tantawy
  Author URI: https://mtantawy.com
  License: GPLv2 or later
 */

namespace Mtantawy\PushbulletVisitorsNotification;

require_once 'src/Tools.php';
require_once 'src/GeoIP.php';
require_once 'src/PushbulletNotification.php';

$geo_ip =  new GeoIP();

$geo_data = $geo_ip->getGeoData('185.89.72.160');
