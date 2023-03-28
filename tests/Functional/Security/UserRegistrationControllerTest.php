<?php

namespace App\Tests\Functional\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserRegistrationControllerTest extends WebTestCase
{
    public function testValidation()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/user/registration/',
            [],
            [],
            [],
            '{"email":"test@user.com","password":"passwordTest"}'
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testInvalidation()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/user/registration/',
            [],
            [],
            [],
            '{"email":"test user com","password":"passwordTest"}'
        );

        $response = $client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}