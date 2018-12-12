<?php
// Load composer
require __DIR__ . '/vendor/autoload.php';

$bot_api_key  = '785904207:AAFDR2V8Y-M25Aqx7bRjvxrj0ROPGA65u8I';
$bot_username = 'multidatacl_bot';
$hook_url     = 'https://telegram.opendatacollector.com/hook.php';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Set webhook
    //$result = $telegram->setWebhook($hook_url);
    $result = $telegram->setWebhook($hook_url, './cert.pem');
    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    // echo $e->getMessage();
}