<?php

namespace Acme\ApiBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Acme\ApiBundle\Form\CategoryType;

class CategoryControllerTest extends ApiTestCase
{

    public function testJsonGetCategoryAction()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData'
            )
        );
        $client = $this->createJsonRequest(
            'GET',
            $this->getUrl('api_1_get_category', array('id' => 1))
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['categories']['id']), $content);
        $this->assertEquals(1, $decoded['categories']['id'], $content);
        $this->assertEquals('First Category', $decoded['categories']['name'], $content);
    }

    public function testJsonGetCategoriesAction()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData'
            )
        );

        $client = $this->createJsonRequest(
            'GET',
            $this->getUrl('api_1_get_categories')
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = $response->getContent();
        $decoded = json_decode($content, true);

        $this->assertTrue(isset($decoded['categories']));
        $this->assertTrue(count($decoded['categories']) == 2);

        $this->assertEquals(1, $decoded['categories'][0]['id']);
        $this->assertEquals('First Category', $decoded['categories'][0]['name']);

        $this->assertEquals(2, $decoded['categories'][1]['id']);
        $this->assertEquals('Second Category', $decoded['categories'][1]['name']);
    }

    public function testJsonPostCategoryAction()
    {
        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_categories'),
            $this->createJsonCategory('a name')
        );

        $this->assertJsonResponse($client->getResponse(), 201);
    }

    public function testJsonPostCategoryActionWithBadParameters()
    {
        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_categories'),
            $this->createJsonCategory('')
        );
        $this->assertJsonResponse($client->getResponse(), 400);

        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_categories'),
            'bad'
        );
        $this->assertJsonResponse($client->getResponse(), 400);
    }

    public function test404BadRoute()
    {
        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_categories') . 'badroute'
        );
        $this->assertJsonResponse($client->getResponse(), 404);
    }

    public function testJsonPutCategoryActionShouldModify()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData'
            )
        );

        $client = $this->createJsonRequest(
            'PUT',
            $this->getUrl('api_1_put_category', array('id' => 1)),
            $this->createJsonCategory('new name')
        );

        $this->assertJsonResponse($client->getResponse(), 202);
        $content = $client->getResponse()->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['category']));
        $this->assertEquals('new name', $decoded['category']['name']);
    }

    public function testJsonPutCategoryActionShouldCreate()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData'
            )
        );
        $client = static::createClient();

        $client = $this->createJsonRequest(
            'PUT',
            $this->getUrl('api_1_put_category', array('id' => 0)),
            $this->createJsonCategory('new category')
        );

        $this->assertJsonResponse($client->getResponse(), 201, true);
        $content = $client->getResponse()->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['category']));
        $this->assertEquals('new category', $decoded['category']['name']);
    }

    /**
     * Create a nicely formatted json category
     *
     * @param string $name
     *
     * @return string
     */
    protected function createJsonCategory($name)
    {
        $arr = array(CategoryType::NAME =>
            array(
                'name' => $name
            )
        );

        return json_encode($arr);
    }
}
