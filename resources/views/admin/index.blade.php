@extends('layouts.admin')

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
                    <li class="breadcrumb-item active">Dashboard v1</li>
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
                        <canvas id="{{ 'lineChart'.$i }}"
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
                    console.log(datas[key][0]['created_at']);
                    let tempData = datas[key]
                    for (let i = 0; i < tempData.length; i++) {    
                    }
                });
            })
        }

        getData()
        function createChart(){
            var areaChartData = {
                labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [
                {
                    label               : 'Digital Goods',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [28, 48, 40, 19, 86, 27, 90]
                }
                ]
            }
        
            var areaChartOptions = {
                maintainAspectRatio : false,
                responsive : true,
                legend: {
                display: false
                },
                scales: {
                xAxes: [{
                    gridLines : {
                    display : false,
                    }
                }],
                yAxes: [{
                    gridLines : {
                    display : false,
                    }
                }]
                }
            }
        
            //-------------
            //- LINE CHART -
            //--------------
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = $.extend(true, {}, areaChartOptions)
            var lineChartData = $.extend(true, {}, areaChartData)
            lineChartOptions.datasetFill = false
        
            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })
        }
    })
  </script>
@endpush