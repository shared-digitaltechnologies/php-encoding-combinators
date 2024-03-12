<?php

namespace Shrd\EncodingCombinators\Exceptions;

use RuntimeException;
use Throwable;

class WrappedEncodeException extends RuntimeException
{
    public function __construct(Throwable $previous)
    {
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);
    }
}
