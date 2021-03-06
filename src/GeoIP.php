<?php

namespace Mtantawy\PushbulletVisitorsNotification;

class GeoIP
{
    use Tools;
    
    public function getGeoData($ip)
    {
        if (empty($ip)) {
            return false;
        }

        $base_url = 'http://www.geoplugin.net/json.gp?ip=';
        $response = $this->getURL($base_url.$ip);

        if ($response['http_code'] == 200) {
            return $this->prepareData($response['content']);
        } else {
            return false;
        }
    }

    private function prepareData($content)
    {
        $data = json_decode($content);

        return [
            'IP'    =>  $data->geoplugin_request,
            'Country'   =>  $data->geoplugin_countryName,
        ];
    }
}
