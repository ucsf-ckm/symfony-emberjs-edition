<?php
// src/Acme/ApiBundle/DataFixtures/ORM/LoadProductData.php

namespace Acme\ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\ApiBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setDescription('Description of First Product');
        $product->setName('First Product');
        $product->setPrice(1.90);
        $product->setCategory($this->getReference('first-category'));
        $manager->persist($product);
        
        $product = new Product();
        $product->setDescription('Description of Second Product');
        $product->setName('Second Product');
        $product->setPrice(90);
        $product->setCategory($this->getReference('first-category'));
        $manager->persist($product);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
