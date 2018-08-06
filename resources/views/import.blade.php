@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Import Subscribers</h1>
</div>
    <div class="col-sm-6">
  <form lpformnum="2" action="{{ url('subscribers/import') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group row">
      <label for="service" class="col-sm-2 form-control-label">Service</label>
      <div class="col-sm-10">
        <select name="service" class="form-control">
          @foreach(Vas\Service::all() as $service)
            <option value="{{ $service->id }}">{{ $service->code }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="upload" class="col-sm-2 form-control-label">File</label>
      <div class="col-sm-10">
        <input type="file" name="upload" class="form-control"/>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword3" class="col-sm-2 form-control-label"></label>
      <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Import</button>
      </div>
    </div>
  </form>
</div>
@endsection
