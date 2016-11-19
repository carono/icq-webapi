<?php


namespace carono\components;

class Icq extends IcqCore
{
    const URL_SEND = 'https://api.icq.net/im/sendIM';
    const URL_CONNECT = 'https://icq.com/siteim/icqbar/php/proxy_jsonp_connect.php';

    public function login($login, $password)
    {
        $post = [
            'username' => $login,
            'password' => $password,
            'language' => 'ru',
            'time'     => time(),
            'remember' => 1,
        ];
        $res = $this->request('POST', self::URL_CONNECT, $post);
        $answer = json_decode($res->getBody(), true);
        $this->sessionKey = $answer['sessionKey'];
        $this->k = $answer['k'];
        $this->a = $answer['a'];
        $this->startSession();
    }

    public function send($uin, $message)
    {
        $data = [
            "aimsid"  => $this->aimsid,
            "c"       => $this->c,
            "f"       => $this->f,
            "message" => $message,
            "t"       => $uin
        ];
        $this->request('GET', self::URL_SEND, $data);
    }
}