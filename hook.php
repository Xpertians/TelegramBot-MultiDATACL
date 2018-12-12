<?php
require __DIR__ . '/vendor/autoload.php';

$bot_api_key  = '785904207:AAFDR2V8Y-M25Aqx7bRjvxrj0ROPGA65u8I';
$bot_username = 'multidatacl_bot';

try {
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
    $telegram->enableAdmin(61259010);
    $telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // Silence is golden!
    // log telegram errors
    // echo $e->getMessage();
}