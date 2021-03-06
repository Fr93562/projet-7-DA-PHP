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
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Brand;
use App\Form\ProductType;

/**
 * Gère les paths de l'objet Customer, permet le CRUD de cet objet
 */
class UserController extends AbstractController
{

    /**
     * Récupère la requête et crée un objet Brand en base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/users/", name="user_add", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->query->get('Content-Type'));

        $jsonContent = new Serial();
        $output = null;

        $user = new Client();
        $user   ->setName($data->{'name'})
                    ->setRoles($data->{'role'})
                    ->setPassword($data->{'password'})
        ;

        //$form = $this->createForm(BrandType::class, $brand);        
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $response = new Response("Created", 201);
        $output = $user;

        return $response->setContent($jsonContent->Serialize($output));
    }


    /**
     * Affiche tout les objets Brand en base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/users", name="user_showAll", methods={"GET","HEAD"})
     */
    public function showAll()
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findAll();

        $response = new Serial(); 
        return $response->Serialize($user);
    }

    /**
     * Supprime un objet Brand de la base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/users/", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $data = json_decode($request->query->get('Content-Type'));
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByName($data->{'name'});


        $clientsRepository = $this->getDoctrine()->getRepository(Client::class);
        $clients = $clientsRepository->findByEntreprise($user);

        $jsonContent = new Serial();
        $output = null;

        if(!is_null($clients)) {

            foreach ($clients as $client){
                $client->setUser(null);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($clients);
            $em->remove($entreprise);
            $em->flush();

            $response = new Response("OK", 200);
            $output = "Le client a bien été supprimé.";

        } else {

            $response = new Response("Not found", 404);
            $output = "L'user n'a pas été supprimé. Des clients en lien avec existent.";
        }

        return $response->setContent($jsonContent->Serialize($output));
    }
}
