<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use \Firebase\JWT\JWT;
use App\Entity\User;

use App\Service\Auth;


/**
 * Gère les routes liées à l'authentification
 */
class SecurityController extends AbstractController
{

    /**
     * Crée un token d'authentification en fonction des données Json
     * @Route("/login", name="app_login", methods={"POST"})
     */
    public function login(Request $request): Response
    {
        $response = new Response("Bad request", 405);
        $user = null;
        $output = "User not found";

        //var_dump($request->getContent(), true);

        if (json_decode($request->getContent(), true)['name'] != null) {

            $data = json_decode($request->getContent(), true);
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->findOneByName($data['name']);
        }

        if($user != null) {

            if( $user->getPassword() == $data['password']) {

                $response = new Response("OK", 200);
                $token = new Auth();
                $output = $token->sign($data);
                $key = "authentification";
            } 
        }
        return $response->setContent(json_encode($output));
    }
}
