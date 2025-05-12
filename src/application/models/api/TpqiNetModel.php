<?php
class TpqiNetModel extends CI_MODEL
{
    public function __construct()
    {
        parent::__construct();

    }

    public function auth()
    {
        $post = array("ClientID" => "5fe8a60e76970",
            "ClientSecret" => "c1fd0ce9c7d24f480fadeada8eb10d22");
        header('Content-Type: application/json');
        $ch = curl_init('http://147.50.138.201/tpqi_net63/public/web_api/v1/auth');
        $post = json_encode($post);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public function member_session($session_id)
    {
        $auth_data = $this->auth();
        $token = $auth_data->token;
        $post = array(
            "session_id" => $session_id,
            "user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0",
        );
        $ch = curl_init('http://147.50.138.201/tpqi_net63/public/web_api/v1/member_session');
        $post = json_encode($post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token: ' . $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public function member_role($citizenID)
    {
        $auth_data = $this->auth();
        $token = $auth_data->token;
        $ch = curl_init('http://147.50.138.201/tpqi_net63/public/web_api/v1/member_role/' . $citizenID);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token: ' . $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public function member_login($email, $password)
    {
        $auth_data = $this->auth();
        $token = $auth_data->token;
        $post = array(
            "email" => $email,
            "password" => $password,
        );
        $ch = curl_init('http://147.50.138.201/tpqi_net63/public/web_api/v1/member_login');
        $post = json_encode($post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'token: ' . $token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

}
