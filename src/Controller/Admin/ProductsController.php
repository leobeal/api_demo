<?php

namespace App\Controller\Admin;

use App\Exceptions\InvalidParametersException;
use App\Service\ProductsService;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
     * @Route("/api/products", name="postProducts", methods="POST")
     * @\Nelmio\ApiDocBundle\Annotation\Security(name="basic")
     *
     * Store a product
     *
     * @SWG\Response(
     *     response=200,
     *     description="Store a product",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=App\Entity\Product::class, groups={"full"})
     *     )
     * )
     * @SWG\Tag(name="product")
     * @throws InvalidParametersException
     */
    public function store(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("The user appears to be logged but it does not have the 'ROLE_ADMIN'");
        }

        $product = $this->productsService->save($request->getContent());

        return JsonResponse::fromJsonString($this->serializer->serialize($product, 'json'));
    }
}
