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
  <h1 class="h2">Subscriber</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ url('subscribers/import') }}" class="btn btn-lg btn-outline-primary">Import</a>
        </div>
    </div>
</div>
<div class="col-sm-8">
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Service</th>
          <th>Address</th>
          <th>Subscribed At</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $subscribers = Vas\Subscriber::with('service')->orderBy('id', 'desc')->paginate(10); ?>

        @foreach($subscribers as $subscriber)
        <tr>
          <td>{{ $subscriber->id }}</td>
          <td><code class="white-space-nowrap">+{{ $subscriber->full_address }}</code></td>
          <td>
            <span class="badge badde badge-primary white-space-nowrap">
              {{ $subscriber->service->code }}
            </span>
          </td>
          <td class="white-space-nowrap">{{ $subscriber->created_at->diffForHumans() }}</td>
          <td class="white-space-nowrap">
              <div class="m-2">
                <a href="{{ url('subscribers/'.$subscriber->id) }}" type="button" class="btn btn-outline-danger">Delete</a>
              </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{ $subscribers->render() }}
  </div>
</div>
@endsection
