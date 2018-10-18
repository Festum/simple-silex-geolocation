<?php

//TODO: move to model
class IP extends ActiveRecord\Model//TODO: replace with Redis for better and faster performance

{
    static $table_name = 'ipinfo';
    static $primary_key = 'ip';
    static $connection = 'development';
    static $db = 'test';
}

ActiveRecord\Config::initialize(function ($cfg) {
    //TODO: move to .env and config control
    $DB_HOST = 'db';
    $DB_USER = 'test_user';
    $DB_PASS = 'secret';
    $DB_NAME = 'test';

    $cfg->set_model_directory('.');
    $cfg->set_connections(
        array(
            'development' => 'mysql://' . $DB_USER . ':' . $DB_PASS . '@' . $DB_HOST . '/' . $DB_NAME,
            'test' => 'mysql://' . $DB_USER . ':' . $DB_PASS . '@' . $DB_HOST . '/' . $DB_NAME,
            'production' => 'mysql://' . $DB_USER . ':' . $DB_PASS . '@' . $DB_HOST . '/' . $DB_NAME,
        )
    );
});

//TODO: move to controller
function getIP($ip)
{
    try {
        $res = IP::find($ip)->to_array();
        return $res;
    } catch (Exception $e) {
        $token = 'f3c21a996405b8'; //TODO: move to .env
        //TODO: initiate client with app
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://ipinfo.io/' . $ip . '?token=' . $token);
        if ($res->getStatusCode() == 200) { //TODO: handle another status
            $data = json_decode($res->getBody(), true);
            if (array_key_exists('city', $data)) {
                $ar = new IP();
                $ar->ip = $ip;
                $ar->country = $data['country'];
                $ar->city = $data['city'];
                $ar->save();
                return array('ip' => $ip, 'city' => $data['city'], 'country' => $data['country']);
            }
        }
        return array('error' => 'Not found');
    }
}
