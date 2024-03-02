@extends('base')

@section('title')
    Counters
@endsection('title')

@section('content')

<div class="content-viewport">
<div class="form-group">
    <label for="my-input">Date</label>
    <input  id="postingDate" style="width:250px" class="form-control" type="date"  name="" required>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
      </div>
    </div>
  </div>
</div>


<div>
        <canvas id="myChart"></canvas>
</div>

</div>
</div>

 <style>

    </style>

@stop
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
        $(document).ready(function(){
            var formattedDate = new Date().toISOString().slice(0,10);
            $('#postingDate').val(formattedDate);
            fetchHourlyTokenCount( formattedDate);
            
            $('#postingDate').on('change', function() {
                var postingDate = $(this).val();
                fetchHourlyTokenCount(postingDate);
            });

           function fetchHourlyTokenCount(postingDate) {
                // AJAX request to fetch hourly token count
                $.ajax({
                    url: "/hourly-token-count",
                    method: "POST",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        postingDate: postingDate
                    },
                    success: function(response) {
                        if (response.message==='Failed')
                        {
                            console.log("feild");
                            renderChart(null);
                        }
                        else
                        {
                        var dataPoints=response.data;
                        console.log(dataPoints)
                        renderChart(dataPoints);
                        }
                       

                    },
                    error: function(error) {
                        console.log(error);
                        renderChart(null);
                    }
                });
            }
        
            
        var myChart,myPieChart;


            function renderChart(dataPoind) {
                var chart = new CanvasJS.Chart("chartContainer", {
  animationEnabled: true,
  theme: "light2",
  title: {
    text: "Hourly Token Count"
  },
  axisY: {
    title: "Values"
  },
  axisX: {
    type: "datetime",
    interval: 1,
    valueFormatString: "HH:mm tt",
    labelFormatter: function (e) {
            return e.value===0 ? "12:00 AM": (e.value<12? e.value+":00 AM":(e.value>=12?e.value+":00 PM":e.value)); // Append "am" to the numerical label
        }
  },
  data: [
  {
    type: "line",
    name:"Registration",
    color: "#AAB7F2",
    indexLabel: "{y}",
    showInLegend: true,
dataPoints: dataPoind.registration
  },{
    type: "line",
    name:"Blood",
    color: "#F74D89",
    indexLabel: "{y}",
    showInLegend: true,
    dataPoints: dataPoind.blood
  },{
    type: "line",
    name:"X-Ray",
    color: "#EAD8F7",
    indexLabel: "{y}",
    showInLegend: true,
    dataPoints: dataPoind.x_ray
  },{
    type: "column",
    name:"Total",
    color: "#F5C777",
    indexLabel: "{y}",
    showInLegend: true,
    dataPoints: dataPoind.total
  }]
});
    chart.render();


    }

         

        function updatePieChart(hour, maleCount, femaleCount, newMaleCount, renewMaleCount) {
    if (myPieChart) {
        myPieChart.destroy(); // Destroy the previous pie chart instance
    }

    var ctx = document.getElementById('myPieChart');
    myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female', 'New Male', 'Renew Male'],
            datasets: [{
                data: [maleCount, femaleCount, newMaleCount, renewMaleCount],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Hour ' + hour + ' Details'
            }
        }
    });
}
    });
    </script>
@stop('script')
