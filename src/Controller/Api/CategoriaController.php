<?php

namespace App\Controller\Api;

use App\Entity\Categorias;
use App\Form\CategoriaType;
use App\Repository\CategoriasRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/categoria")
 */
class CategoriaController extends AbstractFOSRestController
{
    private $categoriaRepository;

    public function __construct(CategoriasRepository $repo) {
        $this -> categoriaRepository = $repo;
    }

    //Traer todas las categorias
    /**
     * @Rest\Get(path="/")
     * @Rest\View (serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks=true)
     */
    public function getCategorias() {
        return $this -> categoriaRepository -> findAll();
    }

    //Traer una categoria
    /**
     * @Rest\Get(path="/{id}")
     * @Rest\View (serializerGroups={"get_categoria"}, serializerEnableMaxDepthChecks=true)
     */
    public function getCategoria(Request $request) {
        $idCategoria = $request -> get('id');
        $categoria = $this -> categoriaRepository -> find($idCategoria);

        if (!$categoria) {
            return new JsonResponse('No se ha encontrado categoria', Response::HTTP_NOT_FOUND);
        }

        return $categoria;
    }

    // Agregar una categoria
    /**
     * @Rest\Post(path="/")
     * @Rest\View(serializerGroups={"post_categoria"}, serializerEnableMaxDepthChecks=true)
     */
    public function createCategoria(Request $request) {
        //Formularios -> es para manejar las peticiones y validar el tipado
        //Validator ->
        //1. Creo el objeto vacio
        $cat = new Categorias();

        //2. Inicializamos el Form
        $form = $this -> createForm(CategoriaType::class, $cat);

        //3. Le decimos al formulario que maneje la request
        $form -> handleRequest($request);

        //4. Comprobar si hay error
        if (!$form -> isSubmitted() || !$form -> isValid()) {
            return $form;
        }

        //5. Si esta todDo ok, lo guardo en la base de datos
        $categoria = $form -> getData();
        $this -> categoriaRepository -> add($categoria, true);
        return $categoria;
    }

    // Update con patch
    /**
     * @Rest\Patch(path="/{id}")
     * @Rest\View(serializerGroups={"up_categoria"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateCategoria(Request $request) {
        // Me guardo el id de la categoria a actualizar
        $categoriaId = $request -> get('id');

        // Comprobar que la categoria existe
        $categoria = $this -> categoriaRepository -> find($categoriaId);
        if (!$categoria) {
            return new JsonResponse('No se ha encontrado la categoria', Response::HTTP_NOT_FOUND);
        }

        $form = $this -> createForm(CategoriaType::class, $categoria, ['method' => $request -> getMethod()]);
        $form -> handleRequest($request);

        // Tenemos que comprobar la validez del form
        if (!$form -> isSubmitted() || !$form -> isValid()) {
            return new JsonResponse('Error al actualizar', 400);
        }

        $this -> categoriaRepository -> add($categoria, true);
        return $categoria;
    }

    // Borrar categoria
    /**
     * @Rest\Delete(path="/{id}")
     *
     */
    public function deleteCategoria(Request $request) {
        $categoriaId = $request -> get('id');
        $categoria = $this -> categoriaRepository -> find($categoriaId);

        if (!$categoria) {
            return new JsonResponse('No se ha encontrado la categoria', 400);
        }

        $this -> categoriaRepository -> remove($categoria, true);
        return new JsonResponse('Categoria eliminada', 200);
    }
}