<?php

namespace Shrd\EncodingCombinators\Strings\ConstantTime;

use Shrd\EncodingCombinators\Strings\Encoding as VariadicTimeEncoding;
use Exceptions\DecodeException;
use Shrd\EncodingCombinators\Strings\Decoder;
use Shrd\EncodingCombinators\Strings\Encoder;

enum Encoding implements Encoder, Decoder
{
    case Plain;
    case Base64;
    case Base64NoPadding;
    case Base64Url;
    case Base64UrlNoPadding;
    case Hex;

    public function variadicTime(): VariadicTimeEncoding
    {
        return match ($this) {
            self::Base64 => VariadicTimeEncoding::Base64,
            self::Base64NoPadding => VariadicTimeEncoding::Base64NoPadding,
            self::Base64Url => VariadicTimeEncoding::Base64Url,
            self::Base64UrlNoPadding => VariadicTimeEncoding::Base64UrlNoPadding,
            self::Hex => VariadicTimeEncoding::Hex,
            self::Plain => VariadicTimeEncoding::Plain,
        };
    }

    public function urlSafe(): self
    {
        return match ($this) {
            self::Base64, self::Base64Url => self::Base64Url,
            self::Base64NoPadding, self::Base64UrlNoPadding => self::Base64UrlNoPadding,
            default => $this,
        };
    }

    public function noPadding(): self
    {
        return match ($this) {
            self::Base64, self::Base64NoPadding => self::Base64NoPadding,
            self::Base64Url, self::Base64UrlNoPadding => self::Base64UrlNoPadding,
            default => $this,
        };
    }

    public function padded(): self
    {
        return match ($this) {
            self::Base64, self::Base64NoPadding => self::Base64,
            self::Base64Url, self::Base64UrlNoPadding => self::Base64Url,
            default => $this,
        };
    }

    public function encode(string $value): string
    {
        return match ($this) {
            self::Plain => $value,
            self::Base64 => Base64::encode($value),
            self::Base64NoPadding => Base64::encodeNoPadding($value),
            self::Base64Url => Base64Url::encode($value),
            self::Base64UrlNoPadding => Base64Url::encodeNoPadding($value),
            self::Hex => Hex::encode($value),
        };
    }

    /**
     * @throws DecodeException
     */
    public function decode(string $value, string $ignore = ""): string
    {
        return match ($this) {
            self::Plain => $value,
            self::Base64 => Base64::decode($value, $ignore),
            self::Base64NoPadding => Base64::decodeNoPadding($value, $ignore),
            self::Base64Url => Base64Url::decode($value, $ignore),
            self::Base64UrlNoPadding => Base64Url::decodeNoPadding($value, $ignore),
            self::Hex => Hex::decode($value, $ignore)
        };
    }

    public function tryDecode(string $value, string $ignore = ""): ?string
    {
        return match ($this) {
            self::Plain => $value,
            self::Base64 => Base64::tryDecode($value, $ignore),
            self::Base64NoPadding => Base64::tryDecodeNoPadding($value, $ignore),
            self::Base64Url => Base64Url::tryDecode($value, $ignore),
            self::Base64UrlNoPadding => Base64Url::tryDecodeNoPadding($value, $ignore),
            self::Hex => Hex::decode($value, $ignore)
        };
    }
}
