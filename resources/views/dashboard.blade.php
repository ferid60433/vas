@extends('layout.app')

@inject('chart', 'Vas\Util\ChartMe')

@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
	    <h1 class="h2">Dashboard</h1>
	</div>
	
	<h3>Total</h3>
	<canvas class="my-4" id="myChart" width="900" height="380"></canvas>
	
	<br><hr><br>
	<h3>MT</h3>
	<canvas class="my-4" id="mtChart" width="900" height="380"></canvas>
@endsection

@section('script')
	<script src="{{ asset('js/Chart.min.js') }}"></script>
	
	<script>
    new Chart(document.getElementById("myChart"), {
        type: 'line',
        data: {
            labels: {!! $chart->lastDaysWeekdays() !!},
            datasets: [
                {
                    label: 'Total Received Messages',
                    data: {!! $chart->receivedStat() !!},
                    lineTension: 0,
                    backgroundColor: '#4F44',
                    borderColor: '#4F4',
                    borderWidth: 2,
                    pointBackgroundColor: '#4F4'
                },
                {
                    label: 'Total Sent Messages',
                    data: {!! $chart->sentStat() !!},
                    lineTension: 0,
                    backgroundColor: '#77F4',
                    borderColor: '#77F',
                    borderWidth: 3,
                    pointBackgroundColor: '#77F',
                    // legend: {
                    //     display: true,
                    //     position: 'top',
                    //     fontSize: 45
                    // }
                },
                {
                    label: 'Total Delivered Messages',
                    data: {!! $chart->deliveredStat() !!},
                    lineTension: 0,
                    backgroundColor: '#F774',
                    borderColor: '#F77',
                    borderWidth: 4,
                    pointBackgroundColor: '#F77'
                },
                // {
                //     label: 'MT Messages',
                    {{--data: {!! $chart->mtStat() !!},--}}
                    // lineTension: 0,
                    // backgroundColor: '#FFFF0044',
                    // borderColor: 'yellow',
                    // borderWidth: 2,
                    // pointBackgroundColor: 'yellow'
                // }
            ]
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

    new Chart(document.getElementById("mtChart"), {
        type: 'line',
        data: {
            labels: {!! $chart->lastDaysWeekdays() !!},
            datasets: [
	            {
                    label: 'MT Sent Messages',
                    data: {!! $chart->sentStat(true) !!},
                    lineTension: 0,
                    backgroundColor: '#77F4',
                    borderColor: '#77F',
                    borderWidth: 2,
                    pointBackgroundColor: '#77F',
                    // legend: {
                    //     display: true,
                    //     position: 'top',
                    //     fontSize: 45
                    // }
                },
                {
                    label: 'MT Delivered Messages',
                    data: {!! $chart->deliveredStat(true) !!},
                    lineTension: 0,
                    backgroundColor: '#4F44',
                    borderColor: '#4F4',
                    borderWidth: 3,
                    pointBackgroundColor: '#4F4'
                },
                // {
                //     label: 'MT Messages',
			    {{--data: {!! $chart->mtStat() !!},--}}
                // lineTension: 0,
                // backgroundColor: '#FFFF0044',
                // borderColor: 'yellow',
                // borderWidth: 2,
                // pointBackgroundColor: 'yellow'
                // }
            ]
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
