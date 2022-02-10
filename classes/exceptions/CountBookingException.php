<?php

/**
 * @author Francisco Manuel Cerezo González <franciscomanuelcerezo@gmail.com>
 * @package TestStay
 */
namespace TestStay\classes\exceptions;

use Exception;
use Throwable;

/**
 * Excepción si el recuento de reservas no coincide con el total informado.
 */
final class CountBookingException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
        $this->code = 418;
    }
}
