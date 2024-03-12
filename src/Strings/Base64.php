<?php

namespace Shrd\EncodingCombinators\Strings;

use Exceptions\DecodeErrorException;

abstract class Base64
{
    public static function encode(string $value): string
    {
        return base64_encode($value);
    }

    public static function encodeNoPadding(string $value): string
    {
        return str_replace('=', '', base64_encode($value));
    }

    /**
     * @throws DecodeErrorException
     */
    public static function decode(string $value, bool $strict = false): string
    {
        error_clear_last();
        $result = base64_decode($value, $strict);
        if($result === false) {
            throw DecodeErrorException::createFromPhpError('base64');
        }
        return $result;
    }

    /**
     * @throws DecodeErrorException
     */
    public static function decodeNoPadding(string $value, bool $strict = false): string
    {
        return self::decode($value, $strict);
    }

    public static function tryDecode(string $value, bool $strict = false): ?string
    {
        $result = base64_decode($value, $strict);
        if(!$result) return null;
        return $result;
    }

    public static function tryDecodeNoPadding(string $value, bool $strict = false): string
    {
        return self::tryDecode($value, $strict);
    }
}
