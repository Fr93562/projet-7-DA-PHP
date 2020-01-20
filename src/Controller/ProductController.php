<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Service\Serial;
use App\Entity\Product;
use App\Entity\Brand;
use App\Form\ProductType;


/**
 * Gère les paths de l'objet Product, permet le CRUD de cet objet
 */
class ProductController extends AbstractController
{

    /**
     * Récupère la requête et crée un objet Product en base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/products/", name="product_add", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->query->get('Content-Type'));
        $brandRepository = $this->getDoctrine()->getRepository(Brand::class);
        $brand = $brandRepository->findOneByName($data->{'customer'});

        $jsonContent = new Serial();
        $output = null;

        $product = new Product();
        $product->setReference($data->{'reference'})
                ->setColor($data->{'color'})
                ->setStorage($data->{'storage'})
                ->setDelay($data->{'delay'})
                ->setPicture($data->{'picture'})
                ->setStock($data->{'stockage'})
                ->setBrand($brand);

        $form = $this->createForm(ProductType::class, $product);        
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        $response = new Response("Created", 201);
        $output = $product;

        return $response->setContent($jsonContent->Serialize($output));
    }

    /**
     * Recherche et affiche un objet Product
     * 
     * @IsGranted("ROLE_USER")
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
     * Affiche tout les objets Product en base de données
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/products", name="product_showAll", methods={"GET","HEAD"})
     */
    public function showAll()
    {
        $productsRepository = $this->getDoctrine()->getRepository(Product::class);
        $products = $productsRepository->findAll();

        $response = new Serial(); 
        return $response->Serialize($products);
    }

    /**
     * Supprime un objet Product de la base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/products/", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $data = json_decode($request->query->getContent(), true);

        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->findOneByMail($data['reference']);

        $jsonContent = new Serial();
        $output = null;

        if(!is_null($product)) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();

            $response = new Response("OK", 200);
            $output = "Le product a bien été supprimé.";

        } else {

            $response = new Response("Not found", 404);
            $output = "Le product n'a pas été trouvé.";
        }

        return $response->setContent($jsonContent->Serialize($output));
    }
}
