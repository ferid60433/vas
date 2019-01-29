<?php

namespace Vas\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Vas\Cent;
use Vas\SentMessage;
use Vas\Service;

class ReportController extends Controller
{

    public function filter(Request $request)
    {
        $request->flash();

        $pack = $this->getService($request);

        if ($request->has('print')) {
            $pack['result'] = $pack['result']->get();

            return view('print', $pack);
        }

        $pack['result'] = $pack['result']->paginate(10);

        return view('report', $pack)
            ->with('from', $request->get('from', date('m/d/Y')))
            ->with('to', $request->get('service', date('m/d/Y')))
            ->with('service', $request->get('service', ''));
    }

    protected function getService(Request $request): array
    {
        $from = \DateTime::createFromFormat('m/d/Y', $request->get('from') ?? date('m/d/Y'));
        $to = \DateTime::createFromFormat('m/d/Y', $request->get('to') ?? date('m/d/Y'));
        $service = $request->get('service') ?? 'ALL';

        $from->setTime(0,0,0);

        if (env('UNIQUE_SERVICE')) {
            $query = SentMessage::query();
            $serviceCode = 'All Messages';
        } else if ($service === 'ALL') {
            $query = SentMessage::query();
            $serviceCode = 'All services';
        } else if ($service === 'NO') {
            $query = SentMessage::whereNull('service_id');
            $serviceCode = 'No services';
        } else if (env('CENT_URL') && $service === '__CENT__') {
            $query = Cent::with('message');
            $serviceCode = 'CENT';
        } else {
            $query = SentMessage::whereServiceId($service);
            $serviceCode = Service::find($service)->code;
        }

        $result = $query
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to);

        return compact('result', 'serviceCode');
    }

}
