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
 
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * Admin "/whois" command
 */
class PatenteCommand extends UserCommand{
    
    protected $name             = 'patente';
    protected $description      = 'Busca informacion de una patente';
    protected $usage            = '/patente ABCD00';
    protected $version          = '1.1.0';
    
    protected $client_type      = "client_credentials";
    protected $client_id        = CFG['odc']['clientid'];
    protected $client_secret    = CFG['odc']['clientsecret'];
    protected $token            = "";
    protected $agent            = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.112 Safari/534.30";
    
    public function execute(){
    
        $message    = $this->getMessage();
        
        $chat_id    = $message->getChat()->getId();
        $command    = $message->getCommand();
        $text       = trim($message->getText(true));
        
        $data       = [ 'chat_id' => $chat_id ];
        
        if ($text === '') {
            $text = 'Ingrese una patente valida: /patente ABCD00';
        }elseif(!$this->isPlateValid($text)){
            $text = 'La patente '.preg_replace("/[^A-Za-z0-9 ]/", '',$text).' no es valida';
        } else {
            $text = $this->getPlateInfo($text);
        }
        
        $data['text'] = $text;
        
        return Request::sendMessage($data);
    }
    
    private function isPlateValid($plateStr){
        $patente  = "AB-12-34";
        $regex    = "/^[a-z]{2}[\.\- ]?[0-9]{2}[\.\- ]?[0-9]{2}|[b-d,f-h,j-l,p,r-t,v-z]{2}[\-\. ]?[b-d,f-h,j-l,p,r-t,v-z]{2}[\.\- ]?[0-9]{2}$/i";
        if (preg_match($regex, $plateStr)){
            return true;
        }else{
            return false;
        }
    }
    
    private function getPlateInfo($plateStr){
        
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        
        //Get Token
        $data   = array();
        $data['grant_type']     = $this->client_type;
        $data['client_id']      = $this->client_id;
        $data['client_secret']  = $this->client_secret;
        curl_setopt($ch, CURLOPT_URL, "https://opendatacollector.com/api/token/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $rst                    = json_decode(curl_exec($ch), 1);
        if(array_key_exists('access_token', $rst)){
            //GetPlate Info
            curl_setopt($ch, CURLOPT_URL, "https://opendatacollector.com/api/exec/1542849342/".trim($plateStr));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=".$rst['access_token']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $rst                    = curl_exec($ch);
            $rst                    = json_decode(curl_exec($ch), 1);
            if(array_key_exists('data', $rst)){
                $rst['data']    = reset($rst['data']);
                if(array_key_exists('payload', $rst['data'])){
                    $trans  = array(
                        'plate'     => "PATENTE",
                        'year'      => "ANO",
                        'nmotor'    => "MOTOR",
                        'vin'       => "VIN",
                        'brand'     => "MARCA",
                        'model'     => "MODELO",
                        'color'     => "COLOR",
                        'class'     => "TIPO",
                        'stolen'    => "ROBADO",
                        'related'   => "PROPIETARIOS"
                        );
                    $rsp    = "Resultados:"."\r\n";
                    if(is_array( $rst['data']['payload'] )){
                        foreach($rst['data']['payload'] AS $key=>$value){
                            if(is_array($value)){
                                $rsp    .= $key.": ".count($value);
                            }else{
                                $rsp    .= $key.": ".$value;
                            }
                        }
                    }
                    $rsp    .= "================="."\r\n";
                    $rst    = $rsp;
                }else{
                    $rst    = "ERR-1003: Respuesta sin Payload";
                }
            }else{
                $rst    = "ERR-1002: Respuesta sin datos";
            }
        }else{
            $rst    = "ERR-1001: Error conectando a OpenDataCollector";
        }
        curl_close($ch);
        return $rst;
    }
}
