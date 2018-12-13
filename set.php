<?php
/**
 * Copyright (C) 2018 Oscar Valenzuela B. (oscar.valenzuela.b_AT_gmail.com)
 *
 * This file is part of TelegramBot-MultiDATACL a.k.a TBMultiDATACL.
 * TBMultiDATACL is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * TBMultiDATACL is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TBMultiDATACL. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author   Oscar Valenzuela B. <oscar.valenzuela.b_AT_gmail.com>
 * @access   public
 */
 
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';
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