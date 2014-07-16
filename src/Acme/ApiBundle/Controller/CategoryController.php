<?php

namespace Acme\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Acme\ApiBundle\Entity\Category;
use Acme\ApiBundle\Form\CategoryType;
use Acme\ApiBundle\Exception\InvalidFormException;

class CategoryController extends FOSRestController
{

    /**
     * Get single category,
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Category for a given id",
     *   output = "Acme\ApiBundle\Entity\Category",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the category is not found"
     *   }
     * )
     *
     * @param int     $id      the category id
     *
     * @return Response
     *
     * @throws NotFoundHttpException when page not exist
     */
    public function getCategoryAction($id)
    {
        $category = $this->container
                ->get('acme_api.category_handler')
                ->get($id);
        if (!$category instanceof Category) {
            throw new NotFoundHttpException(
                sprintf('The category \'%s\' was not found.', $id)
            );
        }

        $view = $this->view(array('categories' => $category), Codes::HTTP_OK)
                ->setTemplate("AcmeApiBundle:Category:getCategory.html.twig")
                ->setTemplateVar('category')
        ;

        return $this->handleView($view);
    }

    /**
     * List all categorys
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Lists all the categorys",
     *   output = "Acme\ApiBundle\Entity\Category"
     * )
     *
     * @return Response
     */
    public function getCategoriesAction()
    {
        $categorys = $this->container
                ->get('acme_api.category_handler')
                ->getAll();

        $view = $this->view(array('categories' => $categorys), Codes::HTTP_OK)
                ->setTemplate("AcmeApiBundle:Category:getCategorys.html.twig")
                ->setTemplateVar('categorys')
        ;

        return $this->handleView($view);
    }

    /**
     * Create an Category from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new category from the submitted data.",
     *   input = "Acme\ApiBundle\Form\CategoryType",
     *   output = "Acme\ApiBundle\Entity\Category",
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
    public function postCategoriesAction(Request $request)
    {
        try {
            $obj = $this->container->get('acme_api.category_handler')->post(
                $request->request->get(CategoryType::NAME)
            );

            $view = $this->view(array('categories' => $obj), Codes::HTTP_CREATED)
                    ->setTemplate("AcmeApiBundle:Category:getCategory.html.twig")
                    ->setTemplateVar('category')
            ;

            return $this->handleView($view);
        } catch (InvalidFormException $exception) {

            return $this->handleFormException($exception);
        }
    }

    /**
     * Presents the form to use to create a new category.
     *
     * @return Response
     */
    public function newCategoryAction()
    {
        $form = $this->createForm(
            new CategoryType(),
            null,
            array(
                'action' => $this->generateUrl('api_1_post_category')
            )
        );
        $view = $this->view(array('form' => $form))
                ->setTemplate("AcmeApiBundle:Category:newCategory.html.twig")
                ->setTemplateVar('form')
        ;

        return $this->handleView($view);
    }

    /**
     * Update existing category from the submitted data or create a new category
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Acme\ApiBundle\Form\CategoryType",
     *   output = "Acme\ApiBundle\Entity\Category",
     *   statusCodes = {
     *     201 = "Returned when the Category is created",
     *     202 = "Returned when updated",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the category id
     *
     * @return Response
     *
     * @throws NotFoundHttpException when category not exist
     */
    public function putCategoryAction(Request $request, $id)
    {
        try {
            if (!($category = $this->container->get('acme_api.category_handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $category = $this->container->get('acme_api.category_handler')->post(
                    $request->request->get(CategoryType::NAME)
                );
            } else {
                $statusCode = Codes::HTTP_ACCEPTED;
                $handler = $this->container->get('acme_api.category_handler');
                $category = $handler->put(
                    $category,
                    $request->request->get(CategoryType::NAME)
                );
            }

            $view = $this->view(array('category' => $category), $statusCode)
                    ->setTemplate("AcmeApiBundle:Category:getCategory.html.twig")
                    ->setTemplateVar('category')
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
            ->setTemplate("AcmeApiBundle:Category:newCategory.html.twig")
            ->setTemplateVar('form')
        ;

        return $this->handleView($view);
    }
}
