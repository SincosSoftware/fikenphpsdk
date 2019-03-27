<?php

namespace Tests\FikenSDK\Client;

use FikenSDK\Client as SdkClient;
use FikenSDK\Exceptions\HttpClientValidationException;
use GuzzleHttp\Client;
use Tests\Functional\TestCase;

final class ClientValidationTest extends TestCase
{
    public function testClientIsValidWithPreconstructedHttpClient()
    {
        $client = new SdkClient('foo', 'bar', new Client([
            'config' => [
                'auth' => [
                    'foz',
                    'baz',
                ],
                'headers' => ['Content-Type' => 'application/json'],
            ]
        ]));

        $this->assertInstanceOf(Client::class, $client->httpClient);
    }

    /**
     * @dataProvider configurationParts
     */
    public function testClientThrowsExceptionIfMissingConfiguration($configuration)
    {
        $this->setExpectedException(HttpClientValidationException::class, 'The HTTP client is not valid, and is missing either Auth (username, password) or correct Content-Type (application/json)');

        new SdkClient('foo', 'bar', new Client([
            'config' => $configuration
        ]));
    }

    public function configurationParts()
    {
        return [
            'Missing Auth' => [
                [
                    'auth' => [],
                    'headers' => ['Content-Type' => 'application/json'],
                ],
            ],
            'Missing username' => [
                [
                    'auth' => [
                        'baz',
                    ],
                    'headers' => ['Content-Type' => 'application/json'],
                ],
            ],
            'Missing Headers' => [
                [
                    'auth' => [
                        'foz',
                        'baz',
                    ]
                ],
            ]
        ];
    }
}