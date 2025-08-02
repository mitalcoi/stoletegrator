<?php

namespace Product\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Product\Repository\ProductRepository;
use Product\Repository\UserRepository;
use Product\View\ProductViewFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/products')]
class ProductController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private ProductRepository $productRepository,
        private EntityManagerInterface $em,
        private ProductViewFactory $productViewFactory,
        private SerializerInterface $serializer,
    ) {
    }

    #[Route('', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $user = $this->getUser() ? $this->userRepository->getByIdentifier($this->getUser()->getUserIdentifier()) : null;
        $products = $this->productRepository->findWithFilters($request->query->all());
        $views = $this->productViewFactory->createList($products, $user);

        $json = $this->serializer->serialize($views, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/favorites', methods: ['GET'])]
    public function favorites(UserInterface $user): JsonResponse
    {
        $user = $this->userRepository->getByIdentifier($user->getUserIdentifier());
        $views = $this->productViewFactory->createList($user->getFavorites(), $user);

        $json = $this->serializer->serialize($views, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/{id}/favorite', methods: ['POST'])]
    public function toggleFavorite(int $id, UserInterface $user): JsonResponse
    {
        $product = $this->productRepository->getById($id);
        $user = $this->userRepository->getByIdentifier($user->getUserIdentifier());
        $user->toggleFavorite($product);
        $this->em->flush();

        return $this->json(null);
    }
}
