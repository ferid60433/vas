@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Services</h1>
</div>
    <div class="">
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Letter</th>
          <th>Code</th>
          <th>Confirmation<br />Message</th>
          <th># of<br />Subscribers</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $services = Vas\Service::with('subscribers')->get(); ?>

        @foreach($services as $service)
        <tr>
          <td>{{ $service->id }}</td>
          <td>
              <span class="badge badge-info">{{ $service->letter }}</span>
          </td>
          <td><code>{{ $service->code }}</code></td>
          <td class="white-space-nowrap">{{ $service->confirmation_message }}</td>
          <td><code>{{ $service->subscribers()->count() }}</code></td>
          <td>
              <div class="m-2 white-space-nowrap">
                <a href="{{ url('services/'.$service->id) }}" type="button" class="btn btn-outline-success">View</a>
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
