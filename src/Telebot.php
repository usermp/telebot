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
     * set webhook.
     *
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
                'reply_markup'        => $this->reply_markup($reply_markup),
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
                'reply_markup' => $this->reply_markup($reply_markup),
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
        $payload = [
            'query' => [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
            ],
        ];
        return $this->executeRequest('deleteMessage', $payload, "get");
    }

    /**
     * Get updates.
     *
     * @return array
     */
    public function getUpdates(): array
    {
        return $this->executeRequest('getUpdates');
    }

    /**
     * Get me.
     *
     * @return array
     */
    public function getMe(): array
    {
        return $this->executeRequest('getme');
    }

    /**
     * Send a photo.
     *
     * @param string $chat_id
     * @param string $photo
     * @param string|null $caption
     * @param array|null $reply_markup
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendPhoto(string $chat_id, string $photo, string $caption = null, ?array $reply_markup = null, int $reply_to_message_id = null): array
    {
        $payload = [
            'json' => [
                'chat_id'             => $chat_id,
                'photo'               => $photo,
                'caption'             => $caption,
                'reply_to_message_id' => $reply_to_message_id,
                'reply_markup'        => $this->reply_markup($reply_markup),
            ]
        ];
        return $this->executeRequest('sendPhoto', $payload);
    }

    /**
     * Send a audio.
     *
     * @param string $chat_id
     * @param string $audio
     * @param string|null $caption
     * @param int $duration
     * @param string|null $title
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendAudio(string $chat_id, string $audio, string $caption = null, int $duration = 0, string $title = null, int $reply_to_message_id = null): array
    {
        $payload = [
            'json' => [
                'chat_id'             => $chat_id,
                'audio'               => $audio,
                'caption'             => $caption,
                'duration'            => $duration,
                'title'               => $title,
                'reply_to_message_id' => $reply_to_message_id,
            ]
        ];
        return $this->executeRequest('sendAudio', $payload);
    }

    /**
     * Send a document.
     *
     * @param string $chat_id
     * @param string $document
     * @param string|null $caption
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendDocument(string $chat_id, string $document, string $caption = null, int $reply_to_message_id = null): array
    {
        $payload = [
            'json' => [
                'chat_id'             => $chat_id,
                'document'            => $document,
                'caption'             => $caption,
                'reply_to_message_id' => $reply_to_message_id,
            ]
        ];
        return $this->executeRequest('sendDocument', $payload);
    }

    /**
     * Send a video.
     *
     * @param string $chat_id
     * @param string $video
     * @param int|null $duration
     * @param int|null $width
     * @param int|null $height
     * @param string|null $caption
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendVideo(string $chat_id, string $video, int $duration = null, int $width = null, int $height = null, string $caption = null, int $reply_to_message_id = null): array
    {
        $payload = [
            'json' => [
                'chat_id'             => $chat_id,
                'video'               => $video,
                'duration'            => $duration,
                'width'               => $width,
                'height'              => $height,
                'caption'             => $caption,
                'reply_to_message_id' => $reply_to_message_id,
            ]
        ];
        return $this->executeRequest('sendVideo', $payload);
    }

    /**
     * Send a voice.
     *
     * @param string $chat_id
     * @param string $voice
     * @param int|null $duration
     * @param string|null $caption
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendVoice(string $chat_id, string $voice, int $duration = null, string $caption = null, int $reply_to_message_id = null): array
    {
        $payload = [
            'json' => [
                'chat_id'             => $chat_id,
                'voice'               => $voice,
                'duration'            => $duration,
                'caption'             => $caption,
                'reply_to_message_id' => $reply_to_message_id,
            ]
        ];
        return $this->executeRequest('sendVoice', $payload);
    }

    /**
     * Sens a location.
     *
     * @param string $chat_id
     * @param int $latitude
     * @param int $longitude
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendLocation(string $chat_id, int $latitude, int $longitude, int $reply_to_message_id = null): array
    {
        $payload = [
            'json' => [
                'chat_id'             => $chat_id,
                'latitude'            => $latitude,
                'longitude'           => $longitude,
                'reply_to_message_id' => $reply_to_message_id,
            ]
        ];
        return $this->executeRequest('sendLocation', $payload);
    }

    /**
     * Send a contact.
     *
     * @param string $chat_id
     * @param string $phone_number
     * @param string $first_name
     * @param string|null $last_name
     * @param int|null $reply_to_message_id
     * @return array
     */
    public function sendContact(string $chat_id, string $phone_number, string $first_name, string $last_name = null, int $reply_to_message_id = null): array
    {
        $payload = [
            'json' => [
                'chat_id'             => $chat_id,
                'phone_number'        => $phone_number,
                'first_name'          => $first_name,
                'last_name'           => $last_name,
                'reply_to_message_id' => $reply_to_message_id,
            ]
        ];
        return $this->executeRequest('sendContact', $payload);
    }

    /**
     * Get File.
     *
     * @param string $file_id
     * @return array
     */
    public function getFile(string $file_id): array
    {
        $payload = [
            'query' => [
                'file_id' => $file_id,
            ]
        ];
        return $this->executeRequest('getFile', $payload, "get");
    }

    /**
     * Get chat.
     *
     * @param string $chat_id
     * @return array
     */
    public function getChat(string $chat_id): array
    {
        $payload = [
            'query' => [
                'chat_id' => $chat_id,
            ]
        ];
        return $this->executeRequest('getChat', $payload, "get");
    }

    /**
     * Get chat members count.
     *
     * @param string $chat_id
     * @return array
     */
    public function getChatMembersCount(string $chat_id): array
    {
        $payload = [
            'query' => [
                'chat_id' => $chat_id,
            ]
        ];
        return $this->executeRequest('getChatMembersCount', $payload, "get");
    }

    /**
     * Get chat member.
     *
     * @param string $chat_id
     * @return array
     */
    public function getChatMember(string $chat_id): array
    {
        $payload = [
            'query' => [
                'chat_id' => $chat_id,
            ]
        ];
        return $this->executeRequest('getChatMember', $payload, "get");
    }

    /**
     * Get chat administrators.
     *
     * @param string $chat_id
     * @return array
     */
    public function getChatAdministrators(string $chat_id): array
    {
        $payload = [
            'query' => [
                'chat_id' => $chat_id,
            ]
        ];
        return $this->executeRequest('getChatAdministrators', $payload, "get");
    }


    /**
     * Execute request to Telegram API.
     *
     * @param string $uri
     * @param array|null $payload
     * @param string $method
     * @return array
     */
    private function executeRequest(string $uri, ?array $payload = null, string $method = "post"): array
    {
        try {
            $response = $this->client->{$method}($uri, $payload);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            file_put_contents("error.log", $exception->getMessage() . PHP_EOL, FILE_APPEND);
            return [];
        }
    }

    /**
     * @param $replay_markup
     * @return false|mixed|string
     */
    private function reply_markup($replay_markup): mixed
    {
        if (is_array($replay_markup)) {
            $replay_markup = json_encode($replay_markup);
        }
        return $replay_markup;
    }
}
