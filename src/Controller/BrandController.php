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
use App\Form\BrandType;

/**
 * Gère les paths de l'objet Brand, permet le CRUD de cet objet
 */
class BrandController extends AbstractController
{
    
    /**
     * Récupère la requête et crée un objet Brand en base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/brands/", name="brand_add", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->query->get('Content-Type'));

        $jsonContent = new Serial();
        $output = null;

        $brand = new Brand();
        $brand->setName($data->{'name'});

        $form = $this->createForm(BrandType::class, $brand);        
        $em = $this->getDoctrine()->getManager();
        $em->persist($brand);
        $em->flush();

        $response = new Response("Created", 201);
        $output = $brand;

        return $response->setContent($jsonContent->Serialize($output));
    }


    /**
     * Affiche tout les objets Brand en base de données
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/brands", name="product_showAll", methods={"GET","HEAD"})
     */
    public function showAll()
    {
        $brandsRepository = $this->getDoctrine()->getRepository(Brand::class);
        $brand = $brandsRepository->findAll();

        $response = new Serial(); 
        return $response->Serialize($brand);
    }

    /**
     * Supprime un objet Brand de la base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/brands/", name="brand_delete", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $data = json_decode($request->query->getContent(), true);
        $brandsRepository = $this->getDoctrine()->getRepository(Brand::class);
        $brand = $brandsRepository->findOneByName($data['name']);


        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $product = $productRepository->findByBrand($brand);

        $jsonContent = new Serial();
        $output = null;

        if(!is_null($product)) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($brand);
            $em->flush();

            $response = new Response("OK", 200);
            $output = "Le brand a bien été supprimé.";

        } else {

            $response = new Response("Not found", 404);
            $output = "Brand n'a pas été supprimé. Des users en lien avec existent.";
        }

        return $response->setContent($jsonContent->Serialize($output));
    }
}
