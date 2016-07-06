<?php

namespace App\Lib;

class MailProvider
{
    private $from;

    private $username;

    private $password;

    public function __construct($from, $username, $password)
    {
        $this->from = $from;
        $this->username = $username;
        $this->password = $password;
    }

    public function send($to)
    {
        echo '[MailProvider] send email from ' . $this->from . ' to ' . $to . ' use username:' . $this->username . ' and password:' . $this->password . '<br/><br/>';
    }
}
