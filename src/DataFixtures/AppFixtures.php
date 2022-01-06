<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $facker = Factory::create('Fr-fr');

        for($i = 1; $i <= 30; $i++) {
            $ad = new Ad();

            $title = $facker->sentence();
            $coverImage = $facker->imageUrl(1000,350);
            $introduction = $facker->paragraph(2);
            $content = '<p>' . join('<p/><p>', $facker->paragraphs(5)) . '</p>';

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5));
            
            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();
                $image->setUrl($facker->ImageUrl())
                        ->setCaption($facker->sentence())
                        ->setAd($ad);
                
                $manager->persist($image);
        
            }

        $manager->persist($ad);

        }
        
        $manager->flush();
    }
}
