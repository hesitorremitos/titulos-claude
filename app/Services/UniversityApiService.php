<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UniversityApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://apititulos.uatf.edu.bo/api';
    }

    /**
     * Buscar datos de persona por CI en la API universitaria
     */
    public function searchPersonByCi(string $ci): array
    {
        try {
            $response = Http::timeout(10)->post($this->baseUrl."/datos?ru='{$ci}'");

            if ($response->successful()) {
                $data = $response->json();

                // La API retorna un array de programas para la misma persona
                if (empty($data)) {
                    return [
                        'success' => false,
                        'message' => 'No se encontraron datos para este CI',
                        'data' => [],
                    ];
                }

                // Procesar los datos para mostrar la persona y sus programas
                $personData = $this->processApiResponse($data);

                return [
                    'success' => true,
                    'message' => 'Datos encontrados exitosamente',
                    'data' => $personData,
                ];
            }

            return [
                'success' => false,
                'message' => 'Error al consultar la API universitaria',
                'data' => [],
            ];

        } catch (\Exception $e) {
            Log::error('Error al consultar API universitaria: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Error de conexión con la API universitaria',
                'data' => [],
            ];
        }
    }

    /**
     * Procesar la respuesta de la API para extraer datos de persona y programas
     */
    private function processApiResponse(array $data): array
    {
        if (empty($data)) {
            return [];
        }

        // Tomar los datos personales del primer elemento (son iguales en todos)
        $firstRecord = $data[0];

        $personData = [
            'ci' => $firstRecord['nro_dip'],
            'nombres' => $firstRecord['nombres'],
            'paterno' => $firstRecord['paterno'],
            'materno' => $firstRecord['materno'],
            'fecha_nacimiento' => $firstRecord['fec_nacimiento'],
            'genero' => $firstRecord['genero'],
            'pais' => $firstRecord['pais'],
            'departamento' => $firstRecord['departamento'],
            'provincia' => $firstRecord['provincia'],
            'localidad' => $firstRecord['localidad'],
            'programas' => [],
        ];

        // Extraer todos los programas académicos
        foreach ($data as $record) {
            $personData['programas'][] = [
                'programa' => $record['programa'],
                'facultad' => $record['facultad'],
                'decano_nombres' => $record['decano_nombres'],
                'modalidad_graduacion' => $record['modalidad_graduacion'],
            ];
        }

        return $personData;
    }

    /**
     * Obtener programas disponibles para una persona
     */
    public function getPersonPrograms(string $ci): array
    {
        $result = $this->searchPersonByCi($ci);

        if ($result['success']) {
            return $result['data']['programas'] ?? [];
        }

        return [];
    }
}
