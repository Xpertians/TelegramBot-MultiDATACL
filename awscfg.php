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
 
//Dynamic CFG
$strKey =   "tbmultidatacl_";

foreach($_SERVER as $sKey=>$sValue){
  if(strstr(strtolower($sKey), $strKey)){
    $arrCfgKey  = explode('_',str_replace($strKey,'',strtolower($sKey)));
    switch(count($arrCfgKey)){
      case 1:
        $cfg[$arrCfgKey[0]]                                = $sValue;
      break;
      case 2:
        $cfg[$arrCfgKey[0]][$arrCfgKey[1]]                 = $sValue;
      break;
      case 3:
        $cfg[$arrCfgKey[0]][$arrCfgKey[1]][$arrCfgKey[2]]  = $sValue;
      break;
    }
  }
}

define("CFG", $cfg);