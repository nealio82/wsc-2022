<?php

namespace App\DataFixtures;

use App\Entity\Kitty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (self::kittyNames() as $kittyName) {
            $kitty = new Kitty();
            $kitty->setName($kittyName);
            $kitty->setIntro(self::getRandomBio());
            $kitty->setAvatarUrl($this->getRandomImage());

            $manager->persist($kitty);
        }

        $manager->flush();
    }

    private function getRandomImage(): string
    {
        // cat images pilfered from https://www.pexels.com/search/cat/
        $finder = new Finder();

        $filesystem = new Filesystem();

        $files = \iterator_to_array($finder->files()->in(__DIR__ . '/images')->getIterator());

        /**
         * @var \SplFileInfo $file
         */
        $file = $files[\array_rand($files)];

        $filesystem->copy($file->getRealPath(), __DIR__ . '/../../public/uploads/avatars/' . $file->getFilename());

        return $file->getFilename();
    }

    private static function getRandomBio(): string
    {
        $arr = [
            'A fish a day keeps the vet away',
            'Got milk?',
            'I\'ll sit on your lap and purr all day long',
            'Ears back, claws out'
        ];

        return $arr[\array_rand($arr)];
    }


    private static function kittyNames(): array
    {
        return [
            "Almond",
            "Anchovy",
            "Aretha Franklin",
            "Baguette",
            "Beans",
            "Beef",
            "Bella",
            "Biden",
            "Bitcoin",
            "Boseman",
            "Brisket",
            "CeeDee",
            "Chadwick",
            "Charlie",
            "Chloe",
            "Cinnamon",
            "Coconut",
            "Coffee",
            "Covi",
            "Covid",
            "Dior",
            "Doja Cat",
            "Dolly Parton",
            "Dua Lipa",
            "Eggo",
            "Elon",
            "Fauci",
            "Fig",
            "Gimlet",
            "Gronk",
            "Halsey",
            "Ham",
            "Harris",
            "J-Hope",
            "Jack",
            "Jasper",
            "Jupiter",
            "Kamala",
            "Katie",
            "Kitty",
            "Kiwi",
            "Lemon",
            "Leo",
            "Lily",
            "Loki",
            "Lola",
            "Lucy",
            "Luna",
            "Lychee",
            "Mango",
            "Margarita",
            "Max",
            "Milo",
            "Mocha",
            "Nala",
            "Oat",
            "Oliver",
            "Ollie",
            "Oprah",
            "Parma",
            "Pear",
            "Pepsi",
            "Pineapple",
            "Pizza",
            "Plum",
            "Pork Chop",
            "Prosecco",
            "Raclette",
            "Rona",
            "Saturn",
            "Schnitzel",
            "Scotch",
            "Simba",
            "Simone",
            "Stella",
            "Suga",
            "Taylor",
            "Toast",
            "Tofu",
            "Tom",
            "Vax",
            "Vodka",
            "Voltaire",
            "Watermelon",
            "Willow",
            "Yeezy",
            "Zoe",
        ];
    }
}

