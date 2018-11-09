<?php

namespace Vas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Vas\SentMessage;
use Vas\Service;

class ReportController extends Controller
{

    public function filter(Request $request)
    {
        $request->flash();

        $from = \DateTime::createFromFormat('m/d/Y', $request->get('from', date('m/d/Y')));
        $to = \DateTime::createFromFormat('m/d/Y', $request->get('to', date('m/d/Y')));

        $result = SentMessage::query()
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->whereServiceId($request->get('service', null));

        $serviceCode = 'No service ' . $request->get('service');

        try {
            $serviceCode = Service::find($request->get('service', null))->code;
        } catch (\Exception $ignore) {
        }

        View::share('serviceCode', $serviceCode);

        if ($request->has('print')) {
            $result = $result->get();

            $pdf = \PDF::loadView('print', compact('result'))
                ->setPaper('a4', 'landscape');

            return $pdf->stream('report-' . date('Ymd-his') . '.pdf');
        }

        $result = $result->paginate(2);

        return view('report', compact('result'));
    }

}
