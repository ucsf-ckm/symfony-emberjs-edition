<?php

namespace Acme\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Acme\ApiBundle\Entity\Product;
use Acme\ApiBundle\Form\ProductType;
use Acme\ApiBundle\Exception\InvalidFormException;

class ProductController extends FOSRestController
{

    /**
     * Get single product,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Product for a given id",
     *   output = "Acme\ApiBundle\Entity\Product",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the product is not found"
     *   }
     * )
     *
     * @param int     $id      the product id
     *
     * @return Response
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getProductAction($id)
    {
        $product = $this->container
                ->get('acme_api.product_handler')
                ->get($id);
        if (!$product instanceof Product) {
            throw new NotFoundHttpException(
                sprintf('The product \'%s\' was not found.', $id)
            );
        }

        $view = $this->view(array('product' => $product), Codes::HTTP_OK)
                ->setTemplate("AcmeApiBundle:Product:getProduct.html.twig")
                ->setTemplateVar('product')
        ;

        return $this->handleView($view);
    }

    /**
     * List all products
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Lists all the products",
     *   output = "Acme\ApiBundle\Entity\Product"
     * )
     *
     * @return Response
     */
    public function getProductsAction()
    {
        $products = $this->container
                ->get('acme_api.product_handler')
                ->getAll();

        $view = $this->view(array('products' => $products), Codes::HTTP_OK)
                ->setTemplate("AcmeApiBundle:Product:getProducts.html.twig")
                ->setTemplateVar('products')
        ;

        return $this->handleView($view);
    }

    /**
     * Create an Product from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new product from the submitted data.",
     *   input = "Acme\ApiBundle\Form\ProductType",
     *   output = "Acme\ApiBundle\Entity\Product",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     *
     * @param Request $request the request object
     *
     * @return Response
     */
    public function postProductAction(Request $request)
    {
        try {
            $obj = $this->container->get('acme_api.product_handler')->post(
                $request->request->get(ProductType::NAME)
            );

            $view = $this->view(array('product' => $obj), Codes::HTTP_CREATED)
                    ->setTemplate("AcmeApiBundle:Product:getProduct.html.twig")
                    ->setTemplateVar('product')
            ;

            return $this->handleView($view);
        } catch (InvalidFormException $exception) {

            return $this->handleFormException($exception);
        }
    }

    /**
     * Presents the form to use to create a new product.
     *
     * @return Response
     */
    public function newProductAction()
    {
        $form = $this->createForm(
            new ProductType(),
            null,
            array(
                'action' => $this->generateUrl('api_1_post_product')
            )
        );
        $view = $this->view(array('form' => $form))
                ->setTemplate("AcmeApiBundle:Product:newProduct.html.twig")
                ->setTemplateVar('form')
        ;

        return $this->handleView($view);
    }

    /**
     * Update existing product from the submitted data or create a new product
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Acme\ApiBundle\Form\ProductType",
     *   output = "Acme\ApiBundle\Entity\Product",
     *   statusCodes = {
     *     201 = "Returned when the Product is created",
     *     202 = "Returned when updated",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the product id
     *
     * @return Response
     *
     * @throws NotFoundHttpException when product not exist
     */
    public function putProductAction(Request $request, $id)
    {
        try {
            if (!($product = $this->container->get('acme_api.product_handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $product = $this->container->get('acme_api.product_handler')->post(
                    $request->request->get(ProductType::NAME)
                );
            } else {
                $statusCode = Codes::HTTP_ACCEPTED;
                $handler = $this->container->get('acme_api.product_handler');
                $product = $handler->put(
                    $product,
                    $request->request->get(ProductType::NAME)
                );
            }

            $view = $this->view(array('product' => $product), $statusCode)
                    ->setTemplate("AcmeApiBundle:Product:getProduct.html.twig")
                    ->setTemplateVar('product')
            ;

            return $this->handleView($view);
        } catch (InvalidFormException $exception) {

            return $this->handleFormException($exception);
        }
    }

    /**
     * Generate a response for form validation errors
     *
     * @param \Acme\ApiBundle\Exception\InvalidFormException $exception
     * @return Response
     */
    protected function handleFormException(InvalidFormException $exception)
    {
        $form = $exception->getForm();
        $view = $this->view($form, Codes::HTTP_BAD_REQUEST)
            ->setTemplate("AcmeApiBundle:Product:newProduct.html.twig")
            ->setTemplateVar('form')
        ;

        return $this->handleView($view);
    }
}
