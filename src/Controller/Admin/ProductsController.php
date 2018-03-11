<?php

namespace App\Controller\Admin;

use App\Exceptions\InvalidParametersException;
use App\Service\ProductsService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
            throw new AccessDeniedException();
        }

        $product = $this->productsService->save($request->getContent());

        return JsonResponse::fromJsonString($this->serializer->serialize($product, 'json'));
    }
}
