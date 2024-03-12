<?php

namespace Shrd\EncodingCombinators\Strings;

use Exceptions\DecodeErrorException;

abstract class Hex
{
    public static function encode(string $value): string
    {
        return bin2hex($value);
    }

    /**
     * @throws DecodeErrorException
     */
    public static function decode(string $value): string
    {
        error_clear_last();
        $result = hex2bin($value);
        if($result === false) {
            throw DecodeErrorException::createFromPhpError('hex');
        }
        return $result;
    }

    public static function tryDecode(string $value): ?string
    {
        $result = hex2bin($value);
        if(!$result) return null;
        return $result;
    }
}
