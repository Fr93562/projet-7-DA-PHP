<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use \Firebase\JWT\JWT;
use App\Entity\User;

/**
 * Gère les tokens
 */ 
class Auth 
{
    
    /**
     * Gènère un token en fonction du name et du password de l'User
     */ 
    public function sign($data)
    {
        $key = "authentification";
        $payload = array(
            "name" =>  $data['name'],
            "password" => $data['password']
        );
    
        return JWT::encode($payload, $key);
    }

}
