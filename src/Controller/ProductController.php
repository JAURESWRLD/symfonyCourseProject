<?php

namespace App\Controller;

use App\classe\Search;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/nos-produits', name: 'app_products')]
    /**
     * Summary of index
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {


        $products= $this->entityManager->getRepository(Product::class)->findAll();

        $search= new Search();
        $form= $this->createForm(SearchType::class, $search);

        return $this->render('product/index.html.twig', [
            'products'=> $products,
            'form'=> $form->createView()
        ]);
    }

    #[Route('/Produit/{slug}', name: 'app_product')]
    /**
     * Summary of show
     * @param mixed $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($slug): Response
    {


        $product= $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if(!$product){
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/show.html.twig', [
            'product'=> $product
        ]);
    }
}
