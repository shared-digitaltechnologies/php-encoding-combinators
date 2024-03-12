<?php

namespace Shrd\EncodingCombinators\Strings;

use Exceptions\DecodeException;

interface Decoder
{
    /**
     * @param string $value
     * @return string
     * @throws DecodeException
     */
    public function decode(string $value): string;

    public function tryDecode(string $value): ?string;
}
