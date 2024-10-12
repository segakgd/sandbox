<?php

namespace App\Controller;

use Segakgd\FlexbeApiClient\Dto\FlexbeApiClientDto;
use Segakgd\FlexbeApiClient\FlexbeApiManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    public function __construct(private readonly FlexbeApiManager $flexbeApiManager)
    {
    }

    #[Route('/test', name: 'test')]
    public function test(): JsonResponse
    {
        $domain = 'domain.com'; // Replace with your Flexbe domain
        $apiKey = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'; // Replace with your Flexbe API key

        $clientFlexbeDto = new FlexbeApiClientDto($domain, $apiKey);

        $leads = $this->flexbeApiManager->getLeads($clientFlexbeDto);

        dd($leads);

        return new JsonResponse();
    }
}
