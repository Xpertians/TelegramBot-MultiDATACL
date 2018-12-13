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

//Load Config
require 'config.php';
require 'awscfg.php';

//Load composer
require __DIR__ . '/vendor/autoload.php';

$commands_paths = [
    __DIR__ . '/Commands',
];

try {
    $telegram = new Longman\TelegramBot\Telegram(CFG['telegram']['apikey'], CFG['telegram']['username']);
    if(array_key_exists('admins',CFG['telegram'])){
        if(is_array(CFG['telegram']['admins'])){
            if(count(CFG['telegram']['admins'])==1){
                CFG['telegram']['admins']   = reset(CFG['telegram']['admins']);
            }
        }
        if(strstr(CFG['telegram']['admins'],"|")){
            $telegram->enableAdmins(explode('|',CFG['telegram']['admins']));
        }elseif(trim(CFG['telegram']['admins'])!=""){
            $telegram->enableAdmin(CFG['telegram']['admins']);
        }
    }
    $telegram->addCommandsPaths($commands_paths);
    $telegram->handle();
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}