<?php

/**
 * @author Francisco Manuel Cerezo González <franciscomanuelcerezo@gmail.com>
 * @package TestStay
 */
namespace TestStay\controllers;

use TestStay\classes\CsvCreator;
use TestStay\classes\LastCall;
use TestStay\classes\ServiceLink;
use TestStay\classes\exceptions\ConnectionException;
use TestStay\classes\exceptions\CountBookingException;

/**
 * Controlador de reservas.
 */
final class BookingController
{
    /**
     * Obtiene reservas del endpoint e imprime en el flujo de salida información en CSV.
     *
     * @return void
     */
    public static function getCsv() : void
    {
        $ts = LastCall::getTs();

        try {
            $serviceLink = new ServiceLink(DATA_URL, $ts);
            $bookings = $serviceLink->getData();

            $csvCreator = new CsvCreator($ts, $bookings);
            if ($csvCreator->create()) {
                $newTs = LastCall::getLastBookingTs($bookings);
                LastCall::setTs($newTs);
                http_response_code(200);
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            
                header('Cache-Control: no-store, no-cache, must-revalidate');
                header('Cache-Control: post-check=0, pre-check=0', false);
                header('Pragma: no-cache');
            
                header('Content-Type: application/csv');
                header('Content-Disposition: attachment; filename=' . $ts . '.csv');
            
                readfile($csvCreator->getFilePath());
            } else {
                http_response_code(409);
            }
        } catch (ConnectionException $ex) {
            http_response_code($ex->getCode());
        } catch (CountBookingException $ex) {
            http_response_code($ex->getCode());
        }
    }
}
