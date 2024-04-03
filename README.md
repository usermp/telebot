# Telebot

Telebot is a PHP library for interacting with the Telegram Bot API. It provides methods to perform various actions such as sending messages, photos, videos, documents, etc., and also handling webhooks and getting updates from Telegram.

## Installation

You can install Telebot via Composer. Run the following command in your terminal:

bashCopy code

`composer require usermp/telebot`

## Usage

First, you need to create an instance of the `Telebot` class by providing your Telegram Bot token:

```php
use Telebot\Telebot;
$token = 'YOUR_TELEGRAM_BOT_TOKEN';
$telebot = new Telebot($token);
```

### Setting Webhook

You can set up a webhook URL for your bot to receive updates. Use the `setWebhook` method:

```php
$webhookUrl = 'YOUR_WEBHOOK_URL'; 
$response   = $telebot->setWebhook($webhookUrl);
```

### Sending Messages

You can send messages to a chat using the `sendMessage` method:

```php
$chatId   = 'CHAT_ID'; 
$text     = 'Hello, world!'; 
$response = $telebot->sendMessage($chatId, $text);
```
### Handling Updates

You can get updates from Telegram using the `getUpdates` method:

```php
$updates = $telebot->getUpdates();
```

### Other Actions

Telebot provides various methods for different actions such as sending photos, audio, documents, videos, locations, contacts, etc. Refer to the source code or documentation for the complete list of available methods.

## Contributing

Contributions are welcome! Feel free to open issues or pull requests.
