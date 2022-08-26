<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Pulse Report</title>
</head>
<body>
<h1>Pulse Report</h1>
<h2>{{ $details->user->created_at->format('M d, Y h:m:s A') }}</h2>
<table>
<tr>
<td><p><strong>{{ $details->hr }}</strong> <span>bpm</span></p></td>
</tr>
<tr>
<td><p>SPO2 <strong>{{ $details->spo2 }}</strong>%</p></td>
</tr>
</table>

<p>
Patient's heart rate is 
@if($details->hr > 100)
above 100 beats per minute.
The patient should visit a doctor immediately.
@elseif ($details->hr < 60)
below 60 beats per minute.
The patient should visit a doctor immediately.
@else
normal
@endif
</p> <br>
<p>
Patient's oxygen saturation level is         
@if ($details->spo2 < $details->spo2_limit)
below {{ $details->spo2_limit }}%.
The patient should visit a doctor immediately.
@else
{{ $details->spo2 }}
@endif
</p> <br>

Truly,<br>
{{ config('app.name') }}
</body>
</html>