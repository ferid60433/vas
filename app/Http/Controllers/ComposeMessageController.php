<?php

namespace Vas\Http\Controllers;

use DB;
use Vas\Http\Requests\ComposeMessageRequest;
use Vas\Jobs\KannelSendMessageJob;
use Vas\Service;

class ComposeMessageController extends Controller
{
    public function __invoke(ComposeMessageRequest $request)
    {
        if (!$request->has('numbers')) {
            $plus = $this->filter($request->get('plus') ?? []);
            $minus = $this->filter($request->get('minus') ?? []);
            $confirm = $this->confirm($request->get('confirm') ?? []);

            $addresses = $plus
                ->union($confirm)
                ->diffKeys($minus);
        } else {
            $addresses = collect(explode(',', $request->get('numbers', '')))
                ->map(function ($elem) {
                    return substr($elem, -8, 8);
                })->filter(function ($elem) {
                    return strlen($elem) === 8;
                })->mapWithKeys(function ($item) {
                    return [$item => null];
                });
        }

        KannelSendMessageJob::dispatch(
            $request->get('message'), $addresses,
            $request->has('isPromo')
        )->delay(now()->addSecond(1));

        return redirect()->to('/')->with('success', 'Message is getting broadcasted!');
    }

    protected function filter(array $letters)
    {
        return Service::with('subscribers')
            ->whereIn('letter', $letters)->get()
            ->pluck('subscribers')
            ->flatten()
            ->pluck('service_id', 'address');
    }

    protected function confirm(array $confirm)
    {
        return DB::table('subscribers')
            ->join('services', 'subscribers.service_id', '=', 'services.id')
            ->whereIn('services.letter', $confirm)
            ->whereNull('subscribers.deleted_at')
            ->whereNotIn('subscribers.address', function ($query) {
                $query->select('sent_messages.address')
                    ->from('sent_messages')
                    ->where('sent_messages.created_at', '>', now()->subMonth())
                    ->where('sent_messages.from', env('MT'))
                    ->where('sent_messages.delivery_status', '<>', 16);
            })
            ->get()
            ->pluck('service_id', 'address');
    }
}
