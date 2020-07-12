<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class DecryptController extends Controller
{
    public function decrypt(Request $request)
    {
        $alphavit = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789<>'; //мой 64-х символьный алфавит
        $alphavitHaff = [ //таблица Хаффмана
            'e' => '011',
            't' => '001',
            'a' => '1111',
            'i' => '1110',
            'n' => '1100',
            'r' => '1011',
            's' => '1001',
            'o' => '1000',
            'h' => '0100',
            'd' => '11011',
            'l' => '10101',
            'c' => '01011',
            'f' => '01010',
            'u' => '00011',
            'm' => '00010',
            'g' => '000000',
            'p' => '110101',
            'w' => '110100',
            'b' => '101001',
            'y' => '101000',
            'v' => '000011',
            'k' => '0000100',
            'x' => '000010111',
            'q' => '000010110',
            'j' => '000010101',
            'z' => '000010100'
        ];

        $url = $request->url;
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $queryArray);
        $queryArray = $this->decryptUrl($queryArray, $alphavit);
        $queryArray = $this->decodeHaff($queryArray, $alphavit, $alphavitHaff);
        return $this->build_url($urlParts, $queryArray);
    }

    public function decodeHaff($queryArray, $alphavit, $alphavitHaff)
    {
        $decodedArray = [];
        foreach ($queryArray as $key => $query) {
            $decode = '';
            for ($i = 0; $i < strlen($key); $i++) { //перебираем значение
                $lenKey = strlen(decbin(strpos($alphavit, $key[$i])));
                if ($lenKey < 6) {
                    do {            //дополняем каждую строку до 6-и символов нулями в начале, если она короче
                        $decode .= '0';
                        $lenKey++;
                    } while ($lenKey < 6);
                }
                $decode .= decbin(strpos($alphavit, $key[$i]));
            }
            $j = 0;
            $decodeKey = '';
            for ($i = 0; $i < strlen($decode); $i++) {
                if (in_array(substr($decode, $j, $i - $j), $alphavitHaff, true)) {
                    $decodeKey .= array_search(substr($decode, $j, $i - $j), $alphavitHaff, true);
                    $j = $i;
                }
            }
            $decodedArray[$decodeKey] = $query;
        }
        return $decodedArray;
    }

    public function decryptUrl($queryArray, $alphavit)
    {
        $encryptedArray = [];//шифр Цезаря. выбирается первый символ из строки, по его индексу обратный сдвиг для расшифровки
        foreach ($queryArray as $key => $query) {
            $cryptoKey = $key[0];
            $cryptoKeyPos = strpos($alphavit, $cryptoKey);
            $encryptedKey = '';
            for ($i = 1; $i < strlen($key); $i++) {
                $encryptedKey .= $alphavit[(64 + strpos($alphavit, $key[$i]) - $cryptoKeyPos) % 64];
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
