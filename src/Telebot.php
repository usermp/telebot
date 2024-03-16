<?php

namespace Telebot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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

    /**
     * @param string $chat_id
     * @param string $text
     * @param array|null $reply_markup
     * @param int|null $reply_to_message_id
     * @return array
     * @throws GuzzleException
     */
    public function sendMessage(string $chat_id, string $text, array $reply_markup = null, int $reply_to_message_id = null): array
    {
        $uri = "sendMessage";
        $data = [
            'json' => [
                'chat_id' => $chat_id,
                'text' => $text,
                'reply_to_message_id' => $reply_to_message_id,
            ]
        ];

        if ($reply_markup)
            $data['json']['reply_markup'] = json_encode($reply_markup);

        try {
            $sendMessage = $this->client->post($uri, $data);
            return json_decode($sendMessage->getBody(), true);
        } catch (\Exception $exception) {
            file_put_contents("error.log",$exception->getMessage());
        }
        return [];
    }
}

