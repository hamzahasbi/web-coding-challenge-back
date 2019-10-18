<?php
namespace App\Serializer;
use App\Entity\User;
use App\Entity\Shop;
use App\Entity\LikedShops;
use Symfony\Component\Routing\RouterInterface;
class CircularReferenceHandler
{
    /**
     * @var RouterInterface
     */
    private $router;
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke($object)
    {
        return $object->getId();
    }
}