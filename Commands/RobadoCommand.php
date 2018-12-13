<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * Admin "/whois" command
 */
class RobadoCommand extends UserCommand{
    
    protected $name             = 'robado';
    protected $description      = 'Verifica si una patente presenta encargo por robo';
    protected $usage            = '/robado <ABCD00>';
    protected $version          = '1.1.0';
    
    protected $client_type      = "client_credentials";
    protected $client_id        = "FQyDaVCyTOvCOHRSN5TeR8";
    protected $client_secret    = "bZhlyXsAuzm9oyb5b4DAx817vbJXdKW5";
    protected $token            = "";
    protected $agent            = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.112 Safari/534.30";
    
    public function execute(){
    
        $message    = $this->getMessage();
        
        $chat_id    = $message->getChat()->getId();
        $command    = $message->getCommand();
        $text       = trim($message->getText(true));
        
        $data       = [ 'chat_id' => $chat_id ];
        
        if ($text === '') {
            $text = 'Ingrese una patente valida: /robado <ABCD00>';
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
            curl_setopt($ch, CURLOPT_URL, "https://opendatacollector.com/api/exec/1541878145/".trim($plateStr));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=".$rst['access_token']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $rst                    = json_decode(curl_exec($ch), 1);
            if(array_key_exists('data', $rst)){
                $rst['data']    = reset($rst['data']);
                if(array_key_exists('payload', $rst['data'])){
                    if(array_key_exists('stolen', $rst['data']['payload'])){
                        $rst    = "PATENTE: ".trim($plateStr)." - ESTADO:".$rst['data']['payload']['stolen'];
                    }else{
                        $rst    = "ERR-1004: Error conectando a OpenDataCollector";
                    }
                }else{
                    $rst    = "ERR-1003: Error conectando a OpenDataCollector";
                }
            }else{
                $rst    = "ERR-1002: Error conectando a OpenDataCollector";
            }
        }else{
            $rst    = "ERR-1001: Error conectando a OpenDataCollector";
        }
        curl_close($ch);
        return $rst;
    }
}
