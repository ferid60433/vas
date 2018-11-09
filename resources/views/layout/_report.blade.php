<div>
    @if(isset($result))
        <h3>{{ $result->count() }} messages</h3>
        @if($result instanceof \Illuminate\Database\Eloquent\Collection)
            <small>From: <strong>{{ old('from') }}</strong></small> <br />
            <small>To: <strong>{{ old('to') }}</strong></small> <br />
            <small>Service: <strong>{{ $serviceCode }}</strong></small> <br />
            <small>generated at <strong>{{ date(DATE_COOKIE) }}</strong></small>
            <hr />
        @endif

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
                <tr class="{{ $r->delivery_status ? 'table-success':'table-info' }}">
                    <th scope="row">{{ $r->id }}</th>
                    <td><code>+2519{{ $r->address }}</code></td>
                    <td style="width: 50%"><em class="text-muted">{{ $r->message }}</em></td>
                    <td>{{ $r->delivery_status ? 'Delivered' : 'Pending' }}</td>
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
