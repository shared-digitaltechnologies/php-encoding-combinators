<?php

namespace Shrd\EncodingCombinators\Strings;

interface Encoder
{
    public function encode(string $value): string;
}
