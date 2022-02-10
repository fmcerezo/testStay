<?php

/**
 * @author Francisco Manuel Cerezo González <franciscomanuelcerezo@gmail.com>
 * @package TestStay
 */
namespace TestStay\classes\exceptions;

use Exception;
use Throwable;

/**
 * Excepción para problemas de conexión.
 */
final class ConnectionException extends Exception
{
    public function __construct(string $message = "", int $curlError = 0, Throwable $previous = null) {
        $this->code = 404;
        if (empty($message) && $curlError > 0) {
            $this->message = 'Error curl ' . $curlError;
        }
    }
}
