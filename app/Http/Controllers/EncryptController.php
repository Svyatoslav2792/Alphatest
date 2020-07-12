<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class EncryptController extends Controller
{

    public function encrypt(Request $request)
    {
        $alphavit = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789<>'; //мой 64-х символьный алфавит
        $alphavitHaff=[ //таблица Хаффмана
            'e'=>'011',
            't'=>'001',
            'a'=>'1111',
            'i'=>'1110',
            'n'=>'1100',
            'r'=>'1011',
            's'=>'1001',
            'o'=>'1000',
            'h'=>'0100',
            'd'=>'11011',
            'l'=>'10101',
            'c'=>'01011',
            'f'=>'01010',
            'u'=>'00011',
            'm'=>'00010',
            'g'=>'000000',
            'p'=>'110101',
            'w'=>'110100',
            'b'=>'101001',
            'y'=>'101000',
            'v'=>'000011',
            'k'=>'0000100',
            'x'=>'000010111',
            'q'=>'000010110',
            'j'=>'000010101',
            'z'=>'000010100'
        ];
        $url = $request->url;
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $queryArray);
        $queryArray = $this->encodeHaff($queryArray, $alphavit, $alphavitHaff);
        $queryArray = $this->encryptUrl($queryArray, $alphavit);
        $encryptedUrl=$this->build_url($urlParts, $queryArray);

        return $encryptedUrl;
    }
    public function encryptUrl($queryArray, $alphavit)
    {
        $encryptedArray = [];//шифр Цезаря. выбирается один случайный символ из алфавита, по его индексу сдвиг,
                             // и он же помещается в начало строки
        foreach ($queryArray as $key => $query) {
            $cryptoKey = $alphavit[random_int(0, 63)];
            $cryptoKeyPos = strpos($alphavit, $cryptoKey);
            for ($i = 0; $i < strlen($key); $i++) {
                $key[$i] = $alphavit[(strpos($alphavit, $key[$i]) + $cryptoKeyPos) % 64];
            }
            $encryptedArray[$cryptoKey . $key] = $query;
        }
        return $encryptedArray;
    }

    public function encodeHaff($queryArray, $alphavit, $alphavitHaff)
    {
        $encodedArray = [];
        foreach ($queryArray as $key => $query) {
            $code = '';
            for ($i = 0; $i < strlen($key); $i++) { //перебираем значение
                $code .=$alphavitHaff[$key[$i]];    //пишем полученный код в строку
            }
            $lenCode = 6-strlen($code) % 6; //проверяем кратность деления на 6(это количество бит для кодирования моим алфавитом),
                                            // если не кратно- дополняем
            if ($lenCode > 0) {
                do {
                    $code .= '0';
                    $lenCode--;
                } while ($lenCode > 0);
            }
            $lenCode = strlen($code);
            $encodeKey = '';
            for ($i = 0; $i < $lenCode; $i += 6) {
                $encodeKey .= $alphavit[bindec(substr($code, $i, 6))];
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
