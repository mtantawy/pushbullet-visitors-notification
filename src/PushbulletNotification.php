<?php

namespace Mtantawy\PushbulletVisitorsNotification;

class PushbulletNotification
{
    use Tools;
    
    public function sendNotification($data, $access_token)
    {
        $post_fields = $this->prepareData($data);
        $headers = $this->prepareHeaders($access_token);

        $base_url = 'https://api.pushbullet.com/v2/pushes';
        $response = $this->getURL($base_url, $post_fields, $headers);

        if ($response['http_code'] == 200) {
            return json_decode($response['content'])->active;
        } else {
            return false;
        }
    }

    private function prepareData($data)
    {
        $prepared = [
            'type'  =>  'note',
            'title' =>  'New Visitor From: '.$data['Country'],
            'body'  =>  '',
        ];

        foreach ($data as $key => $value) {
            $prepared['body'] .= (empty($prepared['body']) ? '':'NEW_LINE') . $key .': ' . $value;
        }

        return str_replace('NEW_LINE', '\n', json_encode($prepared));
    }

    private function prepareHeaders($access_token)
    {
        return [
            'Content-Type: application/json',
            'Access-Token: '.$access_token,
        ];
    }
}
