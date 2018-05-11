<?php

namespace App\Controller;

use App\Entity\Product;
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
    public function list(ProductRepository $manager)
    {
        return $manager->findAll();
    }

    /**
     * @Rest\Get(
     *      path="/products/{id}",
     *      name="product_detail",
     *      requirements = {"id"="\d+"}
     * )
     * @Rest\View()
     */
    public function detail(Product $product)
    {
        return $product;
    }
}
