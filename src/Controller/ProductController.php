<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products")
     */
    public function getProducts(ProductService $productService)
    {
        $products = $productService->getProducts();
        return new Response(json_encode($products, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @Route("/product/{product_id}", name="product")
     */
    public function getProduct($product_id, ProductService $productService)
    {
        $product = $productService->getProduct($product_id);
        return new Response(json_encode($product, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @Route("/add-product", name="add-product")
     */
    public function addProduct(Request $request,FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $form = $this->get('form.factory')->create(ProductType::class, $product);
        $form->handleRequest($request);
        if ($request->isMethod('post')) {
            $file = $product->getFile();
            $fileName = $fileUploader->upload($file);
            $product->setImage($fileName);
            // your code
           $stmt= $em->getConnection()->prepare("INSERT INTO product (barcode, name, quantity, price, price_bought, image) 
            VALUES (:barcode , :name, :quantity, :price, :price_bought, :image )
            ");
            $stmt->execute([
            'barcode'=>$product->getBarcode(),
            'name'=>$product->getName(),
            'quantity'=>$product->getQuantity(),
            'price'=>$product->getPrice(),
            'price_bought'=>$product->getPriceBought(),
            'image'=>$product->getImage()]);
            return new Response(json_encode($product));
        }
    }
}
