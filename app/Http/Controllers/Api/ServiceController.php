<?php

namespace Vas\Http\Controllers\Api;

use Vas\Http\Controllers\Controller;
use Vas\Http\Requests\ServiceStoreRequest;
use Vas\Http\Requests\ServiceUpdateRequest;
use Vas\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::all();
    }

    public function store(ServiceStoreRequest $request)
    {
        return Service::create(
            $request->only('letter', 'code', 'confirmation_message'));
    }

    public function show(Service $service)
    {
        return $service;
    }

    public function update(ServiceUpdateRequest $request, Service $service)
    {
        return [
            $service->update(
                $request->only('letter', 'code', 'confirmation_message')),
        ];
    }

    public function destroy(Service $service)
    {
        return [$service->delete()];
    }
}
