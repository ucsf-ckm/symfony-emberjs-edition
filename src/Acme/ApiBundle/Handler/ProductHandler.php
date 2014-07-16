<?php
namespace Acme\ApiBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

use Acme\ApiBundle\Entity\Product;
use Acme\ApiBundle\Form\ProductType;
use Acme\ApiBundle\Exception\InvalidFormException;

class ProductHandler
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
     * Get an Product.
     *
     * @param mixed $id
     *
     * @return Product
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get all Products
     *
     * @return Product[]
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Create a new Product.
     *
     * @param Request $request
     *
     * @return Product
     */
    public function post(array $parameters)
    {
        $product = new $this->entityClass();
        return $this->processForm($product, $parameters, 'POST');
    }

    /**
     * Edit an Obejctive, or create if it doesn't exist.
     *
     * @param Product     $product
     * @param array         $parameters
     *
     * @return Product
     */
    public function put(Product $product, array $parameters)
    {
        return $this->processForm($product, $parameters, 'PUT');
    }

    /**
     * Processes the form.
     *
     * @param Product     $product
     * @param array         $parameters
     * @param String        $method
     *
     * @return Product
     *
     * @throws \Acme\ApiBundle\Exception\InvalidFormException
     */
    private function processForm(Product $product, array $parameters, $method)
    {
        $form = $this->formFactory->create(
            new ProductType(),
            $product,
            array('method' => $method)
        );
        $form->submit($parameters);
        if ($form->isValid()) {
            //re-request the data for testability
            $product = $form->getData();
            $this->om->persist($product);
            $this->om->flush($product);

            return $product;
        }
        
        throw new InvalidFormException('Invalid submitted data', $form);
    }
}
