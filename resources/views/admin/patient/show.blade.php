@extends('layouts.admin')

@section('header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Patient</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.patient.index') }}">Patient</a></li>
                    <li class="breadcrumb-item active">Show</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
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
                // sort the data from old to latest data   
                for(var i = datas.length-1; i>=0; i--){
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