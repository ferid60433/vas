@extends('layout.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker3.min.css') }}">
@stop

@section('script')
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.input-daterange').datepicker({
            endDate: "now",
            maxViewMode: 3,
            keyboardNavigation: false,
            forceParse: false
        });
    </script>
@stop

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Report</h1>
    </div>

    <div class="col-sm-6">
        <form lpformnum="2" method="GET">

            <div class="form-group row">
                <label for="from" class="col-sm-2 form-control-label">Date Range</label>

                <div class="col-sm-10 input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control" name="from" value="{{ old('from', '') }}"
                           autocomplete="off"/>
                    &nbsp; &nbsp; &nbsp; <span class="input-group-addon">to</span> &nbsp; &nbsp; &nbsp;
                    <input type="text" class="input-sm form-control" name="to" value="{{ old('to', '') }}"
                           autocomplete="off"/>
                </div>
            </div>

            <div class="form-group row">
                <label for="service" class="col-sm-2 form-control-label">Service</label>

                <div class="col-sm-10">
                    <select class="form-control" name="service" id="service">
                        <option value="">No service</option>

                        @foreach(\Vas\Service::all() as $service)
                            <option
                                {{  old('service', '__________') == $service->id ? 'selected ':'' }}value="{{ $service->id }}">{{ $service->code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label"></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-filter"></i> Filter</button>

                    &nbsp; &nbsp; &nbsp;

                    <a class="btn btn-dark" href="{{ \Illuminate\Support\Facades\Request::fullUrlWithQuery(['print'=>true]) }}">
                        <i class="fa fa-print"></i> Print</a>
                </div>
            </div>
        </form>
    </div>

    <hr/>

    @include('layout._report')
@endsection
