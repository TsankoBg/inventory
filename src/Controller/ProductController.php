<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function getProducts(ProductService $productService)
    {
        $products= $productService->getProducts();
        return new Response(json_encode($products, JSON_UNESCAPED_UNICODE));  
    }

    /**
     * @Route("/product/{product_id}", name="product")
     */
    public function getProduct($product_id, ProductService $productService)
    {
        $product= $productService->getProduct($product_id);
        return new Response(json_encode($product, JSON_UNESCAPED_UNICODE));
    }
}
