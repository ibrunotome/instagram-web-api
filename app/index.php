<?php

require '../vendor/autoload.php';

$data = [
    'username' => '',
    'password' => ''
];

$instagram = new \App\Web\Instagram($data);

$instagram->account->login();