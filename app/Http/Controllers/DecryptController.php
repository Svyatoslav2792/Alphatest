<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DecryptController extends Controller
{
    public function decrypt(Request $request)
    {
        $alphavit = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $url = utf8_decode($request->url);
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $queryArray);
        $queryArray = $this->decodeUrl($queryArray, $alphavit);
        $queryArray = $this->decryptUrl($queryArray, $alphavit);
        return $this->build_url($urlParts, $queryArray);
    }

    public function decodeUrl($queryArray, $alphavit)
    {
        $decodedArray = [];
        $x = 0;
        foreach ($queryArray as $key => $query) {
            $x++;
//            if($x==7){break;}
            $decode = '';
            for ($i = 0; $i < strlen($key); $i++) { //перебираем значение
                $lenKey = strlen(strval(decbin(ord($key[$i]))));
                if ($lenKey < 8) {
                    do {            //дополняем каждую строку до 8-и символов нулями в начале, если она короче
                        $decode .= '0';
                        $lenKey++;
                    } while ($lenKey < 8);
                }
                $decode .= strval(decbin(ord($key[$i]))); //пишем полученный код в строку
            }
            $lenCode = strlen($decode);
            $lenCode = $lenCode - $lenCode % 6;
            $decodeKey = '';
            for ($i = 0; $i < $lenCode; $i += 6) {
                $decodeKey .= @$alphavit[bindec(substr($decode, $i, 6))];
            }
            $decodedArray[utf8_encode($decodeKey)] = $query;
        }

        return ($decodedArray);
    }

    public function decryptUrl($queryArray, $alphavit)
    {
        $encryptedArray = [];//шифр Цезаря. выбирается первый символ из строки, по его индексу обратный сдвиг для расшифровки
        foreach ($queryArray as $key => $query) {
            $cryptoKey = $key[0];
            $cryptoKeyPos = strpos($alphavit, $cryptoKey);
            $encryptedKey = '';
            for ($i = 1; $i < strlen($key); $i++) {
                $encryptedKey .= $alphavit[(62 + strpos($alphavit, $key[$i]) - $cryptoKeyPos) % 62];
            }
            $encryptedArray[$encryptedKey] = $query;
        }
        return $encryptedArray;
    }

    public function build_url($urlParts, $queryArray)//собираем урл обратно
    {
        $url = $urlParts['scheme'] . '://' . $urlParts['host'] . '?';
        foreach ($queryArray as $key => $query) {
            if (!(next($queryArray))) {
                $url .= $key . '=' . $query;
            } else {
                $url .= $key . '=' . $query . '&';
            }
        }
        return $url;
    }
}
