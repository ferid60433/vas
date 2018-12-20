<div>
    @if(isset($result))

        @if($result instanceof \Illuminate\Database\Eloquent\Collection)
            <h3>{{ $result->count() }} messages</h3>
            <small>From: <strong>{{ old('from') ?? date('m/d/Y') }}</strong></small> <br />
            <small>To: <strong>{{ old('to') ?? date('m/d/Y') }}</strong></small> <br />
            <small>Service: <strong>{{ $serviceCode }}</strong></small> <br />
            <small>generated at <strong>{{ date(DATE_COOKIE) }}</strong></small>

        @else
            <h3>{{ $result->total() }} messages</h3>
        @endif

        <hr/>

        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Address</th>
                <th scope="col">Message</th>
                <th scope="col">Status</th>
                <th scope="col">Date Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result as $r)
                <tr class="{{ $r->delivery_status ?? true ? 'table-success':'table-info' }}">
                    <th scope="row">
                        {{ $r->id }}
                        @if ($r->response)
                            <code>[{{ $r->response['transactionId'] }}</code>]
                        @endif
                    </th>
                    <td><code>+2519{{ $r->address ?? $r->message->address }}</code></td>
                    <td style="width: 50%">
                        @if ($r->response)
                            <em class="text-muted">{{ $r->message->message }}</em>
                            <hr />
                            <em class="text-muted">{{ $r->response['message'] }}</em>
                        @else
                            <em class="text-muted">{{ $r->message }}</em>
                        @endif
                    </td>
                    <td>{{ $r->delivery_status ?? true ? 'Delivered' : 'Pending' }}</td>
                    <td>{!! nl2br(e($r->created_at->format("D, jS Y\nh:i:s a")))  !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if(!$result instanceof \Illuminate\Database\Eloquent\Collection)
            {{ $result->appends([
                'from' => old('from', ''),
                'to' => old('to', ''),
                'service' => old('service', ''),
            ])->links() }}
        @endif
    @endif
</div>
