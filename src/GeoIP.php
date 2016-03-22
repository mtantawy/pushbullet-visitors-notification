<?php

namespace Mtantawy\PushbulletVisitorsNotification;

class GeoIP
{
    public function getGeoData($ip)
    {
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

    private function getURL($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['errno'] = $err;
        $header['errmsg'] = $errmsg;
        $header['content'] = $content;

        return $header;
    }
}
