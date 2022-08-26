@extends('layouts.admin')

@section('preload')
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60"
        width="60">
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
    {{-- ito yung donut pie sa dashboard --}}
    @foreach ($devices as $i => $device)
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <input type="text" id="{{ 'device'.$i }}" class="knob" data-skin="tron" data-thickness="0.2" data-width="90"
                data-height="90" data-fgColor="#3c8dbc" data-readonly="true" disabled>

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
    {{-- ito naman yung count ng datas --}}
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-procedures"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Patients</span>
                <span class="info-box-number">{{ $pLen }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-laptop-medical"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Devices</span>
                <span class="info-box-number">{{ $dLen }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">{{ $uLen }}</span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEmergency">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Emergency Alert</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center" id="modal-body">          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>          
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@endsection

@push('scripts')
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script>
    $(function () {
        function getPatientLatestPulse(){
            var isAlert = false
            var message = ''
            $.when($.ajax({
                method:'POST',
                url: '{{ route("latest.patient.pulse") }}'
            }))
            .then((data,textStatus,jqXHR)=>{
                let datas = JSON.parse(data)                
                for(var i = 0; i<datas.length; i++){
                    Object.keys(datas[i]).forEach(key => {
                        let tempData = datas[i][key][0]                        
                        $('#name'+i).text(tempData['patient']['name'])
                        $('#device'+i).val(tempData['spo2'])
                        $('#device'+i).trigger('change')
                        $('#spo2'+i).text(tempData['spo2'])
                        $('#hr'+i).text(tempData['hr'])
                        var condition = '';
                        if(tempData['spo2'] > tempData['spo2_limit']){
                            condition='NORMAL'                              
                        }else{
                            condition='SEVERE'
                            isAlert = true
                            message += '<br><h1>'+tempData['patient']['name'] +' IS IN CRITICAL CONDITION</h1><br>'+
                                '<h3>SpO2 Level: ' + tempData['spo2'] + '% <br>'+ 
                                    new moment(tempData['created_at']).format('MMM Do YYYY h:mm:ss a')
                                    +"</h3>"
                        }
                        $('#condition'+i).text(condition)                        
                    });
                }
                
                if(isAlert){                    
                    $("#modal-body").html(message)
                    $("#modalEmergency").modal('show')
                }
            })

        }
        
        getPatientLatestPulse()
        setInterval(() => {            
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