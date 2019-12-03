<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Product;

class Serial extends AbstractController
{

    /**
     * Méthode utilisée pour les objets Products
     * Serialise l'objet et renvoie le résultat
    **/
    
    public function productSerialize($data) 
    {

        $encoder = new JsonEncoder();

        $maxDepthHandler = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return '/foos/'.$innerObject->id;
        };
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
            AbstractObjectNormalizer::MAX_DEPTH_HANDLER => $maxDepthHandler,
        ];

        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], [$encoder]);
        $productSerialize = $serializer->normalize($data, null, [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);

        $response = new JsonResponse($productSerialize);

        return $response;
    }
}
