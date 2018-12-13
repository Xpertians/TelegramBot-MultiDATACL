<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * Admin "/whois" command
 */
class PatenteCommand extends UserCommand{
    
    protected $name             = 'patente';
    protected $description      = 'Busca informacion de una patente';
    protected $usage            = '/patente <ABCD00>';
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
            $text = 'Ingrese una patente valida: /patente <ABCD00>';
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
        
        $data   = array();
        $data['grant_type']     = $this->client_type;
        $data['client_id']      = $this->client_id;
        $data['client_secret']  = $this->client_secret;
        
        curl_setopt($ch, CURLOPT_URL, "https://opendatacollector.com/api/token/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $rst                    = curl_exec($ch);
        curl_close($ch);
        return $rst;
    }
}
