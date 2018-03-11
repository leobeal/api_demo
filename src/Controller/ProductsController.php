<?php

namespace App\Controller;


use App\Service\ProductsService;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends Controller
{
    private $productsService;
    private $serializer;

    public function __construct(ProductsService $productsService, SerializerInterface $serializer)
    {
        $this->productsService = $productsService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/products", name="getProducts", methods="GET")
     *
     * List all the products
     *
     * @SWG\Response(
     *     response=200,
     *     description="List all the products",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=App\Entity\Product::class)
     *
     *     )
     * )
     * @SWG\Tag(name="product")
     */
    public function index()
    {
        return JsonResponse::fromJsonString($this->serializer->serialize($this->productsService->getAll(), 'json'));
    }
}
