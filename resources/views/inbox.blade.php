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
  <h1 class="h2">Inbox</h1>
</div>
<div class="">
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Address</th>
          <th>Message</th>
          <th>Received At</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $inbox = Vas\ReceivedMessage::latest()->paginate(); ?>

        @foreach($inbox as $message)
        <tr>
          <td>{{ $message->id }}</td>
          <td><code class="white-space-nowrap">+{{ $message->full_address }}</code></td>
          <td>
            <small>
              {{ $message->message }}
              "{{ iconv('UTF-8', 'UTF-16', $message->$message) }}"
              "{{ implode(unpack("H*", $message->message)) }}"
            </small>
          </td>
          <td class="white-space-nowrap">{{ $message->created_at->diffForHumans() }}</td>
          <td class="white-space-nowrap">
              <div class="m-2">
                <a href="{{ url('inbox/'.$message->id) }}" type="button" class="btn btn-outline-danger">Delete</a>
              </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <hr />
    {{ $inbox->render() }}
  </div>
</div>
@endsection
