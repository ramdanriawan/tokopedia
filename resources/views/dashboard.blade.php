@extends('layouts.app')

@section('content')

<div class="row">
    @include('layouts.dashboard')
</div>

<div class="row">
    <div class='panel panel-container'>
        <div id='chart_div' style='widht: 100%; height: 400px;'>
            
        </div>
    </div>
</div>
    
@endsection

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        @include('layouts.chart')

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
</script>
