<?php

namespace App\DataFixtures;

use App\Entity\Store\Brand;
use App\Entity\Store\Color;
use App\Entity\Store\Image;
use App\Entity\Store\Product;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const DATA_BRANDS = [
        ['Adidas'],
        ['Asics'],
        ['Nike'],
        ['Puma']
    ];

    private const DATA_COLORS = [
        ['Blanc'],
        ['Noir'],
        ['Rouge'],
        ['Bleu'],
        ['Vert'],
        ['Jaune'],
        ['Orange'],
        ['Marron'],
        ['Gris']
    ];


    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadBrands();
        $this->loadColors();
        $this->loadProducts();
        $manager->flush();
    }

    private function loadBrands(): void {
        foreach (self::DATA_BRANDS as $key => [$name]) {
            $brand = new Brand();
            $brand->setName($name);
            $this->manager->persist($brand);
            $this->addReference(Brand::class . $key, $brand);
        }
    }

    private function loadColors(): void {
        foreach (self::DATA_COLORS as $key => [$name]) {
            $color = new Color();
            $color->setName($name);
            $this->manager->persist($color);
            $this->addReference(Color::class . $key, $color);
        }
    }

    private function loadProducts(): void {
        $slugify = new Slugify();
        
        for ($i = 1; $i < 15; $i++) {
            $product = (new Product())
                ->setName('Product ' . $i)
                ->setBrand($this->getRandomEntityReference(Brand::class, self::DATA_BRANDS))
                ->setDescription('Voici la description de la chaussure ' . $i)
                ->setDescriptionLongue('Voici la description suuuuper longue de la chaussure ' . $i)
                ->setPrice(mt_rand(10, 100));
            $product->setImage($this->createImage($i, $product->getName()));
            $product->setSlug($slugify->slugify($product->getName()));

            for ($j = 0; $j < random_int(0, count(self::DATA_COLORS) -1); $j++) {
                if (random_int(0, 1)) {
                    /** @var Color $color */
                    $color = $this->getReference(Color::class . $j);
                    $product->addColor($color);
                }
            }

            $this->manager->persist($product);
        }
    }

    private function createImage(int $i, string $alt): Image {
        return (new Image())
            ->setUrl('shoe-' . $i . '.jpg')
            ->setAlt($alt);
    }

    /**
     * @param class-string $entityClass
     * 
     * @return object<class-string>
     */
    private function getRandomEntityReference(string $entityClass, array $data): object {
        return $this->getReference($entityClass . random_int(0, count($data) - 1));
    }
}