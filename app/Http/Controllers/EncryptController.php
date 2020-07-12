<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DecryptController;

class EncryptController extends Controller
{

    public function encrypt(Request $request)
    {
        $alphavit = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $url = $request->url;
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $queryArray);
        $queryArray = $this->encryptUrl($queryArray, $alphavit);
        $queryArray = $this->encodeUrl($queryArray, $alphavit);
        $encryptedUrl=utf8_encode($this->build_url($urlParts, $queryArray));
        return $encryptedUrl;
    }


    public function encryptUrl($queryArray, $alphavit)
    {
        $encryptedArray = [];//шифр Цезаря. выбирается один случайный символ из алфавита, по его индексу сдвиг, и он же помещается в начало строки
        foreach ($queryArray as $key => $query) {
            $cryptoKey = $alphavit[random_int(0, 61)];
            $cryptoKeyPos = strpos($alphavit, $cryptoKey);
            for ($i = 0; $i < strlen($key); $i++) {
                $key[$i] = $alphavit[(strpos($alphavit, $key[$i]) + $cryptoKeyPos) % 62];
            }
            $encryptedArray[$cryptoKey . $key] = $query;
        }
        return $encryptedArray;
    }

    public function encodeUrl($queryArray, $alphavit)
    {
        $encodedArray = [];
        foreach ($queryArray as $key => $query) {
            $code = '';
            for ($i = 0; $i < strlen($key); $i++) { //перебираем значение
                $lenKey = strlen(strval(decbin(strpos($alphavit, $key[$i]))));//определяем длину кода для символа в соответствии с моим алфавитом
                if ($lenKey < 6) {
                    do {            //дополняем каждую строку до 6-ти символов нулями в начале, если она короче
                        $code .= '0';
                        $lenKey++;
                    } while ($lenKey < 6);
                }
                $code .= strval(decbin(strpos($alphavit, $key[$i]))); //пишем полученный код в строку
            }
            $lenCode = 8-strlen($code) % 8; //проверяем кратность деления на 8,
            // если не кратно- дополняем единицами в конце (в аски кодах 255 символов, поэтому 8 бит)
            if ($lenCode > 0) {
                do {
                    $code .= '1';
                    $lenCode--;
                } while ($lenCode > 0);
            }
            $lenCode = strlen($code);
            $encodeKey = '';
            for ($i = 0; $i < $lenCode; $i += 8) {
                $encodeKey .= chr(bindec(substr($code, $i, 8)));
            }
            $encodedArray[$encodeKey] = $query;

        }
        return ($encodedArray);
    }

    public function build_url($urlParts, $queryArray)//собираем урл обратно
    {
        $url = $urlParts['scheme'] . '://' . $urlParts['host'] . '?';
        foreach ($queryArray as $key => $query) {
            if(!(next($queryArray))){
                $url .= $key . '=' . $query;
            } else {$url .= $key . '=' . $query . '&';}
        }
        return $url;
    }



}
