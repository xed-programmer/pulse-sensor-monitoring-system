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
    <div class="col-12 col-sm-6 col-md-4">        
        <div class="info-box">            
            <input type="text" id="{{ 'device'.$i }}" class="knob" data-skin="tron" data-thickness="0.2" data-width="90"
            data-height="90" data-fgColor="#3c8dbc" data-readonly="true">

            <div class="info-box-content">
              <span class="info-box-text">Patient: <span id="{{ 'name'.$i }}">Patient Name</span></span>
              <span class="info-box-text">Condition: <span id="{{ 'condition'.$i }}">Condition</span></span>
              <span class="info-box-text">SpO2 Level: <span id="{{ 'spo2'.$i }}">SpO2</span><small>%</small></span>
              <span class="info-box-text">Heart rate: <span id="{{ 'hr'.$i }}">HR</span></span>

            </div>            
        </div>
    </div>        
    @endforeach
</div>
<div class="row">
    @forelse ($devices as $i => $device)
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
    @empty
    <div class="col-md-12">
        <h1 class="text-center text-gray">No Device/Pulse Sensor</h1>
    </div>
    @endforelse
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
                url: '{{ route("patient.pulse") }}'
            }))
            .then((data,textStatus,jqXHR)=>{
                let datas = JSON.parse(data)
                // console.log(datas);
                for(var i = 0; i<datas.length; i++){
                    Object.keys(datas[i]).forEach(key => {
                        // console.log(datas[i][key]);
                        let tempData = datas[i][key]
                        let labels = []
                        let hr = []
                        let spo2 = []
                        for (let i = tempData.length-1; i >=0 ; i--) {                        
                            labels.push(new moment(tempData[i]['created_at']).format('MMM Do YYYY h:mm:ss a'))
                            hr.push(tempData[i]['hr'])
                            spo2.push(tempData[i]['spo2'])
                        }
                        createChart(labels, hr, spo2, tempData[0]['patient']['name'], '#lineChart'+key)                    
                    });
                }
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

        function getPatientLatestPulse(){
            $.when($.ajax({
                method:'POST',
                url: '{{ route("latest.patient.pulse") }}'
            }))
            .then((data,textStatus,jqXHR)=>{
                let datas = JSON.parse(data)                
                for(var i = 0; i<datas.length; i++){
                    Object.keys(datas[i]).forEach(key => {
                        let tempData = datas[i][key][0]
                        console.log(tempData);
                        $('#name'+i).text(tempData['patient']['name'])
                        $('#device'+i).val(tempData['spo2'])
                        $('#device'+i).trigger('change')
                        $('#spo2'+i).text(tempData['spo2'])
                        $('#hr'+i).text(tempData['hr'])
                    });
                }
            })
        }
        
        getPatientLatestPulse()
        setInterval(() => {
            // getData()
            getPatientLatestPulse()
        }, 3000);
    })
</script>
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script>
    $(function () {
      /* jQueryKnob */
  
      $('.knob').knob({
        draw: function () {
  
          // "tron" case
          if (this.$.data('skin') == 'tron') {
  
            var a   = this.angle(this.cv)  // Angle
              ,
                sa  = this.startAngle          // Previous start angle
              ,
                sat = this.startAngle         // Start angle
              ,
                ea                            // Previous end angle
              ,
                eat = sat + a                 // End angle
              ,
                r   = true
  
            this.g.lineWidth = this.lineWidth
  
            this.o.cursor
            && (sat = eat - 0.3)
            && (eat = eat + 0.3)
  
            if (this.o.displayPrevious) {
              ea = this.startAngle + this.angle(this.value)
              this.o.cursor
              && (sa = ea - 0.3)
              && (ea = ea + 0.3)
              this.g.beginPath()
              this.g.strokeStyle = this.previousColor
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
              this.g.stroke()
            }
  
            this.g.beginPath()
            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
            this.g.stroke()
  
            this.g.lineWidth = 2
            this.g.beginPath()
            this.g.strokeStyle = this.o.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
            this.g.stroke()
  
            return false
          }
        }
      })
      /* END JQUERY KNOB */
  
    })
  
  </script>
@endpush