<?php

namespace App\Lib;

class Shop
{

    private $mail = null;

    public function __construct(MailProvider $mail)
    {
        $this->mail = $mail;
    }

    public function buy($productName)
    {
        echo '[Shop] buy ' . $productName . '<br/><br/>';
        !is_null($this->mail) && $this->mail->send('DemoUser');
    }
}