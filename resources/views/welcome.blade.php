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
<div class="row  justify-content-center">

  <div class="col-sm-2">
    <div class="card">
      <div class="card-body" style="background-color:rgba(30, 30, 255, 1);border-color:rgba(100, 100, 255, 1);border-radius:10px">
        <h3 style="text-align:center;">Issued</h3>
        <h2  style="text-align:center;"><b id="total_issued">0</b></h2>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card">
      <div class="card-body" style="background-color:rgba(30, 255, 20, 1);border-color:rgba(100, 255, 100, 1);border-radius:10px">
        <h3 style="text-align:center;">Registration</h3>
        <h2  style="text-align:center;"><b id="total_registred">0</b></h2>
      </div>
    </div>
  </div>

    <div class="col-sm-2">
    <div class="card">
      <div class="card-body" style="background-color:rgba(255, 30, 30, 1);border-color:rgba(255, 100, 100, 1);border-radius:10px">
        <h3 style="text-align:center;">Blood Collection</h3>
        <h2  style="text-align:center;"><b id="total_blood">0</b></h2>
      </div>
    </div>
  </div>

  </div>

<div >
        <canvas id="myChart" style="height:100px;"></canvas>
    </div>

</div>
</div>

 <style>

    </style>

@stop
@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
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
                    renderChart(null);
                }
                else
                {
                    var dataPoints=response.data;
                    renderChart(dataPoints);
                }
            },
            error: function(error) {
                renderChart(null);
            }
        });
    }
    var myChart;
    function renderChart(dataPoint) {
        Chart.register(ChartDataLabels);
        const labels = dataPoint.total.map(item => item.hour ===0 ?'12AM' :(item.hour<12? item.hour +' AM':(item.hour===12?'12 PM':item.hour-12+'PM')));
        const totalCounts = dataPoint.total.map(item => item.count);
        const registerCounts = dataPoint.registration.map(item => item.count);
        const bloodCounts = dataPoint.blood.map(item => item.count);
        //const x_rayCounts = dataPoint.x_ray.map(item => item.count);
        const ctx = document.getElementById('myChart').getContext('2d');
        if (myChart) {
            myChart.destroy();
        }
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels ,
                datasets: [{
                    label: 'Issued',
                    data: totalCounts,
                    backgroundColor: 'rgba(00, 00, 255, 1)',
                    borderColor: 'rgba(40, 40, 251, .8)',
                    borderWidth: 1,
                },{
                    label: 'Register',
                    data: registerCounts,
                    backgroundColor: 'rgba(00, 255, 00, 1)',
                    borderColor: 'rgba(40, 255, 40, .8)',
                    borderWidth: 1
                },{
                    label: 'Blood Collection',
                    data: bloodCounts,
                    backgroundColor: 'rgba(255, 00, 00, 1)',
                    borderColor: 'rgba(255, 40, 40, .8)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                },
            plugins: {
                tooltip: { enabled: false }, // Disable tooltips for better visibility of datalabels
                    legend: { position: 'top' }, // Adjust legend position as needed
                datalabels: {
                anchor: 'end',
                align: 'top',
                formatter: Math.round,
                font: {
                    weight: 'bold',
                    size: 8
                }
                }
            }
            }
        });
        const totalSum = totalCounts.reduce((x, count) => x + count, 0);

        const registerSum = registerCounts.reduce((x, count) => x + count, 0);

        const bloodSum = bloodCounts.reduce((x, count) => x + count, 0);
        $("#total_issued").text(totalSum);
        $("#total_registred").text(registerSum);
        $("#total_blood").text(bloodSum);


    }

         

       
});
</script>
@stop('script')
