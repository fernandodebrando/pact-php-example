<?php

require_once(__DIR__ . '/../src/ExampleTwoMeetupApiClient.php');
require_once(__DIR__ . '/../../example-one/test/MockHttpClient.php'); // <---- totally hi-jacking example one

use PHPUnit\Framework\TestCase;

class ExampleTwoMeetupAPIClientTest extends TestCase
{

    /**
     * @var \PhpPact\PactBuilder
     */
    protected static $build;

    const TEST_URL = "https://api.meetup.com";
    const CONSUMER_NAME = "ExampleTwoMeetupApiClient";
    const PROVIDER_NAME = "MeetupAPI";
    const PACT_DIR = "D:\\Temp\\pact-examples\\";
    const version = '2';


    public static function setUpBeforeClass()
    {
        $config = new \PhpPact\PactConfig();
        $config->setBaseUri(self::TEST_URL);
        $config->setPactDir(self::PACT_DIR);

        self::$build = new \PhpPact\PactBuilder($config);
        self::$build->ServiceConsumer(self::CONSUMER_NAME)
            ->HasPactWith(self::PROVIDER_NAME);
    }

    public static function tearDownAfterClass()
    {
        $mockService = self::$build->getMockService();

        $pact = $mockService->getPactFile();
        $pact->setProvider(new \PhpPact\Models\Pacticipant(self::PROVIDER_NAME));
        $pact->setConsumer(new \PhpPact\Models\Pacticipant(self::CONSUMER_NAME));

        self::$build->Build($pact);
    }


    /**
     * Before each test, rebuild the builder
     */
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testCities()
    {
        // build the request
        $reqHeaders = array();
        $reqHeaders["Content-Type"] = "application/json";
        $method = \PhpPact\Mocks\MockHttpService\Models\HttpVerb::GET;
        $path = '/' . self::version . '/cities';
        $request = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceRequest($method, $path, $reqHeaders);

        // build the response
        $resHeaders = array();
        $resHeaders["Content-Type"] = "application/json";

        $response = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceResponse('200', $resHeaders);
        $response->setBody("{\"results\":[{\"zip\":\"73301\",\"country\":\"us\",\"localized_country_name\":\"USA\",\"distance\":1.8526514121759305,\"city\":\"Austin\",\"lon\":-97.75,\"ranking\":0,\"id\":73301,\"state\":\"TX\",\"member_count\":57163,\"lat\":30.219999313354492},{\"zip\":\"78664\",\"country\":\"us\",\"localized_country_name\":\"USA\",\"distance\":19.468625978898555,\"city\":\"Round Rock\",\"lon\":-97.66999816894531,\"ranking\":1,\"id\":78664,\"state\":\"TX\",\"member_count\":3342,\"lat\":30.510000228881836}]}");


        // build up the expected results and appropriate responses
        $mockService = self::$build->getMockService();
        $mockService->Given("General Meetup Cities")
            ->UponReceiving("A GET request to return JSON using Meetups city api under version 2")
            ->With($request)
            ->WillRespondWith($response);


        // set the host for the httpClient
        $host = $mockService->getHost();
        $httpClient = new MockHttpClient($host);

        // build system under test
        // inject the http client and mock server
        $client = new ExampleTwoMeetupApiClient($httpClient, self::TEST_URL);
        $response = $client->cities();


        // do some asserts on the return
        $this->assertEquals('200', $response->getStatusCode(), "Let's make sure we have an OK response");

        // do something with the body returned
        $body = (string) $response->getBody();
        $this->assertTrue((json_decode($body) ? true : false), "Expect the JSON to be decoded without error");

        // verify the interactions
        $hasException = false;
        try {
            $results = $mockService->VerifyInteractions();

        } catch (\PhpPact\PactFailureException $e) {
            $hasException = true;
        }
        $this->assertFalse($hasException, "This cities call get should verify the interactions and not throw an exception");
    }

    public function testDashboard()
    {
        // build the request
        $reqHeaders = array();
        $reqHeaders["Content-Type"] = "application/json";
        $method = \PhpPact\Mocks\MockHttpService\Models\HttpVerb::GET;
        $path = '/dashboard';
        $request = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceRequest($method, $path, $reqHeaders);

        // build the response
        $resHeaders = array();
        $resHeaders["Content-Type"] = "application/json";
        $response = new \PhpPact\Mocks\MockHttpService\Models\ProviderServiceResponse('200', $resHeaders);


        // build up the expected results and appropriate responses
        $mockService = self::$build->getMockService();
        $mockService->Given("General Meetup Dashboard")
            ->UponReceiving("A GET request to return JSON using Meetups Dashboard that is version agnostic")
            ->With($request)
            ->WillRespondWith($response);

        // set the host for the httpClient
        $host = $mockService->getHost();
        $httpClient = new MockHttpClient($host);

        // build system under test
        // inject the http client and mock server
        $client = new ExampleTwoMeetupApiClient($httpClient, self::TEST_URL);
        $response = $client->dashboard();


        // do some asserts on the return
        $this->assertEquals('200', $response->getStatusCode(), "Expect this to be a valid URL");

        // verify the interactions
        $hasException = false;
        try {
            $results = $mockService->VerifyInteractions();

        } catch (\PhpPact\PactFailureException $e) {
            $hasException = true;
        }
        $this->assertFalse($hasException, "This dashboard call get should verify the interactions and not throw an exception");
    }
}