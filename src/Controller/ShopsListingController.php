<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class ShopsListing extends AbstractFOSRestController
{
    /**
     * @var ShopRepository
     */
    private $shopRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;


    /**
     * ShopsListing constructor.
     * @param ShopRepository $shopRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ShopRepository $shopRepository, EntityManagerInterface $entityManager)
    {
        $this->shopRepository = $shopRepository;
        $this->entityManager = $entityManager;
    }

    public function getShopsAction() {
        $shops = $this->shopRepository->findAll();

        return $this->view($shops, Response::HTTP_OK);
    }

}