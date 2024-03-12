<?php

namespace Shrd\EncodingCombinators\Exceptions;

use Exception;
use Exceptions\DecodeException;
use Throwable;

class WrappedDecodeException extends Exception implements DecodeException
{
    public function __construct(Throwable $previous)
    {
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);
    }
}
