<?php
// src/Acme/ApiBundle/DataFixtures/ORM/LoadCategoryData.php

namespace Acme\ApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\ApiBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('First Category');
        $manager->persist($category);
        $manager->flush();

        $this->addReference('first-category', $category);

        $category = new Category();
        $category->setName('Second Category');
        $manager->persist($category);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
