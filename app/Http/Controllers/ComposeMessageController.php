<?php

namespace Vas\Http\Controllers;

use Vas\Http\Requests\ComposeMessageRequest;
use Vas\Jobs\KannelSendMessageJob;
use Vas\Service;

class ComposeMessageController extends Controller
{
    public function __invoke(ComposeMessageRequest $request)
    {
        $services = Service::with('subscribers')->whereIn('letter', $request->get('services'))->get();
        $addresses = $services->pluck('subscribers')->flatten()->pluck('address');

        KannelSendMessageJob::dispatchNow($request->get('message'),
            $addresses, $request->has('isPromo'));

        return redirect()->to('/')->with('success', 'Message is getting broadcasted!');
    }
}
