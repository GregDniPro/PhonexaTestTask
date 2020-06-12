<?php declare(strict_types = 1);

namespace App\Services;

use GuzzleHttp\Client;
use Spatie\ArrayToXml\ArrayToXml;

/**
 * Class HttpClient
 *
 * @package App\Services
 */
class HttpClient
{
    /**
     * @param array $payload
     *
     * @return string Xml string result
     */
    public function dummyXmlCall(array $payload): string
    {
        /** This is how it should (in theory) work, if ill have real endpoint */
        /*
        $xmlPayload = ArrayToXml::convert($payload, 'userInfo');
        $requestResult = $this->getClient()->post('https://someCoolDomain.com/xml', [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
            'body' => $xmlPayload
        ]);
        $response = $requestResult->getBody()->getContents();
        return $response;
        */

        /** And here is just simple emulation */
        $success = [
            'returnCode' => 1,
            'returnCodeDescription' => 'SUCCESS',
            'transactionId' => 'AC158457A86E711D0000016AB036886A03E7'
        ];
        $reject = [
            'returnCode' => 0,
            'returnCodeDescription' => 'REJECT',
        ];
        $error = [
            'returnCode' => 0,
            'returnCodeDescription' => 'ERROR',
            'returnError' => 'Lead not Found'
        ];
        $responsesMap = [$success, $reject, $error];

        return ArrayToXml::convert($responsesMap[rand(0, 2)], 'userInfo');
    }

    /**
     * @param array $payload
     *
     * @return string Json string result
     */
    public function dummyJsonCall(array $payload): string
    {
        /** This is how it should (in theory) work, if ill have real endpoint */
        /*
        $jsonPayload = json_encode([
            'userInfo' => [
                $payload
            ]
        ]);
        $requestResult = $this->getClient()->post('https://someCoolDomain.com/xml', [
            'headers' => [
                'Content-type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json',
            ],
            'body' => $jsonPayload
        ]);
        $response = $requestResult->getBody()->getContents();
        return $response;
        */

        /** And here is just simple emulation */
        $success = ['SubmitDataResult' => 'success',];
        $reject = ['SubmitDataResult' => 'reject',];
        $error = ['SubmitDataResult' => 'error', 'SubmitDataErrorMessage' => 'Oops, error happened!'];
        $responsesMap = [$success, $reject, $error];

        return json_encode($responsesMap[rand(0, 2)]);
    }


    /**
     * @param string $url
     * @param array|null $body
     *
     * @return string
     */
    private function doPostRequest(string $url, ?array $body = null): string
    {
        if (!empty($body)) {
            $body = http_build_query($body);
        }

        /**
         * There is possibility to send Json data in body, just change headers.
         */
        $response = $this->getClient()->post($url, [
            'body' => $body,
            'headers' => [
                'accept' => '*/*',
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param array|null $parameters
     *
     * @return string
     */
    private function doGetRequest(string $url, ?array $parameters = null): string
    {
        if (!empty($parameters)) {
            $url .= '?' . http_build_query($parameters);
        }

        $response = $this->getClient()->get($url);
        return $response->getBody()->getContents();
    }

    /**
     * Here you can configure guzzle client for all requests.
     *
     * @see https://github.com/guzzle/guzzle
     *
     * @return Client
     */
    private function getClient(): Client
    {
        return new Client;
    }
}
