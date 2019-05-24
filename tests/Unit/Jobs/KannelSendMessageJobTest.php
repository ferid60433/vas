<?php

namespace Tests\Unit\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Vas\Jobs\KannelSendMessageJob;
use Vas\Service;

class KannelSendMessageJobTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @var array */
    protected $container;

    public function testJobHandler()
    {
        [$toCount, $message, $addresses] = $this->fakeData();

        $client = $this->mockClient($toCount);

        $this->executeJob($message, $addresses, $client);

        $this->assertions($toCount, $this->container, $message, $addresses);
    }

    protected function fakeData(): array
    {
        $toCount = $this->faker->randomDigit;
        $message = $this->faker->paragraph;
        $addresses = $this->getRandomAddressesArray($toCount, factory(Service::class, 3)->create());

        return array($toCount, $message, $addresses);
    }

    protected function getRandomAddressesArray($count, $services)
    {
        $out = collect([]);

        while ($count > 0) {
            $out->put($this->faker->randomNumber(8, true), $services->random()->id);
            $count--;
        }

        return $out;
    }

    protected function mockClient($toCount): Client
    {
        $this->container = [];

        $mock = new MockHandler(array_fill(
            0,
            $toCount,
            new Response(200, ['X-PHPUnit' => 'Bar'])));

        $history = Middleware::history($this->container);

        $stack = HandlerStack::create($mock);
        $stack->push($history);

        return new Client(['handler' => $stack]);
    }

    protected function executeJob($message, $addresses, $client): void
    {
        $job = new KannelSendMessageJob($message, $addresses);
        $job->handle($client);
    }

    protected function assertions($toCount, $container, $message, $addresses): void
    {
        $this->assertCount($toCount, $container);

        foreach ($this->container as $index => $guzzle) {
            /** @var Request $request */
            $request = $guzzle['request'];

            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('http', $request->getUri()->getScheme());
            $this->assertEquals('smsc', $request->getUri()->getHost());
            $this->assertEquals(13013, $request->getUri()->getPort());
            $this->assertEquals('/cgi-bin/sendsms', $request->getUri()->getPath());
            $this->assertTrue(Str::contains(urldecode($request->getUri()->getQuery()), $message));
            $this->assertTrue(Str::contains(urldecode($request->getUri()->getQuery()), $addresses->keys()[$index]));

            /** @var Response $response */
            $response = $guzzle['response'];
            $this->assertEquals('OK', $response->getReasonPhrase());
            $this->assertEquals(200, $response->getStatusCode());
            $this->assertEquals('Bar', $response->getHeaderLine('X-PHPUnit'));
        }

        foreach ($addresses as $address => $service) {
            $this->assertDatabaseHas('sent_messages', [
                'message' => trim($message),
                'address' => "$address",
            ]);
        }
    }

    public function testJobUnicodeHandler()
    {
        [$toCount, $message, $addresses] = $this->fakeData();

        $message = 'Yagute | ያጉቴ';

        $client = $this->mockClient($toCount);

        $this->executeJob($message, $addresses, $client);

        $this->assertions($toCount, $this->container, $message, $addresses);
    }

}
