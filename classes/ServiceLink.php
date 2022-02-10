<?php

/**
 * @author Francisco Manuel Cerezo González <franciscomanuelcerezo@gmail.com>
 * @package TestStay
 */
namespace TestStay\classes;

use TestStay\classes\exceptions\ConnectionException;
use TestStay\classes\exceptions\CountBookingException;

/**
 * Conecta con el endpoint para obtener reservas.
 */
final class ServiceLink
{
	private string $uri;
	private int $ts;


	public function __construct(string $uri, int $ts) {
		$this->uri = $uri;
		$this->ts = $ts;
	}


	/**
	 * Conecta con el endpoint y devuelve un array de reservas.
	 *
	 * @return array
	 * @throws ConnectionException
	 * @throws CountBookingException
	 */
	public function getData() : array {
		// No implemento alternativa si curl no está instalado.
		// Para este caso se podría usar file_get_contents.
		$con = curl_init($this->uri . $this->ts);
		curl_setopt($con, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($con, CURLOPT_TIMEOUT, 10);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($con);
		$error = curl_errno($con);
		curl_close($con);

		if ($error == 0) {
			$jsonValue = json_decode($response);

			if (count($jsonValue->bookings) == $jsonValue->total) {
				return $jsonValue->bookings;
			} else {
				throw new CountBookingException('Error al conectar: ' . $error);	
			}
		} else {
			throw new ConnectionException('', $error);
		}
	}
}