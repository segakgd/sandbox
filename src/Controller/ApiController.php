<?php

namespace App\Controller;

use Segakgd\FlexbeApiClient\Dto\FlexbeApiClientDto;
use Segakgd\FlexbeApiClient\FlexbeApiManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    #[Route('/', name: 'test')]
    public function test(): JsonResponse
    {
        $domain = 'domain.com'; // Replace with your Flexbe domain
        $apiKey = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'; // Replace with your Flexbe API key

        $clientFlexbeDto = new FlexbeApiClientDto($domain, $apiKey);

        $flexbeApiManager = new FlexbeApiManager();

        $leads = $flexbeApiManager->getLeads($clientFlexbeDto);

        dd($leads);

        return new JsonResponse();
    }
}
