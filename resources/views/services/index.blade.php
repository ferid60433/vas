@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Services</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group mr-2">
          <a href="{{ url('services/create') }}" class="btn btn-lg btn-outline-primary">Register</a>
      </div>
    </div>
</div>
  <?php
    $services = Vas\Service::with('subscribers', 'sentMessages')->get();

    collect([
      'yesterday' => (new Carbon\Carbon())->subDays(1),
      'lastWeek' => (new Carbon\Carbon())->subDays(7),
      'lastMonth' => (new Carbon\Carbon())->subDays(30),
    ])->map(function($date, $key) use($services) {
      $services->each(function($service) use($date, $key) {
        $service->{$key} = $service->subscribers()->where('created_at', '>', $date)->count();
      });
    });
  ?>

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
        @foreach($services as $service)
        <tr>
          <td>{{ $service->id }}</td>
          <td>
              <span class="badge badge-info">{{ $service->letter }}</span>
          </td>
          <td><code>{{ $service->code }}</code></td>
          <td class="white-space-nowrap" title="{{ $service->confirmation_message }}">
              {{ str_limit($service->confirmation_message, 70) }}
          </td>
          <td><strong><code>{{ $service->subscribers()->count() }}</code></strong></td>
          <td>
              <div class="m-2 white-space-nowrap text-right" style="min-width: 160px">
                <a href="{{ url('services/'.$service->id).'/edit' }}" type="button" class="btn btn-outline-success">Update</a>
                <a href="{{ url('services/'.$service->id).'/delete' }}" type="button" class="btn btn-outline-danger">Delete</a>
              </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <br />
  <h3>Services Statistics</h3>
  <hr />
  <br />

  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Code (Letter)</th>
          <th>
            Total # of <br />
            Subscribers
          </th>
          <th>Since Last <br />24 Hours</th>
          <th>Since Last <br />Week</th>
          <th>Since Last <br />Month</th>
          <th>Last Messsage</th>
        </tr>
      </thead>
      <tbody>
        @foreach($services as $service)
        <tr>
          <td>{{ $service->id }}</td>
          <td>
            <strong>
              <code>{{ $service->code }}</code> (<span class="badge badge-primary">{{ $service->letter }}</span>)</td>
            </strong>
          </td>
          <td>
            <strong>{{ $service->subscribers->count() }}</strong>
          </td>
          <td>{{ $service->yesterday }}</td>
          <td>{{ $service->lastWeek }}</td>
          <td>{{ $service->lastMonth }}</td>

          @if ($service->sentMessages->count() > 0)
            <?php $last = $service->sentMessages->last(); ?> 
            <td>
              <small title="{{ $last->message }}">
                {{ $last->message }}
              </small>
              <br />
              <span class="badge badge-info">{{ $last->created_at->diffForHumans() }}</span>
            </td>
          @else
            <td>
              <p class="alert alert-warning">
                <i class="fa fa-warning"></i> &nbsp; &nbsp; No message sent yet.
              </p>
            </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
