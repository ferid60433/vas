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
<h1 class="h2">Outbox</h1>
</div>
<div class="">
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Address</th>
          <th>Message</th>
          <th>Sent At</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $outbox = Vas\SentMessage::latest()->paginate(); ?>

        @foreach($outbox as $message)
            <tr class="{{ $message->delivery_status === 1? 'table-success' : '' }}">
          <td>{{ $message->id }}</td>
          <td>
              <code class="white-space-nowrap">+{{ $message->full_address }}</code><br />
              @if ($message->service)
                  <span class="badge badge-info">{{ $message->service->code }}</span>
              @endif
          </td>
          <td><small>{{ $message->message }}</small></td>
          <td class="white-space-nowrap">{{ $message->created_at->diffForHumans() }}</td>
          <td class="white-space-nowrap">
              <div class="m-2">
                <a href="{{ url('outbox/'.$message->id) }}" type="button" class="btn btn-outline-danger">Delete</a>
              </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <hr />
      {{ $outbox->render() }}
  </div>
</div>
@endsection
