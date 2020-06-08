<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0 ; $i<50 ;$i++)
        {
            $slugify = new Slugify();
            $episode = new Episode();
            $faker = Faker\Factory::create('fr_FR');
            $episode->setNumber($faker->numberBetween(1,19));
            $episode->setTitle($faker->word());
            $slug = $slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $episode->setSynopsis($faker->text(100));
            $episode->setSeason($this->getReference('season_id_'.$faker->numberBetween(0,19)));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}