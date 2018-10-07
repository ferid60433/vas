@extends('layout.app')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Update <code>{{ $service->code }}</code> service</h1>
</div>
    <div class="col-sm-6">
  <form lpformnum="2" action="{{ url('services/'.$service->id) }}" method="POST">
    @csrf

    <div class="form-group row">
      <label for="letter" class="col-sm-2 form-control-label">Letter</label>
      <div class="col-sm-10">
        <input name="letter" value="{{ old('letter', $service->letter) }}" class="form-control" placeholder="Letter" />
      </div>
    </div>
    <div class="form-group row">
      <label for="code" class="col-sm-2 form-control-label">Code</label>
      <div class="col-sm-10">
        <input name="code" value="{{ old('code', $service->code) }}"  class="form-control" placeholder="Code" />
      </div>
    </div>
    <div class="form-group row">
      <label for="confirmation_message" class="col-sm-2 form-control-label">Confirmation Message</label>
      <div class="col-sm-10">
        <textarea name="confirmation_message" class="form-control"
                  placeholder="The message to sent to the client">{{ old('confirmation_message', $service->confirmation_message) }}</textarea>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword3" class="col-sm-2 form-control-label"></label>
      <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
  </form>
</div>
@endsection
