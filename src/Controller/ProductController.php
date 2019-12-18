<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\Serial;

use App\Entity\Product;

class ProductController extends AbstractController
{

    /**
     * Renvoie un produit sous forme d'une requête JSON
     * Récupère l'objet en base. Puis le passage en argument par le service Serial au niveau de la réponse
     * 
     * @Route("/products/{reference}", name="product_show", methods={"GET","HEAD"})
     */
    public function show(string $reference)
    {

        $productsRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productsRepository->findOneByReference($reference);

        $response = new Serial(); 
        return $response->Serialize($product);

    }

    /**
     * Renvoie la liste des produits sous forme d'une requête JSON
     * Récupère l'objet en base. Puis le passage en argument par le service Serial au niveau de la réponse
     * 
     * @Route("/products", name="product_showAll", methods={"GET","HEAD"})
     */
    public function showAll()
    {

        $productsRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productsRepository->findAll();

        $response = new Serial(); 
        return $response->Serialize($products);
    }
}
