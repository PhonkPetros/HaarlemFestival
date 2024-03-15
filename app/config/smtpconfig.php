<?php

namespace smtpconfig;

class smtpconfig{
    public function getConfiguration(){
        return [
            'smtp' => [
                'host' => 'smtp.gmail.com',
                'auth' => true,
                'username' => 'protata93@gmail.com',
                'password' => 'xhno spiv iump ltna',
                'secure' => 'ssl',
                'port' => 465,
            ],
        ];
    }
}
