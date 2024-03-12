<?php

namespace Shrd\EncodingCombinators\Strings\ConstantTime;

use Shrd\EncodingCombinators\Exceptions\WrappedEncodeException;
use SodiumException;

abstract class Hex
{
    public static function encode(string $value): string
    {
        try {
            return sodium_bin2hex($value);
        } catch (SodiumException $exception) {
            throw new WrappedEncodeException($exception);
        }
    }

    public static function decode(string $value, string $ignore = ''): string
    {
        try {
            return sodium_hex2bin($value, $ignore);
        } catch (SodiumException $exception) {
            throw new WrappedEncodeException($exception);
        }
    }

    public static function tryDecode(string $value, string $ignore = ''): ?string
    {
        try {
            return sodium_hex2bin($value, $ignore);
        } catch (SodiumException) {
            return null;
        }
    }
}
