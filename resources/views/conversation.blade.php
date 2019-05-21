@extends('layout.app')

@section('style')
    <style type="text/css">
        .white-space-nowrap {
            white-space: nowrap
        }
        .message {
            padding: 1em;
            margin: 1px 0px;
            border: 1px solid #ccc;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Conversation with +2519{{ $address }}</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">
                        Messages
                    </div>
                    <div class="card-body">
                        @foreach($messages as $message)
                            @if ($message instanceof Vas\ReceivedMessage)
                                <div class="row">
                                    <div class="message col-sm-8">
                                        {!! nl2br(e($message->message)) !!} <br>
                                        <small class="badge badge-primary">{{ $message->to }}</small>
                                        <small>{{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="col-sm-4">&nbsp;</div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-sm-4">&nbsp;</div>
                                    <div class="message col-sm-8 text-right text-{{ $message->delivery_status_color }}">
                                        {!! nl2br(e($message->message)) !!} <br>
                                        <small class="badge badge-primary">{{ $message->from }}</small>
                                        <small>{{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-sm-1"></div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        Services Subscribed
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($services as $service)
                            <li class="list-group-item">
                                {{ $service->service->created_at->toCookieString() }}
                                <br />(
                                <small>{{ $service->service->created_at->diffForHumans() }}</small>
                                )
                                <span class="badge badge-primary badge-pill">{{ $service->service->code }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
