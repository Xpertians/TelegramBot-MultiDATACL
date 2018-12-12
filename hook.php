<?php
// Load composer
require __DIR__ . '/vendor/autoload.php';

$bot_api_key  = '785904207:AAFDR2V8Y-M25Aqx7bRjvxrj0ROPGA65u8I';
$bot_username = 'multidatacl_bot';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Handle telegram webhook request
    $telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    // log telegram errors
    // echo $e->getMessage();
}