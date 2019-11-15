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
     * 
     */
    public function getProducts(ProductService $productService)
    {
        $keyword = strval($_POST['query']);
        $search_param = "{$keyword}%";
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findByName($search_param);
        return new Response(json_encode($products, JSON_UNESCAPED_UNICODE));
    }

    /**
     * @Route("/product/{barcode}", name="product")
     */
    public function getProduct(Product $product, ProductService $productService)
    {
        //$product = $productService->getProduct($product_id);
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
       // if ($request->isMethod('POST')) {
            $file = $product->getFile();
            if(!empty($file))
            {
                $fileName = $fileUploader->upload($file);
                $product->setImage($fileName);
            }
            
        $name=$product->getName();
        $quantity=$product->getQuantity();
        $price=$product->getPrice();
        $priceBought=$product->getPriceBought();
        $image=$product->getImage();

        $onDuplicate= " ON DUPLICATE KEY UPDATE quantity=quantity + $quantity";
        if(!empty($name))
        {
            $onDuplicate=$onDuplicate. ",name='$name'";
        }
        if(!empty($price))
        {
            $onDuplicate=$onDuplicate. ",price=$price";
        }
        if(!empty($priceBought))
        {
            $onDuplicate=$onDuplicate. ",price_bought=$priceBought";
        }
        if(!empty($image))
        {
            $onDuplicate=$onDuplicate. ",image='$image'";
        }

        $product->setDateUpdated(\DateTime::createFromFormat('%Y-%m-%d %H:%i:%s', date('%Y-%m-%d %H:%i:%s')));
            // your code
           $stmt= $em->getConnection()->prepare("INSERT INTO product (barcode, name, quantity, price, price_bought, image, date_updated) 
            VALUES (:barcode , :name, :quantity, :price, :price_bought, :image, :date_updated)". $onDuplicate);
            $stmt->execute([
            'barcode'=>$product->getBarcode(),
            'name'=>$product->getName(),
            'quantity'=>$product->getQuantity(),
            'price'=>$product->getPrice(),
            'price_bought'=>$product->getPriceBought(),
            'image'=>$product->getImage(),
            'date_updated'=>$product->getDateUpdated()->format('Y-m-d H:i:s')]);
            return new Response(json_encode($product));
        }
    }

