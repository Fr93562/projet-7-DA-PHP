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

use App\Entity\User;
use App\Entity\Customer;
use App\Entity\Product;

use App\Form\UserType;

use App\Service\Serial;

class UserController extends AbstractController
{
    /**
     * Rajoute un user à la base de données
     * Prends en argument l'objet Request
     * Récupère le JSON à partir de Request puis cherche le customer en base de données
     * Si le customer existe, l'utilisateur est crée
     * 
     * @Route("/users/", name="user_add", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = json_decode($request->query->get('user'));
        $customerData = $data->{'customer'};

        $CustomerRepository = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $CustomerRepository->findOneByName($customerData->{'name'});

        $jsonContent = new Serial();
        $output = null;

        if(!is_null($customer)) {

            $user = new user();
            $user   ->setName($data->{'name'})
                    ->setMail($data->{'mail'})
                    ->setUsername($data->{'username'})
                    ->setNumber($data->{'number'})
                    ->setAddress($data->{'address'})
                    ->setCustomer($customer);

            $form = $this->createForm(UserType::class, $user);        
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $response = new Response("Created", 201);
            $output = $user;

        } else {

            $response = new Response("Bad request", 400);
            $output = "L'user n'a pas été rajouté. Le customer associé n'existe pas.";
        }

        return $response->setContent($jsonContent->Serialize($output));
    }


    /**
     * Renvoie un produit sous forme d'une requête JSON
     * Récupère l'objet en base. Puis le passage en argument par le service Serial au niveau de la réponse
     * 
     * @Route("/users/{username}", name="user_show", methods={"GET","HEAD"})
     */
    public function show(string $username)
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByUsername($username);

        $response = new Serial(); 
        return $response->Serialize($user);
    }

    /**
     * Renvoie la liste des produits sous forme d'une requête JSON
     * Récupère l'objet en base. Puis le passage en argument par le service Serial au niveau de la réponse
     * 
     * @Route("/users", name="user_showAll", methods={"GET","HEAD"})
     */
    public function showAll()
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $products = $userRepository->findAll();

        $response = new Serial(); 
        return $response->Serialize($products);
    }

    /**
     * Renvoie la liste des produits sous forme d'une requête JSON
     * Récupère l'objet en base. Puis le passage en argument par le service Serial au niveau de la réponse
     * 
     * @Route("/users/customer/{name}", name="user_showFilterCustomer", methods={"GET","HEAD"})
     */
    public function showFilterCustomer(string $name)
    {
        $CustomerRepository = $this->getDoctrine()->getRepository(Customer::class);
        $customer = $CustomerRepository->findOneByName($name);

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepository->findByCustomer($customer);

        $response = new Serial();
        return $response->Serialize($users);
    }

    /**
     * Supprime un user de la base de données
     * Prends l'objet Request en argument
     * Récupère le JSON à partir de Request puis cherche l'user en base de données à partir de son mail
     * Supprime l'user s'il est trouvé
     * 
     * @Route("/users/", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request)
    {
        $data = json_decode($request->query->get('user'));

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneByMail($data->{'mail'});

        $jsonContent = new Serial();
        $output = null;

        if(!is_null($user)) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $response = new Response("OK", 200);
            $output = "L'user a bien été supprimé.";

        } else {

            $response = new Response("Not found", 404);
            $output = "L'user n'a pas été trouvé.";
        }

        return $response->setContent($jsonContent->Serialize($output));
    }
}
