<?php

namespace Acme\ApiBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Acme\ApiBundle\Form\ProductType;

class ProductControllerTest extends ApiTestCase
{

    public function testJsonGetProductAction()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData',
                'Acme\ApiBundle\DataFixtures\ORM\LoadProductData'
            )
        );
        $client = $this->createJsonRequest(
            'GET',
            $this->getUrl('api_1_get_product', array('id' => 1))
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = $response->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['product']['id']), $content);
        $this->assertEquals(1, $decoded['product']['id'], $content);
        $this->assertEquals('First Product', $decoded['product']['name'], $content);
    }

    public function testJsonGetProductsAction()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData',
                'Acme\ApiBundle\DataFixtures\ORM\LoadProductData'
            )
        );

        $client = $this->createJsonRequest(
            'GET',
            $this->getUrl('api_1_get_products')
        );

        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);

        $content = $response->getContent();
        $decoded = json_decode($content, true);

        $this->assertTrue(isset($decoded['products']));
        $this->assertTrue(count($decoded['products']) == 2);

        $this->assertEquals(1, $decoded['products'][0]['id']);
        $this->assertEquals('First Product', $decoded['products'][0]['name']);

        $this->assertEquals(2, $decoded['products'][1]['id']);
        $this->assertEquals('Second Product', $decoded['products'][1]['name']);
    }

    public function testJsonPostProductAction()
    {
        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_product'),
            $this->createJsonProduct('a name', 'a description', 11, 1)
        );

        $this->assertJsonResponse($client->getResponse(), 201);
    }

    public function testJsonPostProductActionWithBadParameters()
    {
        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_product'),
            $this->createJsonProduct('', '', '', '')
        );
        $this->assertJsonResponse($client->getResponse(), 400);

        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_product'),
            'bad'
        );
        $this->assertJsonResponse($client->getResponse(), 400);
    }

    public function test404BadRoute()
    {
        $client = $this->createJsonRequest(
            'POST',
            $this->getUrl('api_1_post_product') . 'badroute'
        );
        $this->assertJsonResponse($client->getResponse(), 404);
    }

    public function testJsonPutProductActionShouldModify()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData',
                'Acme\ApiBundle\DataFixtures\ORM\LoadProductData'
            )
        );

        $client = $this->createJsonRequest(
            'PUT',
            $this->getUrl('api_1_put_product', array('id' => 1)),
            $this->createJsonProduct('new name', 'a description', 11, 1)
        );

        $this->assertJsonResponse($client->getResponse(), 202);
        $content = $client->getResponse()->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['product']));
        $this->assertEquals('new name', $decoded['product']['name']);
    }

    public function testJsonPutProductActionShouldCreate()
    {
        $this->loadFixtures(
            array(
                'Acme\ApiBundle\DataFixtures\ORM\LoadCategoryData',
                'Acme\ApiBundle\DataFixtures\ORM\LoadProductData'
            )
        );
        $client = static::createClient();

        $client = $this->createJsonRequest(
            'PUT',
            $this->getUrl('api_1_put_product', array('id' => 0)),
            $this->createJsonProduct('new product', 'a description', 12, 1)
        );

        $this->assertJsonResponse($client->getResponse(), 201, true);
        $content = $client->getResponse()->getContent();
        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['product']));
        $this->assertEquals('new product', $decoded['product']['name']);
    }

    /**
     * Create a nicely formatted json product
     *
     * @param string $name
     * @param string $description
     * @param string $price
     *
     * @return string
     */
    protected function createJsonProduct($name, $description, $price, $category)
    {
        $arr = array(ProductType::NAME =>
            array(
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category' => $category
            )
        );

        return json_encode($arr);
    }
}
