@extends('layouts.admin')

@section('preload')
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
</div>
@endsection
@section('header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>
@endsection

@section('content')
<div class="row">
    @foreach ($devices as $i => $device)
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ $device->name }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="{{ 'lineChart'.$device->id }}"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    @endforeach
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
                url: '{{ route("patient.pulse") }}',
                data:{
                    api_key: "tPmAT5Ab3j7F9"
                }
            }))
            .then((data,textStatus,jqXHR)=>{
                let datas = JSON.parse(data)                
                Object.keys(datas).forEach(key => {                    
                    let tempData = datas[key]
                    let labels = []
                    let hr = []
                    let spo2 = []
                    for (let i = 0; i < tempData.length; i++) {                        
                        labels.push(new moment(tempData[i]['created_at']).format('MMM Do YYYY h:mm:ss a'))
                        hr.push(tempData[i]['hr'])
                        spo2.push(tempData[i]['spo2'])
                    }
                    createChart(labels, hr, spo2, tempData[0]['patient']['name'], '#lineChart'+key)                    
                });
            })
        }
        
        function createChart(labels, hr, spo2, name, chartId){
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

            var lineChartCanvas = $(chartId).get(0).getContext('2d')
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