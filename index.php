<?php

require_once __DIR__ . "/vendor/autoload.php";

$bot = new \Telebot\Telebot("token");
var_dump($bot->getMe());