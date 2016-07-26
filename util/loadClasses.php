<?php

    function classLoader($class)
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT']."novodesafio/dao/".$class.".php")){
          include $_SERVER['DOCUMENT_ROOT']."novodesafio/dao/".$class.".php";
        }
    }
    spl_autoload_register('classLoader');