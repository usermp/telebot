<?php

namespace Telebot;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Telebot
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * Telebot constructor.
     *
     * @param string $token
     * @param string $base_url
     * @param int $timeout
     */
    public function __construct(string $token, string $base_url = "https://api.telegram.org/bot", int $timeout = 5)
    {
        $this->client = new Client([
            "base_uri" => $base_url . $token . "/",
            'timeout'  => $timeout,
        ]);
    }

    /**
     * @param string $url
     * @return array
     */
    public function setWebhook(string $url): array
    {
        $payload = [
            'query' => [
                'url'      => $url,
            ]
        ];
        return $this->executeRequest('setWebhook', $payload, "get");
    }

    /**
     * Send a message.
     *
     * @param string $chat_id
     * @param string $text
     * @param array|null $reply_markup
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendMessage(string $chat_id, string $text, ?array $reply_markup = null, ?int $reply_to_message_id = null): array
    {
        $payload =  [
            "json" => [
                'chat_id'             => $chat_id,
                'text'                => $text,
                'reply_to_message_id' => $reply_to_message_id,
                'reply_markup'        => $reply_markup ? json_encode($reply_markup) : null,
            ]
        ];
        return $this->executeRequest('sendMessage', $payload);
    }

    /**
     * Edit a message.
     *
     * @param string $chat_id
     * @param int $message_id
     * @param string $text
     * @param array|null $reply_markup
     * @return array
     */
    public function editMessageText(string $chat_id, int $message_id, string $text, ?array $reply_markup = null): array
    {
        $payload = [
            'json' => [
                'chat_id'      => $chat_id,
                'message_id'   => $message_id,
                'text'         => $text,
                'reply_markup' => $reply_markup,
            ]
        ];
        return $this->executeRequest('editMessageText', $payload);
    }

    /**
     * Delete a message.
     *
     * @param object $chat_id
     * @param int $message_id
     * @return array
     */
    public function deleteMessage(object $chat_id, int $message_id): array
    {
        $sendMessage = [
            'query' => [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
            ],
        ];
        return $this->executeRequest('deleteMessage', $sendMessage, "get");
    }

    /**
     * Execute request to Telegram API.
     *
     * @param string $uri
     * @param array $payload
     * @param string $method
     * @return array
     */
    private function executeRequest(string $uri, array $payload, string $method = "post"): array
    {
        try {
            $response = $this->client->{$method}($uri, $payload);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            file_put_contents("error.log", $exception->getMessage() . PHP_EOL, FILE_APPEND);
            return [];
        }
    }
}
