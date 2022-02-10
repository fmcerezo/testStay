<?php

/**
 * @author Francisco Manuel Cerezo González <franciscomanuelcerezo@gmail.com>
 * @package TestStay
 */
namespace TestStay\classes;

/**
 * Esta clase crea un fichero CSV de reservas a partir de los datos suministrados al constructor.
 */
final class CsvCreator
{
    private string $fileName;
    private array $bookings;


    public function __construct(string $fileName, array $bookings)
    {
        $this->fileName = $fileName;
        $this->bookings = $bookings;
    }


    /**
     * Crea fichero el fichero.
     *
     * @return bool
     */
    public function create() : bool
    { 
        // No se valida estructura.
        $handle = fopen($this->getFilePath(), 'w');

        // Inicializo el array asociativo fuera del bucle para crearlo una sola vez.
        $data = [
            'localizador' => '',
            'nombre' => '',
            'apellido' => '',
            'pasaporte' => '',
            'fecha_nacimiento' => '',
            'pais' => '',
            'hotel' => '',
            'entrada' => '',
            'salida' => '',
            'habitacion' => '',
        ];

        foreach ($this->bookings as $booking) {
            $data = [
                'localizador' => $booking->booking->locator,
                'nombre' => $booking->guest->name,
                'apellido' => $booking->guest->lastname,
                'pasaporte' => $booking->guest->passport,
                'fecha_nacimiento' => $booking->guest->birthdate,
                'pais' => $booking->guest->country,
                'hotel' => $booking->hotel_id,
                'entrada' => $booking->booking->check_in,
                'salida' => $booking->booking->check_out,
                'habitacion' => $booking->booking->room,
            ];

            fputcsv($handle, $data);
        }

        return fclose($handle);
    }

    /**
     * Devuelve el nombre completo del fichero generado.
     *
     * @return string
     */
    public function getFilePath() : string
    {
        return CSV_PATH . $this->fileName . '.csv';
    }
}
