<?php
namespace Acme\ApiBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

use Acme\ApiBundle\Entity\Category;
use Acme\ApiBundle\Form\CategoryType;
use Acme\ApiBundle\Exception\InvalidFormException;

class CategoryHandler
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get an Category.
     *
     * @param mixed $id
     *
     * @return Category
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all Categorys
     *
     * @return Category[]
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Create a new Category.
     *
     * @param Request $request
     *
     * @return Category
     */
    public function post(array $parameters)
    {
        $category = new $this->entityClass();
        return $this->processForm($category, $parameters, 'POST');
    }

    /**
     * Edit an Obejctive, or create if it doesn't exist.
     *
     * @param Category     $category
     * @param array         $parameters
     *
     * @return Category
     */
    public function put(Category $category, array $parameters)
    {
        return $this->processForm($category, $parameters, 'PUT');
    }

    /**
     * Processes the form.
     *
     * @param Category     $category
     * @param array         $parameters
     * @param String        $method
     *
     * @return Category
     *
     * @throws \Acme\ApiBundle\Exception\InvalidFormException
     */
    private function processForm(Category $category, array $parameters, $method)
    {
        $form = $this->formFactory->create(
            new CategoryType(),
            $category,
            array('method' => $method)
        );
        $form->submit($parameters);
        if ($form->isValid()) {
            //re-request the data for testability
            $category = $form->getData();
            $this->om->persist($category);
            $this->om->flush($category);

            return $category;
        }
        
        throw new InvalidFormException('Invalid submitted data', $form);
    }
}
