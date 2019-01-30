@extends('layout.app')

@inject('chart', 'Vas\Util\ChartMe')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<canvas class="my-4" id="myChart" width="900" height="380"></canvas>
@endsection

@section('script')
    <script src="{{ asset('js/Chart.min.js') }}"></script>

    <script>
    var ctx = document.getElementById("myChart");



    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $chart->lastDaysWeekdays() !!},
            datasets: [{
                label: 'Sent Messages',
                data: {!! $chart->sentStat() !!},
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 4,
                pointBackgroundColor: '#007bff',
                legend: {
                    display: true,
                    position: 'top',
                    fontSize: 45
                }
            },
            {
                label: 'Delivered Messages',
                data: {!! $chart->deliveredStat() !!},
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#ff007b',
                borderWidth: 4,
                pointBackgroundColor: '#ff007b'
            },
            {
                label: 'Received Messages',
                data: {!! $chart->receivedStat() !!},
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#00ff7b',
                borderWidth: 4,
                pointBackgroundColor: '#00ff7b'
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
    });
    </script>
@endsection
