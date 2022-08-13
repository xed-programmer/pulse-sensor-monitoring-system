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
<h2>{{ $details->user->created_at->format('MMMM DD, YYYY hh:mm:s A') }}</h2>
<table>
<tr>
<td><h2>{{ $details->hr }}</h2> bpm</td>
<td>SPO2 <h2>{{ $details->spo2 }}</h2>%</td>
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
@if ($details->spo2 < 90)
below 90%.
@endif
The patient should visit a doctor immediately.
</p> <br>

Truly,<br>
{{ config('app.name') }}
</body>
</html>