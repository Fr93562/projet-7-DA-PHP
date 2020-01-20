<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


use App\Entity\User;
use App\Entity\Client;
use App\Entity\Product;
use App\Form\ClientType;
use App\Service\Serial;

/**
 * Gère les paths de l'objet User, permet le CRUD de cet objet
 */
class ClientController extends AbstractController
{
    /**
     * Récupère la requête et crée un objet User en base de données
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/clients/", name="client_add", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $userData = $data['user'];

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByName($userData);

        $jsonContent = new Serial();
        $output = null;

        if(!is_null($user)) {

            $client = new Client();
            $client ->setName($data['name'])
                    ->setUsername($data['username'])
                    ->setAddress($data['address'])
                    ->setPhoneNumber($data['phoneNumber'])
                    ->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            $response = new Response("Created", 201);
            $output = "Le client a été ajouté.";

        } else {

            $response = new Response("Bad request", 400);
            $output = "Le client n'a pas été rajouté. L'user associé n'existe pas.";
        }

        return $response->setContent(json_encode($output));
    }


    /**
     * Recherche et affiche un objet Client
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/clients/{client}", name="client_show", methods={"GET","HEAD"})
     */
    public function show(string $username)
    {
        $clientRepository = $this->getDoctrine()->getRepository(Client::class);
        $client = $clientRepository->findOneByUsername($username);

        $response = new Serial(); 
        return $response->Serialize($client);
    }

    /**
     * Affiche tout les objets User en base de données
     * 
     * @IsGranted("ROLE_ADMIN")
     * @Route("/clients", name="client_showAll", methods={"GET","HEAD"})
     */
    public function showAll()
    {
        $clientRepository = $this->getDoctrine()->getRepository(Client::class);
        $clients = $clientRepository->findAll();

        foreach ( $clients as $client){
            
            $client->setUser(null);
        }

        $response = new Serial(); 
        return $response->Serialize($clients);
    }

    /**
     * Affiche tout les objets User appartenant à un objet Customer
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/clients/user/{name}", name="client_showFilterCustomer", methods={"GET","HEAD"})
     */
    public function showFilterCustomer(string $name)
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByName($name);

        $clientRepository = $this->getDoctrine()->getRepository(Client::class);
        $clients = $userRepository->findByUser($user);

        $response = new Serial();
        return $response->Serialize($clients);
    }

    /**
     * Supprime un objet User de la base de données
     * 
     * @IsGranted("ROLE_USER")
     * @Route("/clients/", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $clientRepository = $this->getDoctrine()->getRepository(Client::class);
        $client = $clientRepository->findOneByPhoneNumber($data['phoneNumber']);

        $jsonContent = new Serial();
        $output = null;

        if(!is_null($client)) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($client);
            $em->flush();

            $response = new Response("OK", 200);
            $output = "Le client a bien été supprimé.";

        } else {

            $response = new Response("Not found", 404);
            $output = "Le client n'a pas été trouvé.";
        }

        return $response->setContent($jsonContent->Serialize($output));
    }


}
