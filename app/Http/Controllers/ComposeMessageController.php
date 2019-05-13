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
            $services = Service::with('subscribers')->whereIn('letter', $request->get('plus'))->get();

            $notToList = Service::with('subscribers')
                ->whereIn('letter', $request->get('minus'))->get()
                ->pluck('subscribers')
                ->flatten()
                ->pluck('address');

            $addresses = $services->pluck('subscribers')
                ->flatten()
                ->whereNotIn('address', $notToList)
                ->pluck('service_id', 'address');
        } catch (\Exception $e) {
            throw $e;
            $addresses = collect(explode(',', $request->get('numbers', '')))
                ->map(function ($elem) {
                    return substr($elem, -8, 8);
                })->filter(function ($elem) {
                    return strlen($elem) === 8;
                })->mapWithKeys(function ($item) {
                    return [$item=>null];
                });
        }

        KannelSendMessageJob::dispatch(
                $request->get('message'), $addresses,
                $request->has('isPromo')
        )->delay(now()->addSecond(3));

        return redirect()->to('/')->with('success', 'Message is getting broadcasted!');
    }
}
