<?php
/**
 * README
 * This file is intended to unset the webhook.
 * Uncommented parameters must be filled
 */

// Load composer
require __DIR__ . '/vendor/autoload.php';

// Add you bot's API key and name
$bot_api_key  = '785904207:AAFDR2V8Y-M25Aqx7bRjvxrj0ROPGA65u8I';
$bot_username = 'multidatacl_bot';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Delete webhook
    $result = $telegram->deleteWebhook();

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}
