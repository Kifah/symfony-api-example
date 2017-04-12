<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class ApiContext extends Assert implements Context
{


    const BASE_URL = 'http://127.0.0.1/app_dev.php';
    const CORRECT_USERNAME = 'Foo1';
    const CORRECT_PASSWORD = 'bariooo';
    const AUTH_PATH = '/api/token';
    const AUTH_TOKEN_KEY = 'mytoken';
    private $client;
    private $token;
    private $responseCode;
    private $responseContent;
    private $headers = [];
    private $contentType;

    /**
     * @var $response \GuzzleHttp\Psr7\Response
     */
    private $response;


    public function __construct(ClientInterface $client)
    {

        $this->client = $client;


    }


    /**
     * @Then I should get Status Code :arg1
     * @param int $statusCode
     */
    public function iShouldGetStatusCode(int $statusCode)
    {
        $this->assertEquals($statusCode, $this->responseCode);

    }

    /**
     * @Then I should get the Json Content
     * @param PyStringNode $payLoad
     */
    public function iShouldGetTheJsonContent(PyStringNode $payLoad)
    {
        $rawString = $payLoad->getRaw();
        $expectedContent = json_decode($rawString, true);
        $realContent = json_decode($this->responseContent, true);
        $this->assertEquals($expectedContent, $realContent);
        $this->assertEquals('application/json', $this->contentType);
    }

    /**
     * @Given /^I send a GET request to "([^"]*)"$/
     */
    public function iSendAGETRequestTo(string $path)
    {
        return $this->prepareRequest('GET', $path, [], $this->headers);
    }

    private function prepareRequest(string $method, string $path, array $payload = [], array $headers = [])
    {
        $options['headers'] = $headers;
        $options['json'] = $payload;

        try {
            $this->response = $this->client->request($method, self::BASE_URL . $path, $options);
            $this->responseCode = $this->response->getStatusCode();
            $this->responseContent = $this->response->getBody()->getContents();
            $this->handleToken();
            $this->contentType = $this->response->getHeader('Content-Type')[0];
        } catch (ClientException $e) {
            $this->responseCode = $e->getResponse()->getStatusCode();
            $this->responseContent = $e->getResponse()->getBody()->getContents();
            $this->contentType = $e->getResponse()->getHeader('Content-Type')[0];

        }
    }

    private function handleToken()
    {
        $responseArray = json_decode($this->responseContent, true);
        if (is_array($responseArray) && array_key_exists('token', $responseArray)) {
            $this->token = $responseArray['token'];
        }


    }

    /**
     * @Given /^I authenticate with username:"([^"]*)" and pass:"([^"]*)"$/
     */
    public function iAuthenticateWithUsernameAndPass(string $username, string $pass)
    {

        $method = "POST";
        $payload = ['username' => $username, 'password' => $pass];
        $this->prepareRequest($method, self::AUTH_PATH, $payload);

    }

    /**
     * @Then /^I succesfully authenticate and have token$/
     */
    public function iSuccesfullyAuthenticateAndHaveToken()
    {


        $responseArray = json_decode($this->responseContent, true);
        $this->assertArrayHasKey('token', $responseArray);
        $this->assertEquals(200, $this->responseCode);
        $this->token = $responseArray['token'];
        $this->headers[self::AUTH_TOKEN_KEY] = 'Bearer ' . $this->token;

    }

    /**
     * @Given /^I am authenticated for the API$/
     */
    public function iAmAuthenticatedForTheAPI()
    {
        if ($this->tokenNotConfigured()) {
            $this->headers[self::AUTH_TOKEN_KEY] = 'Bearer ' . $this->token;
        }
        {
            $this->authenticateCorrectly();
        }

    }

    private function authenticateCorrectly()
    {
        $payload = ['username' => self::CORRECT_USERNAME, 'password' => self::CORRECT_PASSWORD];
        $this->prepareRequest('POST', self::AUTH_PATH, $payload);
        if ($this->tokenNotConfigured()) {
            $this->headers[self::AUTH_TOKEN_KEY] = 'Bearer ' . $this->token;
        }
    }

    /**
     * @return bool
     */
    private function tokenNotConfigured(): bool
    {
        return null != $this->token && !array_key_exists(self::AUTH_TOKEN_KEY, $this->headers);
    }

}
