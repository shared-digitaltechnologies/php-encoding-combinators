<?php

namespace Shrd\EncodingCombinators\Strings;

use Exceptions\DecodeErrorException;

abstract class Base64Url
{
    public static function encode(string $value): string
    {
        return strtr(base64_encode($value), '+/', '-_');
    }

    public static function encodeNoPadding(string $value): string
    {
        return str_replace('=', '', self::encode($value));
    }

    /**
     * @throws DecodeErrorException
     */
    public static function decode(string $value, bool $strict = false): string
    {
        error_clear_last();
        $result = base64_decode(strtr($value, '-_', '+/'), $strict);
        if($result === false) {
            throw DecodeErrorException::createFromPhpError('base64url');
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
        $result = base64_decode(strtr($value, '-_', '+/'), $strict);
        if(!$result) return null;
        return $result;
    }

    public static function tryDecodeNoPadding(string $value, bool $strict = false): string
    {
        return self::tryDecode($value, $strict);
    }

    public static function fromNormalBase64(string $value, bool $padding = true): string
    {
        $value = strtr($value, '+/', '-_');
        if($padding) return $value;
        return str_replace('=', '', $value);
    }

    public static function toNormalBase64(string $value): string
    {
        return strtr($value, '-_', '+/');
    }
}
