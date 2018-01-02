<?php

require '../vendor/autoload.php';

$data = [
    'username' => '',
    'password' => ''
];

$instagram = new \App\Web\InstagramWeb($data);

$instagram->login();