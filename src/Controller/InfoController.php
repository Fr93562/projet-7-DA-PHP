<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\Serial;

/**
 * Gère les paths en lien avec le fonctionnement de l'API
 */
class InfoController extends AbstractController
{
    /**
     * Affiche les informations de l'API
     * @Route("/info", name="info")
     */
    public function info()
    {

        $jsonContent = new Serial();
        $response = new Response("OK", 200);
        $responseContent = [    "Projet" => "Projet 7 - Openclassrooms PHP Symfony",
                                "Version" => "0.1",
                                "Format utilisé" => "Json",
                                "Fonctionnalités de product" => "Lecture",
                                "Fonctionnalités d'user" => "Création, recherche, lecture, filtre et suppression",
                                "Adresse github" => "https://github.com/Fr93562/projet-7-DA-PHP",
                                "Technologies utilisées" => "PHP 7 / Symfony 4"];
        
        return $response->setContent(json_encode($responseContent));
    }

    /**
     * Message d'erreur qui renvoie vers la path info
     * @Route("/error", name="error")
     */
    public function error()
    {
        $response = new Response("Bad Request", 400 );
        $responseContent = "Erreur. Pour plus d'informations sur l'Api, rendez-vous sur: http://localhost:8000/info";
        return $response->setContent(json_encode($responseContent));
    }
}
