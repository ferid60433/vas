@extends('layout.app')

@section('content')
<?php $lookup = Vas\Lookup::find(Route::current()->parameter('setting')); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Update Settings</h1>
</div>
    <div class="col-sm-6">
  <form lpformnum="2" action="{{ url('settings/'.$lookup->id) }}" method="POST">
    @csrf

    <div class="form-group row">
      <label for="letter" class="col-sm-2 form-control-label">Letter</label>
      <div class="col-sm-10">
        <input name="letter" disabled class="disabled form-control" value="{{ $lookup->key }}" />
      </div>
    </div>

    <div class="form-group row">
      <label for="value" class="col-sm-2 form-control-label">Value</label>
      <div class="col-sm-10">
        <textarea name="value" class="form-control">{{ $lookup->value }}</textarea>
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
