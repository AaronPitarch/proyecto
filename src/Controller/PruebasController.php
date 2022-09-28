<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PruebasController extends AbstractController
{

    private $logger;
    public function __construct(LoggerInterface $logger) {
        $this -> logger = $logger;
    }

    //Tenemos que definir como es el endpoint para poder hacer la peticion desde el cliente
    /**
     * @Route("/get/usuarios", name="get_users")
     */


    public function getAllUser(Request $request) {
        //1. Llamará a base de datos y se traerá toda la lista de users


        //2. Devolverá una respuesta en formato Json
        //Request -> Es la peticion
        //Response -> Es el que devuelve la respuesta

        //$response = new Response(); // Esto lleva un codigo de estado
        //$response -> setContent('<div>Hola Mundo</div>');
        //return $response;

        //capturamos los datos que vienen en el Request
        $id = $request -> get('id');
        $this -> logger -> alert('Mensaje ');
        //Query sql para traer el user con id = $id

        $response = new JsonResponse();
        $response -> setData([
            'success' => true,
            'data' => [
                [
                    'id' => 1,
                    'nombre' => 'Pepe',
                    'email' => 'pepe@email.com'
                ],
                [
                    'id' => intval($id), //intval es como un parseInt
                    'nombre' => 'Manolo',
                    'email' => 'manolo@email.com'
                ]
            ]
        ]);

        return $response;
    }

}