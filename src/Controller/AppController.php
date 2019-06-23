<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductType;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="/")
     */
    public function index()
    {
        $product=new Product();
        $form=$this->get('form.factory')->create(ProductType::class,$product);
        return $this->render('app/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
