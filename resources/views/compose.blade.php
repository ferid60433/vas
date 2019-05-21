@extends('layout.app')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Compose Message</h1>
</div>
	<div class="col-sm-6">
  <form lpformnum="2" method="POST">
    @csrf
	  <div class="form-group row">
      <label for="plus[]" class="col-sm-2 form-control-label">Services</label>
      <div class="col-sm-10">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>
                        <strong class="badge badge-success">
                            <i class="fa fa-plus-circle"></i> All
                        </strong>
                    </h4>
                    @foreach(Vas\Service::with('subscribers')->get() as $service)
                    <div class="form-check">
                      <label class="form-check-label text-success">
                        <input class="form-check-input" name="plus[]" type="checkbox" value="{{ $service->letter }}">
                          {{ $service->code }}
                          <span class="badge badge-success">{{ $service->subscribers()->count() }}</span>
                      </label>
                    </div>
	                @endforeach
                </div>
                <div class="col-6">
                    <h4>
                        <strong class="badge badge-danger">
                            <i class="fa fa-minus-circle"></i> Except
                        </strong>
                    </h4>
                    @foreach(Vas\Service::with('subscribers')->get() as $service)
                    <div class="form-check">
                      <label class="form-check-label text-danger">
                        <input class="form-check-input" name="minus[]" type="checkbox" value="{{ $service->letter }}">
                          {{ $service->code }}
                          <span class="badge badge-danger">{{ $service->subscribers()->count() }}</span>
                      </label>
                    </div>
	                @endforeach
                </div>
            </div> <hr>
            <div class="row">
                <div class="col-12">
                    <h4>
                        <strong class="badge badge-primary">
                            <i class="fa fa-check-square-o"></i> Unconfirmed subscribers
                        </strong>
                    </h4>
                    
                    @foreach(Vas\Service::with('subscribers')->get() as $service)
                        <div class="form-check">
                      <label class="form-check-label text-primary">
                        <input class="form-check-input" name="confirm[]" type="checkbox" value="{{ $service->letter }}">
                          {{ $service->code }}
                      </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
    </div>
	
	  @if (env('NON_VAS'))
		  <div class="form-group row">
      <label for="numbers" class="col-sm-2 form-control-label">Numbers</label>
      <div class="col-sm-10">
          <input id="numbers" type="text" class="form-control" name="numbers"
                 placeholder="Comma separated list of mobile numbers (optional)">
      </div>
    </div>
	  @endif
	
	  <div id="app" class="form-group row">
      <label for="message" class="col-sm-2 form-control-label">Message</label>
      <div class="col-sm-10">
        <message-textarea name="message"></message-textarea>
      </div>
    </div>
	  @if (!env('NON_VAS'))
		  <div class="form-group row">
      <label for="isPromo" class="col-sm-2 form-control-label">Promotion</label>
      <div class="col-sm-10">
        <div class="form-check">
          <input name="isPromo" class="form-check-input" type="checkbox" value="1">
        </div>
      </div>
    </div>
	  @endif
	  <div class="form-group row">
      <label for="inputPassword3" class="col-sm-2 form-control-label"></label>
      <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Broadcast</button>
      </div>
    </div>
  </form>
</div>
@endsection
