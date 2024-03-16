<?php

namespace Telebot;

use GuzzleHttp\Client;

class Telebot
{
    private Client $client;
    public function __construct(string $token,string $base_url = "https://api.telegram.org/bot", int $timeout = 5)
    {
        $this->client = new Client([
            "base_uri" => $base_url . $token . "/",
            'timeout'  => $timeout,
        ]);
    }
}