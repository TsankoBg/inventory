<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductService
{

    private $em;

    public function __construct(EntityManagerInterface  $entityManager)
    {
        $this->em = $entityManager;
    }


    public function getProduct($product_id)
    {
        $product = $this->em->getRepository(Product::class)->find($product_id);
        return $product;
    }
    public function getProductByBarcode($barcode)
    {
        $product = $this->em->getRepository(Product::class)->findOneBy(['barcode'=>$barcode]);
        return $product;
    }
    public function getProducts()
    {
        $products = $this->em->getRepository(Product::class)->findAll();
        return $products;
    }

}
