@extends('layouts.app')

@section('header')
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            {{-- <h2>Inner Page</h2> --}}
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('user.index') }}">User</a></li>
                <li>Patient</li>
            </ol>
        </div>

    </div>
</section>
@endsection

@section('content')
<section class="inner-page" style="min-height: 80vh">
    <div class="container">
        <div class="row">
            <div class="col-md-12">        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Patient</h3>
                    </div>            
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="lineChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script>
    $(function () {

        function getData(){
            $.when($.ajax({
                method:'POST',
                url: '{{ route("user.patient.pulse",$patient_id) }}'
            }))
            .then((data,textStatus,jqXHR)=>{
                let datas = JSON.parse(data)                
                let labels = []
                let hr = []
                let spo2 = []
                for(var i = 0; i<datas.length; i++){                                          
                    let tempData = datas[i]                    
                    labels.push(new moment(tempData['created_at']).format('MMM Do YYYY h:mm:ss a'))
                    hr.push(tempData['hr'])
                    spo2.push(tempData['spo2'])                    
                }
                createChart(labels, hr, spo2, datas[0]['patient']['name'])
            })
        }
        
        function createChart(labels, hr, spo2, name){
            var areaChartData = {
                labels  : labels,
                datasets: [
                {
                    label               : 'HEART RATE',
                    backgroundColor     : '#D12038',
                    borderColor         : '#D12038',                    
                    pointColor          : '#C70039',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : hr,                    
                    pointStyle          : 'circle',
                    pointRadius         : 10,
                    pointHoverRadius    : 15
                },
                {
                    label               : 'SPO2 LEVEL',
                    backgroundColor     : '#2065D1',
                    borderColor         : '#2065D1',                    
                    pointColor          : '#2065D1',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : spo2,
                    pointStyle          : 'circle',
                    pointRadius         : 10,
                    pointHoverRadius    : 15
                },
                ]
            }
        
            var areaChartOptions = {
                maintainAspectRatio : false,
                responsive : true,
                animation: {
                    duration: 0
                },
                title:{
                    display:true,
                    text: name
                },
                legend: {
                display: true
                },
                scales: {
                xAxes: [{
                    gridLines : {
                    display : true,
                    }
                }],
                yAxes: [{
                    gridLines : {
                    display : true,
                    }
                }]
                }
            }

            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = $.extend(true, {}, areaChartOptions)
            var lineChartData = $.extend(true, {}, areaChartData)
            lineChartData.datasets[0].fill = false;
            lineChartData.datasets[1].fill = false;
            lineChartOptions.datasetFill = false
        
            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })
        }

        getData()
        setInterval(() => {
            getData()
        }, 3000);
    })
</script>
@endpush