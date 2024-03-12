<?php

namespace Exceptions;

use ErrorException;
use Throwable;

class DecodeErrorException extends ErrorException implements DecodeException
{
    public function __construct(public readonly string $decoder,
                                string $message = "",
                                int $code = 0,
                                int $severity = 1,
                                ?string $filename = null,
                                ?int $line = null,
                                ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $severity, $filename, $line, $previous);
    }

    public static function createFromPhpError(string $decoder): self
    {
        $error = error_get_last();
        return new self(
            decoder: $decoder,
            message: $error['message'] ?? 'An error occured',
            severity: $error['type'] ?? 1,
            filename: $error['file'] ?? null,
            line: $error['line'] ?? 2
        );
    }
}
