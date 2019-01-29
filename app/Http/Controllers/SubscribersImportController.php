<?php

namespace Vas\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;
use Vas\Http\Requests\SubscribersImportRequest;
use Vas\Subscriber;

class SubscribersImportController extends Controller
{
    public function __invoke(SubscribersImportRequest $request)
    {
        $service_id = $request->get('service');
        $uploadedFile = $request->file('upload');

        $addresses = $this->fetchAddresses($uploadedFile)
            ->unique()
            ->diff(Subscriber::whereServiceId($service_id)->get()->pluck('address'));

        if ($addresses->count() === 0) {
            return redirect()->to('subscribers')->with('danger',
                "No new address to import! We couldn't import the file.");
        }

        $created_at = Carbon::now();

        $bulk = $addresses->reduce(function ($result, $address) use ($service_id, $created_at) {
            $result[] = compact('address', 'service_id', 'created_at');

            return $result;
        }, []);

        try {
            DB::transaction(function () use ($bulk) {
                Subscriber::insert($bulk);
            });
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), 'Duplicate entry')) {
                return redirect()->to('subscribers')->with('danger', $exception->errorInfo[2]);
            }

            return redirect()->to('subscribers')->with('danger',
                "Something went wrong! We couldn't import the file.");
        }

        return redirect()->to('subscribers')->with('success', 'Successfully imported!');
    }

    protected function fetchAddresses(UploadedFile $uploadedFile)
    {
        $reader = Reader::createFromPath($uploadedFile->getRealPath());
        $reader->setHeaderOffset(0);

        $result = collect((new Statement())->process($reader));

        $addresses = $result
            ->map(function ($item) {
                return $item['Address'];
            })
            ->map(function ($element) {
                $strip = str_replace([' ', '+', '-', '(', ')'], '', $element);

                return substr($strip, -8);
            });

        return $addresses;
    }

}
