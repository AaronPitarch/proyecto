<?php

namespace App\Controller\Api;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//Establecemos la ruta padre

/**
 * @Rest\Route("/cliente")
 */

class ClienteController extends AbstractFOSRestController
{
    private $clienteRepository;

    public function __construct(ClienteRepository $repo) {
        $this -> clienteRepository = $repo;
    }

    //Crear cliente
    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function createCliente(Request $request) {
        $cli = new Cliente();
        $form = $this -> createForm(ClienteType::class, $cli);
        $form -> handleRequest($request);

        if (!$form -> isSubmitted() || !$form -> isValid()) {
            return $form;
        }

        //Guardamos en la base de datos
        $cliente = $form -> getData();
        $this -> clienteRepository -> add($cliente, true);
        return $cliente;
    }

    //Devolver un cliente
    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View (serializerGroups={"get_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function getCliente(Request $request) {
        $idCliente = $request -> get('id');
        $cliente = $this -> clienteRepository-> find($idCliente);

        if (!$cliente) {
            return new JsonResponse('No se ha encontrado el cliente', Response::HTTP_NOT_FOUND);
        }

        return $cliente;
    }

    /**
     * @Rest\Patch (path="/")
     * @Rest\View (serializerGroups={"up_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateCliente(Request $request) {
        $idCliente = $request -> get('id');
        $cliente = $this -> clienteRepository -> find($idCliente);

        if(!$cliente) {
            return new JsonResponse('No se ha encontrado el cliente', Response::HTTP_NOT_FOUND);
        }

        $form = $this -> createForm(ClienteType::class, $cliente, ['method' => $request -> getMethod()]);
        $form -> handleRequest($request);

        if (!$form -> isSubmitted() || !$form -> isValid()) {
            return $form;
        }

        $this -> clienteRepository -> add($cliente, true);
        return $cliente;
    }
}