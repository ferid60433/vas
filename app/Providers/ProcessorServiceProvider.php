<?php

namespace Vas\Providers;

use Illuminate\Support\ServiceProvider;
use Vas\Processors\Invoker;

class ProcessorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('UNIQUE_SERVICE')) {
            $processors = collect([
                \Vas\Processors\StopProcessor::class,
                \Vas\Processors\EmptyProcessor::class,
                \Vas\Processors\HelpProcessor::class,
                \Vas\Processors\UniqueServiceProcessor::class,
            ]);
        } else {
            $processors = collect([
                \Vas\Processors\StopProcessor::class,
                \Vas\Processors\CentProcessor::class,
//            \Vas\Processors\MoMessagesProcessor::class,
                \Vas\Processors\EmptyProcessor::class,
                \Vas\Processors\HelpProcessor::class,
                \Vas\Processors\SubscriberProcessor::class,
                \Vas\Processors\CommandProcessor::class,
                \Vas\Processors\DefaultProcessor::class,
            ]);
        }

        $head = $processors->reverse()
            ->reduce(function ($last, $processor) {
                return app($processor)->setSuccessor(
                    $last ?? app(\Vas\Processors\NullProcessor::class));
            });

        $this->app->instance(\Vas\Processors\Processor::class, $head);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [\Vas\Processors\Processor::class];
    }

}
