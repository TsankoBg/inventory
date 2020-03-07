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
        $form=$this->get('form.factory')->create(ProductType::class,$product,array(
            'action' => $this->generateUrl('add-product'),
            'method' => 'POST',));
        return $this->render('app/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        /**
     * @Route("/price", name="/price")
     */
    public function pricePage()
    {
        return $this->render('app/pricePage.html.twig', [
        ]);
    }
}
