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
            datasets: [
                {
                    label: 'Received Messages',
                    data: {!! $chart->receivedStat() !!},
                    lineTension: 0,
                    backgroundColor: '#00FF0077',
                    borderColor: 'green',
                    borderWidth: 4,
                    pointBackgroundColor: 'green'
                },
                {
                    label: 'Sent Messages',
                    data: {!! $chart->sentStat() !!},
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: 'blue',
                    borderWidth: 2,
                    pointBackgroundColor: 'blue',
                    // legend: {
                    //     display: true,
                    //     position: 'top',
                    //     fontSize: 45
                    // }
                },
                {
                    label: 'Delivered Messages',
                    data: {!! $chart->deliveredStat() !!},
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: 'red',
                    borderWidth: 2,
                    pointBackgroundColor: 'red'
                },
                {
                    label: 'MT Messages',
                    data: {!! $chart->mtStat() !!},
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: 'yellow',
                    borderWidth: 2,
                    pointBackgroundColor: 'yellow'
                }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: true,
            }
        }
    });
    </script>
@endsection
