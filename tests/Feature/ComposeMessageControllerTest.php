<?php

namespace Tests\Feature;

use Bus;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Vas\Jobs\KannelSendMessageJob;
use Vas\Service;

class ComposeMessageControllerTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function testMessageBroadcast()
    {
        Bus::fake();

        /** @var Service $service */
        $service = factory(Service::class)->create([
            'letter' => 'XXXXX',
        ]);

        for ($i = $this->faker->numberBetween(5, 20); $i > 0; $i--) {
            $this->post('api/kannel/received', [
                'messageId' => $this->faker->uuid,
                'from' => "2519{$this->faker->randomNumber(8, true)}",
                'to' => env('MO'),
                'content' => 'XXXXX',
            ])
                ->assertOk()
                ->assertSee($service->confirmation_message);
        }

        $this->post('compose', [
            'plus' => ['XXXXX'],
            'message' => 'Welcome to XXXXX',
        ])->assertRedirect();

        $this->assertEquals('Message is getting broadcasted!', session('success'));

        Bus::assertDispatched(KannelSendMessageJob::class, function ($job) {
            return $job->getMessage() === 'Welcome to XXXXX';
        });
    }
}
