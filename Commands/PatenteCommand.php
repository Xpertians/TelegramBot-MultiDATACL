<?php
namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

/**
 * Admin "/whois" command
 */
class PatenteCommand extends UserCommand{
    
    protected $name = 'patente';
    protected $description = 'Busca informacion de una patente';
    protected $usage = '/patente <ABCD00>';
    protected $version = '1.1.0';
    
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
            $text = 'La patente es valida';
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
}
