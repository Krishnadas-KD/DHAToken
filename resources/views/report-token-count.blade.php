@extends('base')

@section('title')
    Token Count
@endsection('title')


@section('style-css')
    <style>
        #TokenCount td
        {
            text-align: left;
            vertical-align: middle;
        }
        #TokenCount th
        {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    @include('datatable-css');
@stop('style-css')

@section('content')
<div class="content-viewport">

    <div class="row">
        <div class="col-lg-12">
            <div class="grid">
                <p class="grid-header">Token Count</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <div class="row showcase_row_area">
                            
                            <div class="col-lg-3 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">Visa Type</label>
                                    <select  class="form-control" id="type" name="type" id="select_counter_type">
                                            <option value="all">ALL</option>        
                                            <option value="NEW">NEW</option>
                                            <option value="RENEW">RENEW</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">Section</label>
                                    <select   id="section" class="form-control" name="section" id="select_counter_type">
                                            <option value="all">ALL</option>        
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">From</label>
                                    <input id="fromDate" class="form-control" type="date"  name="" required>
                                </div>
                            </div>
                            <div class="col-lg-3 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">To</label>
                                    <input id="toDate" class="form-control" type="date" name="" required>
                                </div>
                            </div>
                            <div class="col-lg-3 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">Status</label>
                                    <select  id="status" class="form-control" name="status" id="select_counter_type">
                                            <option value="all">ALL</option>        
                                            <option value="Completed">Completed</option>
                                            <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">&nbsp;</label>
                                    <div class="form-control btn btn-primary btn-sm has-icon" id="loadbtn" style="color: white;"><i class="mdi mdi mdi-autorenew"></i>Reload</div>
                                </div>
                            </div>
                            
                        </div>
                       
                        
<hr/>
<!-- < -->


<div class="container mt-4 custom-container">

  <!-- First Row (1 Card) -->
  <div class="row justify-content-center">
    <div class="col-lg-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title" style=" font-size:25px;">Total Token<br/><span name="total">0</span></h5>
          <!-- Card content goes here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Second Row (2 Cards) -->
  <div class="row justify-content-center">
    <div class="col-lg-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
        <h5 class="card-title" style=" font-size:20px;">RENEW <br/><span name="renew">0</span></h5>
          <!-- Card content goes here -->
        </div>
      </div>
    </div>
    <div class="col-lg-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
        <h5 class="card-title" style=" font-size:20px;">NEW <br/><span name="new">0</span></h5>
          <!-- Card content goes here -->
        </div>
      </div>
    </div>
  </div>

  <!-- Third Row (4 Cards) -->
  <div class="row justify-content-center">

      <div class="col-lg-3 mb-4">
        <div class="card">
          <div class="card-body text-center">
          <h5 class="card-title" style=" font-size:15px;">MALE <br/><span name="renew_male">0</span></h5>
            <!-- Card content goes here -->
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-4">
        <div class="card">
          <div class="card-body text-center">
          <h5 class="card-title" style=" font-size:15px;">FEMALE <br/><span name="renew_female">0</span></h5>
            <!-- Card content goes here -->
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-4">
        <div class="card">
          <div class="card-body text-center">
          <h5 class="card-title" style=" font-size:15px;">MALE <br/><span name="new_male">0</span></h5>
            <!-- Card content goes here -->
          </div>
        </div>
      </div>
      <div class="col-lg-3 mb-4">
        <div class="card">
          <div class="card-body text-center">
          <h5 class="card-title" style=" font-size:15px;">FEMALE <br/><span name="new_female">0</span></h5>
            <!-- Card content goes here -->
          </div>
        </div>
      </div>

  </div>
  <div class="col-lg-2 showcase_content_area">
                                <div class="form-group">
                                    <label for="my-input">&nbsp;</label>
                                    <div class="form-control btn btn-primary btn-sm has-icon" id="printToPDF" style="color: white;"><i class="mdi mdi-cloud-print"></i>Print</div>
                                </div>
                            </div>
</div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div   id="printDiv" style="display:none;">
      <div id="total-taken">
        <h2>DHA-NEW MUHAISNAH MEDICAL FITNESS CENTER </h2> 
        <hr/>
        <h5> From:<span name="from_date"></span> To:<Span name="to_date"></span></h5>
        <table>
          <tr>
            <th colspan="4" class="thtotal">Total Token <br/><span name="total">0</span></th>
          </tr>
          <tr>
            <th colspan="2" class="thtyperenew">RENEW<br/><span name="renew">0</span></th>

            <th colspan="2" class="thtypenew">NEW <br/><span name="new">0</span></th>
          </tr>
          <tr>
            <th  class="thtyperenew">MALE <br/><span name="renew_male">0</span></th>
            <th  class="thtyperenew">FEMALE <br/><span name="renew_female"> 0</span></th>
            <th  class="thtypenew">MALE <br/><span name="new_male">0</span></th>
            <th  class="thtypenew">FEMALE <br/><span name="new_female">0</span></th>
           
          </tr>
          
         
        </table>
        <hr/>
      </div>
          <span style=" font-weight:normal;font-size:10px;text-align:left;">Report time:<span name="report_time"></span>
</div>

@stop


@section('data-table')
    @include('datatable');
@endsection('data-table')


@section('script')

<script>

    $(document).ready(function(){
        
        var table = $('#TokenCount').DataTable({
            responsive:true,
            pageLength:15,
            dom: 'Bfrtip',
            buttons: [
            'excel', 'pdf', 'print'
        ]
        });
        $("#fromDate").val(new Date().toISOString().split('T')[0])
        $("#toDate").val(new Date().toISOString().split('T')[0])


        $("#printToPDF").on("click", function () {
            
            var content = $('#printDiv').html();
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('</head><body>' + content + '</body><style>  #total-taken {text-align: center;font-family: sans-serif;font-size: 16px;}table {border-collapse: collapse;margin: 10px auto;}th, td {border: 1px solid black;padding: 5px;text-align: center;}.thtotal{font-size: 30px;background-color: #eee;}.thtyperenew{font-size: 25px;background-color: rgb(255, 252, 252);}.thtypenew{font-size: 25px;background-color: rgb(222, 191, 191);}th:nth-child(1), th:nth-child(2), th:nth-child(4), th:nth-child(5) {width: 100px;}th:nth-child(3), th:nth-child(6) {width: 50px;}   .centered { text-align: center;align-content: center;} .ticket { width: 390px;} @media print {.hidden-print,.hidden-print * {display: none !important;}} @page { size: auto;  margin: 0mm; } </style></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
            });

 $( "#loadbtn" ).click(function() {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


var from = $('#fromDate').val();
var to = $('#toDate').val();
var type = $('#type').val();
var section = $('#section').val();
var status = $('#status').val();

var url = '{{ route('token_count') }}';
table.clear().draw();
$.ajax({
    type:"POST",
    url: url,
    data: {'from':from,'to':to,'type':type,'section':section,'status':status},
    beforeSend: function() {
        $("#loader").removeClass( "d-none" )

    },
    success:function(response) {
        var arr = response.data;
        let total=0,new_count=0,renew=0;
        let new_male=0,renew_male=0,new_female=0,renew_female=0;
        for (i = 0; i < arr.length; ++i) {
            total=total+arr[i].count;
            if (arr[i].type==="RENEW"){
                renew=renew+arr[i].count;
                if (arr[i].section==="MALE"){
                    renew_male=renew_male+arr[i].count;
                }
                if (arr[i].section==="FEMALE"){
                    renew_female=renew_female+arr[i].count;
                }
            }
            if (arr[i].type==="NEW"){
                new_count=new_count+arr[i].count;
                if (arr[i].section==="MALE"){
                    new_male=new_male+arr[i].count;
                }
                if (arr[i].section==="FEMALE"){
                    new_female=new_female+arr[i].count;
                }
            }   
        }
        $("span[name='total']").text(total);
        $("span[name='renew']").text(renew);
        $("span[name='renew_male']").text(renew_male);
        $("span[name='renew_female']").text(renew_female);
        $("span[name='new']").text(new_count);
        $("span[name='new_male']").text(new_male);
        $("span[name='new_female']").text(new_female);
        $("span[name='from_date']").text(from);
        $("span[name='to_date']").text(to);
        var currentDateTimeString = new Date().toString();
         $("span[name='report_time']").text(currentDateTimeString);
        $("#loader").addClass( "d-none" );
    },
    error:function(response) {

        console.log(response);
        $("#loader").addClass( "d-none" )
    }
});
});

    });
</script>

@endsection('script')

