<?php

namespace Vas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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

            $pdf = PDF::loadView('print', $pack)->setPaper('a4', 'landscape');

            return $pdf->download('report-' . date('Y-m-d-h:i:s') . '.pdf');
        }

        $pack['result'] = $pack['result']->paginate(2);

        return view('report', $pack);
    }

    protected function getService(Request $request): array
    {
        $from = \DateTime::createFromFormat('m/d/Y', $request->get('from', date('m/d/Y')));
        $to = \DateTime::createFromFormat('m/d/Y', $request->get('to', date('m/d/Y')));
        $service = $request->get('service', null);

        if (empty($service)) {
            $query = SentMessage::query();
            $serviceCode = 'All services';
        } else if ($service === '__CENT__') {
            $query = Cent::with('message');
            $serviceCode = 'CENT';
        } else {
            $query = SentMessage::whereServiceId($request->get('service', null));
            $serviceCode = Service::find($request->get('service', null))->code;
        }

        $result = $query
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to);

        return compact('result', 'serviceCode');
    }

}
