<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class EncryptController extends Controller
{

    public function encrypt(Request $request)
    {
        $alphavit = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $alphArr = [
            'A' => 000000, 'B' => 000001, 'C' => 000010, 'D' => 000011, 'E' => 000100,
            'F' => 000101, 'G' => 000110, 'H' => 000111, 'I' => 001000, 'J' => 001001,
            'K' => 001010, 'L' => 001011, 'M' => 001100, 'N' => 001101, 'O' => 001110,
            'P' => 001111, 'Q' => 010000, 'R' => 010001, 'S' => 010010, 'T' => 010011,
            'U' => 010100, 'V' => 010101, 'W' => 010110, 'X' => 010111, 'Y' => 011000,
            'Z' => 011001, 'a' => 011010, 'b' => 011011, 'c' => 011100, 'd' => 011101,
            'e' => 011110, 'f' => 011111, 'g' => 100000, 'h' => 100001, 'i' => 100010,
            'j' => 100011, 'k' => 100100, 'l' => 100101, 'm' => 100110, 'n' => 100111,
            'o' => 101000, 'p' => 101001, 'q' => 101010, 'r' => 101011, 's' => 101100,
            't' => 101101, 'u' => 101110, 'v' => 101111, 'w' => 110000, 'x' => 110001,
            'y' => 110010, 'z' => 110011, '0' => 110100, '1' => 110101, '2' => 110110,
            '3' => 110111, '4' => 111000, '5' => 111001, '6' => 111010, '7' => 111011,
            '8' => 111100, '9' => 111101
        ];

        $url = $request->url;
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $queryArray);
        $queryArray = $this->encryptUrl($queryArray, $alphavit);
        $queryArray = $this->encodeUrl($queryArray, $alphavit);
        return $this->build_url($urlParts, $queryArray);

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
            $lenCode = strlen($code) % 8; //проверяем кратность деления на 8,
            // если не кратно- дополняем нулями в конце (в аски кодах 255 символов, поэтому 8 бит)
            if ($lenCode > 0) {
                do {
                    $code .= '0';
                    $lenCode--;
                } while ($lenCode > 0);
            }
            $lenCode = strlen($code);
            $encodeKey = '';
            for ($i = 0; $i <= $lenCode; $i += 8) {
                $encodeKey .= chr(bindec(substr($code, $i, $i + 8)));
//                ,decbin((ord($encodeKey))),$code)
            }
//            dd($encodeKey);
//            dd(substr($code,0,8), $code);
            $encodedArray[$encodeKey] = $query;
        }
        return $encodedArray;
    }

    public function build_url($urlParts, $queryArray)
    {
        $url = $urlParts['scheme'] . '://' . $urlParts['host'] . '?';
        foreach ($queryArray as $key => $query) {
            $url .= $key . '=' . $query . '&';
        }
        return $url;
    }

}
