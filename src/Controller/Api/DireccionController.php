<?php

namespace App\Controller\Api;

use App\Entity\Direccion;
use App\Form\DireccionType;
use App\Repository\ClienteRepository;
use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Rest\Route("/direccion")
 */

class DireccionController extends AbstractFOSRestController
{
    private $direccionRepository;

    public function __construct(DireccionRepository $repo) {
        $this -> direccionRepository = $repo;
    }

    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_direccion"}, serializerEnableMaxDepthChecks=true)
     */
    public function createDireccion(Request $request) {
        $direccion = new Direccion();
        $form = $this -> createForm(DireccionType::class, $direccion);
        $form -> handleRequest($request);

        if (!$form -> isSubmitted() || !$form -> isValid()) {
            return new JsonResponse('Error', Response::HTTP_BAD_REQUEST);
        }

        $this -> direccionRepository -> add($direccion, true);
        return $direccion;
    }

    // Creamos un EndPoint que devuelva todas las direcciones en base al Id de un cliente
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_direccion_cliente"}, serializerEnableMaxDepthChecks= true)
     */
    public function getDireccionesByCliente(Request $request, ClienteRepository $clienteRepository) {
        $idCliente = $request -> get('id');

        // 1. Traerme el cliente de la Base de Datos
        $cliente = $clienteRepository -> find($idCliente);

        // 2. Una vez tengo el cliente, compruebo si existe y si no existe devuelvo error
        if (!$cliente) {
            return new JsonResponse('No se ha encontrado el cliente', Response::HTTP_NOT_FOUND);
        }

        // 3. Si existe entonces busco en la tabla direccion por el campo cliente
        $direcciones = $this -> direccionRepository -> findBy(['cliente' => $idCliente]);
        return $direcciones;
    }

    // Actualizar
    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"get_direccion_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateDireccion(Request $request) {
        $idDireccion = $request -> get('id');
        $direccion = $this -> direccionRepository -> find($idDireccion);

        if (!$direccion) {
            return new JsonResponse('No existe la direccion', Response::HTTP_NOT_FOUND);
        }

        $form = $this -> createForm(DireccionType::class, $direccion, ['method' => $request -> getMethod()]);
        $form -> handleRequest($request);

        if (!$form -> isSubmitted() || !$form -> isValid()) {
            return $form;
        }

        $this -> direccionRepository -> add($direccion, true);
        return $direccion;
    }

    // Eliminar
    /**
     * @Rest\Delete (path="/{id}")
     */
    public function deleteDireccion(Request $request) {
        $idDireccion = $request -> get('id');
        $direccion = $this -> direccionRepository -> find($idDireccion);

        if (!$direccion) {
            throw new NotFoundHttpException('No existe la direccion');
        }

        $this -> direccionRepository -> remove($direccion, true);
        return new Response('Eliminado', Response::HTTP_OK);
    }
}