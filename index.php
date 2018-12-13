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

if(array_key_exists('admins',CFG['telegram'])){
    if(is_array(CFG['telegram']['admins'])){
      var_dump(CFG['telegram']['admins']);
    }else{
      echo CFG['telegram']['admins'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TelegramBot MultiDATACL</title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/css/cover.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Principal</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="/">Home</a></li>
                  <li><a href="http://opendatacollector.com" target="_blank">APIs</a></li>
                  <li><a href="https://github.com/Xpertians/TelegramBot-MultiDATACL/issues/new" target="_blank">Soporte</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">TelegramBot MultiDATACL</h1>
            <p class="lead">Es un proyecto abierto desarrollado para el equipo de SEBV por Xpertians.<br> Le invitamos a contribuir activamente a nuestro proyecto en GitHub.</p>
            <p class="lead">
              <a href="https://github.com/Xpertians/TelegramBot-MultiDATACL" class="btn btn-lg btn-default" target="_blank">Ver en GitHub</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Powered by <a href="http://opendatacollector.com" target="_blank">opendatacollector</a>, by <a href="https://xpertians.com" target="_blank">Xpertians</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
