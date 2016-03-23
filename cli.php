<?php

namespace Mtantawy\PushbulletVisitorsNotification;

$access_token = isset($argv[1]) ? $argv[1] : false;
$ip = isset($argv[2]) ? $argv[2] : false;

if (!$access_token || !$ip) {
    die('no access_token or ip');
}

require_once 'src/Tools.php';
require_once 'src/GeoIP.php';
require_once 'src/PushbulletNotification.php';

$geo_ip = new GeoIP();
$geo_data = $geo_ip->getGeoData($ip);

if (false !== $geo_data) {
    $notifier = new PushbulletNotification();
    $notification_status = $notifier->sendNotification($geo_data, $access_token);
}
