<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class ProductController extends FOSRestController
{
    /**
     * @Rest\Get(
     *      path="/products",
     *      name="product_list"
     * )
     * @Rest\View()
     */
    public function index(ProductRepository $manager)
    {
        return $manager->findAll();
    }
}
