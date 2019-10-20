<?php

namespace App\Controller;

use App\Entity\LikedShops;
use App\Entity\Shop;
use App\Repository\LikedShopsRepository;
use App\Repository\ShopRepository;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Location\Coordinate;
use Location\Distance\Haversine;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShopsListingController extends AbstractFOSRestController
{
    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var LikedShopsRepository
     */
    private $likedShopsRepository;
    /**
     * @var JWTTokenManagerInterface
     */
    private $jwtManager;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorageInterface;
    /**
     * @var UserRepository
     */
    private $userRepository;


    /**
     * ShopsListing constructor.
     * @param TokenStorageInterface $tokenStorageInterface
     * @param JWTTokenManagerInterface $jwtManager
     * @param ShopRepository $shopRepository
     * @param EntityManagerInterface $entityManager
     * @param LikedShopsRepository $likedShopsRepository
     * @param UserRepository $userRepository
     */
    public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager,
                                ShopRepository $shopRepository, EntityManagerInterface $entityManager,
                                LikedShopsRepository $likedShopsRepository, UserRepository $userRepository)
    {
        $this->shopRepository = $shopRepository;
        $this->entityManager = $entityManager;
        $this->likedShopsRepository = $likedShopsRepository;
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->userRepository = $userRepository;
    }


    public function currentUser() {
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        return $this->userRepository->findOneBy(['email' => $decodedJwtToken['username']]);

    }

    public function GetUserLocation() {
        return new Coordinate($this->currentUser()->getLatitude(), $this->currentUser()->getLongitude());
    }


    /**
     * @param Shop $firstShop
     * @param Shop $secondShop
     * @return int
     */
    public function sortPredicat(Shop $firstShop, Shop $secondShop) {
        $firstShopCoordinates = new Coordinate($firstShop->getLatitude(), $firstShop->getLongitude());
        $secondShopCoordinates = new Coordinate($secondShop->getLatitude(), $secondShop->getLongitude());

        $distanceToFirst = $firstShopCoordinates->getDistance($this->GetUserLocation(), new Haversine());
        $distanceToSecond = $secondShopCoordinates->getDistance($this->GetUserLocation(), new Haversine());

        if ($distanceToFirst === $distanceToSecond) return 0;
        return ($distanceToFirst < $distanceToSecond ? -1 : 1);

    }

    public function getShopsAction() {
        $shops = $this->shopRepository->findAll();
        $user = $this->currentUser();
//        Normally we should not have empty ID since we have a valid Token but we're giving it a default value.
        $userId = isset($user) && !empty($user) ? $user->getId() : 1;
        $list = $this->likedShopsRepository->findBy(['user' => $userId]);

        $items = array_map(function ($item) {
            return $item->getShops();
        }, $list);

        $shops = array_filter($shops, function ($item) use ($items){
            return !in_array($item, $items);
        }) ;
        usort($shops, [$this, "sortPredicat"]);

        return $this->view($shops, Response::HTTP_OK);
    }

    /**
     * @return View
     */

    public function getShopsLikedAction() {
        $user = $this->currentUser();
//        Normally we should not have empty ID since we have a valid Token but we're giving it a default value.
        $userId = isset($user) && !empty($user) ? $user->getId() : 1;
        $list = $this->likedShopsRepository->findBy(['user' => $userId]);

        $items = array_map(function ($item) {
            return $item->getShops();
        }, $list);

        return $this->view($items, Response::HTTP_OK);
    }


    /**
     * @Rest\RequestParam(name="shop", description="Shop Id", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @return View
     */

    public function postShopLikeAction(ParamFetcher $paramFetcher) {
        $shopId = $paramFetcher->get('shop');
        $shop = $this->shopRepository->findOneBy(['id' => $shopId]);
        $user = $this->currentUser();
        //        Normally we should not have empty ID since we have a valid Token but we're giving it a default value.
        $userId = isset($user) && !empty($user) ? $user->getId() : 1;

        if ($this->likedShopsRepository->findOneBy(['shops' => $shopId, 'user' => $userId])) {
            return $this->view(['message' => 'Shop already liked'], Response::HTTP_CONFLICT);
        }

        $likedShops = new LikedShops();
        $likedShops->setUser($user)->setShops($shop);

        $this->entityManager->persist($likedShops);
        $this->entityManager->flush();

        return $this->view($shop, Response::HTTP_CREATED);
    }

}