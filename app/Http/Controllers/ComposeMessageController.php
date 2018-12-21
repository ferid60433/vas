<?php

namespace Vas\Http\Controllers;

use Vas\Http\Requests\ComposeMessageRequest;
use Vas\Jobs\KannelSendMessageJob;
use Vas\Service;

class ComposeMessageController extends Controller
{
    public function __invoke(ComposeMessageRequest $request)
    {
        try {
            $services = Service::with('subscribers')->whereIn('letter', $request->get('services'))->get();
            $addresses = $services->pluck('subscribers')->flatten()->pluck('address');
        } catch (\Exception $e) {
            $addresses = collect(explode(',', $request->get('numbers', '')))
                ->map(function ($elem) {
                    return substr($elem, -8, 8);
                })
                ->filter(function ($elem) {
                    return strlen($elem) === 8;
                });
        }

        KannelSendMessageJob::dispatchNow(
            $request->get('message'),
            $addresses,
            $request->has('isPromo')
        );

        return redirect()->to('/')->with('success', 'Message is getting broadcasted!');
    }
}
