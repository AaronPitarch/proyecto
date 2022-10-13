<?php

namespace App\Controller\Api;

use App\Repository\RestauranteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/restaurante")
 */
class RestauranteController extends AbstractFOSRestController
{
    private $restauranteRepository;

    public function __construct(RestauranteRepository $restauranteRepository) {
        $this -> restauranteRepository = $restauranteRepository;
    }

    // 1. Devolver restaurante por id
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"restaurante"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurante(Request $request) {
        return $this -> restauranteRepository -> find($request -> get('id'));
    }

    // 2. Devolver listado de restaurantes, segun dia, hora y municipio
    // Primero seleccionamos la direccion a la que se va a enviar la comida
    // Luego seleccionamos dia y hora del reparto
    // Mostramos los restaurantes que cumplan esas condiciones
    /**
     * @Rest\Post (path="/filtered")
     * @Rest\View (serializerGroups={"res_filtered"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurantesBy(Request $request) {
        $dia = $request -> get('dia');
        $hora = $request -> get('hora');
        $idMunicipio = $request -> get('municipio');

        $restaurantes = $this -> restauranteRepository -> findByDayTimeMunicipio($dia, $hora, $idMunicipio);
        return $restaurantes;
    }
}