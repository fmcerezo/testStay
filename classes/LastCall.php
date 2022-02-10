<?php

/**
 * @author Francisco Manuel Cerezo González <franciscomanuelcerezo@gmail.com>
 * @package TestStay
 */
namespace TestStay\classes;

/**
 * Clase para obtener y persistir el timestamp de la última reserva obtenida del endpoint.
 */
final class LastCall
{
    const TS_FILE_PATH = 'config/ts';


    /**
     * Devuelve el timestamp de la última reserva del array pasado por parámetro.
     *
     * @param array $bookings
     * @return integer
     */
    public static function getLastBookingTs(array $bookings) : int
    {
        if (empty($bookings)) {
            $ts = self::getTs();
        } else {
            $last = end($bookings);
            $ts = strtotime($last->created);
        }

        return $ts;
    }

    /**
     * Devuelve el timestamp a pasar por parámetro a ServiceLink.
     *
     * @return integer
     */
    public static function getTs() : int
    {
        if (!file_exists(self::TS_FILE_PATH)) {
            self::setTs(0);
        }
        
        return file_get_contents(self::TS_FILE_PATH);
    }

    /**
     * Persiste el timestamp a pasar por parámetro a ServiceLink
     * en la próxima llamada.
     *
     * @param integer $timestamp
     * @return boolean
     */
    public static function setTs(int $timestamp) : bool
    {
        return (bool) file_put_contents(self::TS_FILE_PATH, $timestamp);
    }
}
