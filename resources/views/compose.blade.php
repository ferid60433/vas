@extends('layout.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Compose Message</h1>
</div>
<div class="col-sm-6">
  <form lpformnum="2" action="{{ url('api/service/doesn\t/exist') }}" method="POST">
    <div class="form-group row">
      <label for="services[]" class="col-sm-2 form-control-label">Services</label>
      <div class="col-sm-10">
        @foreach(Vas\Service::all() as $service)
        <div class="form-check">
          <label class="form-check-label">
            <input class="form-check-input" name="services[]" type="checkbox" value="{{ $service->letter }}">
            {{ $service->code }}
          </label>
        </div>
        @endforeach
      </div>
    </div>
    <div class="form-group row">
      <label for="message" class="col-sm-2 form-control-label">Message</label>
      <div class="col-sm-10">
        <textarea name="message" class="form-control"
        placeholder="The message to sent to the client"></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label for="isPromo" class="col-sm-2 form-control-label">Promotion</label>
      <div class="col-sm-10">
        <div class="form-check">
          <input name="isPromo" class="form-check-input" type="checkbox" value="off">
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword3" class="col-sm-2 form-control-label"></label>
      <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Broadcast</button>
      </div>
    </div>
  </form>
</div>
@endsection
