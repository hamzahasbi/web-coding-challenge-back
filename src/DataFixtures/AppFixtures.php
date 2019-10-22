<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private function __generateShops() {
        $initial = [];

        for($i = 0; $i <= 100; $i++) {
//    Generate some dummy coordinates.
            $lat = mt_rand(-80, 80) + mt_rand(0, 100) / 1000000;
            $lon = mt_rand(-140, 140) + + mt_rand(0, 100) / 1000000;
            $shop =  [
                'name'         => 'Canopoly_' . $i,
                'longitude'    => $lon,
                'latitude'     => $lat,
                'description'  => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.
         Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown
          printer took a galley of type and scrambled it to make a type specimen book.',
                'thumbnail'    => 'http://placeimg.com/290/180/any'
            ];
            array_push($initial, $shop);
        }
        return $initial;
    }

    public function load(ObjectManager $manager)
    {
        $data = $this->__generateShops();
        foreach ($data as $item) {
            $shop = new Shop();
            $shop->setName($item['name']);
            $shop->setLatitude($item['latitude']);
            $shop->setLongitude($item['longitude']);
            $shop->setDescription($item['description']);
            $shop->setThumbnail($item['thumbnail']);

            $manager->persist($shop);
            $manager->flush();
        }
    }
}
