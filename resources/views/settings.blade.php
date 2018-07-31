@extends('layout.app')

@section('style')
<style type="text/css">
  .white-space-nowrap {
    white-space: nowrap
  }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Settings</h1>
</div>
<div class="">
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Key</th>
          <th>Value</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $lookups = Vas\Lookup::paginate(); ?>

        @foreach($lookups as $lookup)
        <tr>
          <td>{{ $lookup->id }}</td>
          <td><code class="white-space-nowrap">{{ $lookup->key }}</code></td>
          <td><small>{{ $lookup->value }}</small></td>
          <td class="white-space-nowrap">
              <div class="m-2">
                <a href="{{ url('settings/'.$lookup->id) }}" type="button" class="btn btn-outline-success">View</a>
                <a href="#" type="button" class="btn btn-outline-danger">Delete</a>
              </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
