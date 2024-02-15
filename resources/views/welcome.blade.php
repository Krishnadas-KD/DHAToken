@extends('base')

@section('title')
    Counters
@endsection('title')

@section('content')
<div class="content-viewport">
<label for="postingDate">Posting Date:</label>
    <input type="date" id="postingDate">

    
    <div style="display: flex; height: 100%;">
    <canvas id="myChart" style="flex: 3;"></canvas>
    <div style="flex: 1; display: flex; flex-direction: column;">
        <canvas id="myPieChart" style="flex: 1;"></canvas>
        <canvas id="myPieChart2" style="flex: 1;"></canvas>
    </div>
</div>


</div>
@stop
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            fetchHourlyTokenCount( '2024-01-15');
            
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
                        var labels = [];
                        var counts = [];
                        var male=[];
                        var female=[];
                        var new_type=[];
                        var renew_type=[];
                        var formattedData = formatHourlyData(response.data);
                        console.log(formattedData);
                        formattedData.forEach(function(item) {
                            labels.push(item.hour);
                            counts.push(item.count);
                            male.push(item.male);
                            female.push(item.female);
                            new_type.push(item.new_t);
                            renew_type.push(item.renew_t);
                        });

                        renderChart(labels, counts,male,female,new_type,renew_type);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            function formatHourlyData(data) {
            var formattedData = [];
            for (var hour = 0; hour < 24; hour++) {
                var hourData = data.find(function(item) {
                    return item.hour == hour;
                });
                if (hourData) {
                    formattedData.push(hourData);
                } else {
                    formattedData.push({hour: hour, count: 0,male:0,female:0,new_t:0,renew_t:0});
                }
            }
            return formattedData;
        }
        var myChart,myPieChart;
            function renderChart(labels, counts,male_count,female_count,new_type_count,renew_type_count) {
                 
                var ctx = $("#myChart");
                if (myChart) {
                    myChart.clear();
                    myChart.destroy();
                }
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Hourly Token Count',
                            data: counts,
                            backgroundColor: 'rgba(75, 192, 192, 0.9)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Time',
                            },
                            labels:labels.map(function(label, index) {
                                return (label>12 ?label-12 :(label===0 ? 12 : label)) + (index < 12 ? 'AM' : 'PM');
                            })

                        }
                    },
            onClick: function(event, elements) {
                if (elements.length > 0) {
                    var index = elements[0].index;
                    var hour = labels[index];
                    updatePieChart(hour, male_count[index], female_count[index], new_type_count[index], renew_type_count[index]);
                }
            }
        }
    });
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
