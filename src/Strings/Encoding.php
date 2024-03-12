<?php

namespace Shrd\EncodingCombinators\Strings;

use Exceptions\DecodeException;

enum Encoding implements Encoder, Decoder
{
    case Plain;
    case Base64;
    case Base64NoPadding;
    case Base64Url;
    case Base64UrlNoPadding;
    case Hex;

    public function constantTime(): ConstantTime\Encoding
    {
        return match ($this) {
            self::Plain => ConstantTime\Encoding::Plain,
            self::Base64 => ConstantTime\Encoding::Base64,
            self::Base64NoPadding => ConstantTime\Encoding::Base64NoPadding,
            self::Base64Url => ConstantTime\Encoding::Base64Url,
            self::Base64UrlNoPadding => ConstantTime\Encoding::Base64UrlNoPadding,
            self::Hex => ConstantTime\Encoding::Hex,
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
    public function decode(string $value, bool $strict = false): string
    {
        return match ($this) {
            self::Plain => $value,
            self::Base64, self::Base64NoPadding => Base64::decode($value, $strict),
            self::Base64Url, self::Base64UrlNoPadding => Base64Url::decode($value, $strict),
            self::Hex => Hex::decode($value),
        };
    }

    public function tryDecode(string $value, bool $strict = false): ?string
    {
        return match ($this) {
            self::Plain => $value,
            self::Base64, self::Base64NoPadding => Base64::tryDecode($value, $strict),
            self::Base64Url, self::Base64UrlNoPadding => Base64Url::tryDecode($value, $strict),
            self::Hex => Hex::tryDecode($value),
        };
    }
}
