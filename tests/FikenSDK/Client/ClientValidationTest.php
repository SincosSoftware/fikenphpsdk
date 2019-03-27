<?php

namespace Tests\FikenSDK\Client;

use FikenSDK\Client as SdkClient;
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
        $this->setExpectedException(Exception::class, 'The HTTP client is not valid, and is missing either/or the request options: auth, headers.');

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
                ]
            ],
            'Missing username' => [
                [
                    'auth' => [
                        'baz',
                    ],
                    'headers' => ['Content-Type' => 'application/json'],
                ]
            ],
            'Missing Headers' => [
                [
                    'auth' => [
                        'foz',
                        'baz',
                    ]
                ]
            ]
        ];
    }
}