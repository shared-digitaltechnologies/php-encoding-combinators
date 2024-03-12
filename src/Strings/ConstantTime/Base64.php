<?php

namespace Shrd\EncodingCombinators\Strings\ConstantTime;

use Shrd\EncodingCombinators\Exceptions\WrappedDecodeException;
use Shrd\EncodingCombinators\Exceptions\WrappedEncodeException;
use SodiumException;

abstract class Base64
{

    public static function encode(string $value): string
    {
        try {
            return sodium_bin2base64($value, SODIUM_BASE64_VARIANT_ORIGINAL);
        } catch (SodiumException $exception) {
            throw new WrappedEncodeException($exception);
        }
    }

    public static function encodeNoPadding(string $value): string
    {
        try {
            return sodium_bin2base64($value, SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING);
        } catch (SodiumException $exception) {
            throw new WrappedEncodeException($exception);
        }
    }

    /**
     * @throws WrappedDecodeException
     */
    public static function decode(string $value, string $ignore = ""): string
    {
        try {
            return sodium_base642bin($value, SODIUM_BASE64_VARIANT_ORIGINAL, $ignore);
        } catch (SodiumException $exception) {
            throw new WrappedDecodeException($exception);
        }
    }

    /**
     * @throws WrappedDecodeException
     */
    public static function decodeNoPadding(string $value, string $ignore = ""): string
    {
        try {
            return sodium_base642bin($value, SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING, $ignore);
        } catch (SodiumException $exception) {
            throw new WrappedDecodeException($exception);
        }
    }

    public static function tryDecode(string $value, string $ignore = ""): ?string
    {
        try {
            return sodium_base642bin($value, SODIUM_BASE64_VARIANT_ORIGINAL, $ignore);
        } catch (SodiumException) {
            return null;
        }
    }

    public static function tryDecodeNoPadding(string $value, string $ignore = ""): ?string
    {
        try {
            return sodium_base642bin($value, SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING, $ignore);
        } catch (SodiumException) {
            return null;
        }
    }
}
