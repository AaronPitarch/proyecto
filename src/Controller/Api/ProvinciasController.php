<?php

namespace App\Controller\Api;

use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/provincias")
 */
class ProvinciasController extends AbstractFOSRestController
{
    private $provinciasRepository;
    private $municipiosRepository;

    public function __construct(ProvinciasRepository $provinciasRepository, MunicipiosRepository $municipiosRepository) {
        $this -> provinciasRepository = $provinciasRepository;
        $this -> municipiosRepository = $municipiosRepository;
    }

    // 1. Devolver todas las provincias
    /**
     * @Rest\Get (path="/")
     * @Rest\View (serializerGroups={"provincias"}, serializerEnableMaxDepthChecks=true)
     */
    public function getProvincias() {
        return $this -> provinciasRepository -> findAll();
    }

    // 2. Devolver los municipios de una provincia
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"municipios"}, serializerEnableMaxDepthChecks=true)
     */
    public function getMunicipiosByProvincias(Request $request) {
        return $this -> municipiosRepository -> findBy(['idProvincia' => $request -> get('id')]);
    }
}