@extends('base')

@section('title')
    Counters
@endsection('title')
@section('content')



<div class="content">
    <div class="row" >
        <div class="col-lg-4 equel-grid">
            <div class="grid">
                <p class="grid-header">New Token</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form id="token_male">
                        @csrf  
                                <label for="counter_type">Counter Type</label>
                                <div class="btn-group" role="group" aria-label="Gender Selection" style="width:100%;">
                                <input type="button" style="margin-right:10px" class="btn btn-primary" id="newBtn_male" name="NEW" value="NEW">
                                <input type="button"  style="margin-left:10px" class="btn btn-primary" id="renewBtn_male" name="RENEW" value="RENEW">
                                </div>
                                    <div class="form-group">
                                        <select hidden class="form-control" name="counter_type">
                                            <option value="NEW">NEW</option>
                                            <option value="RENEW">RENEW</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="counter_section">Counter Section:<b style="font-size:17px;font-family: 'Times New Roman', Times, serif;" id="section_name">MALE</b></label>
                                        
                                        <select  hidden   class="form-control" name="counter_section" >
                                            <option value="MALE" selected>MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>
                        <button type="button" name="printToken" style="width:100%;font-size:20px" class="btn btn-sm btn-primary">Save & Print</button>
                        </form>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 ml-auto">
            <div class="grid">
                <p class="grid-header">New Token</p>
                <div class="grid-body">
                    <div class="item-wrapper">
                        <form id="token_female">
                        @csrf  
                                <label for="counter_type">Counter Type</label>
                                <div class="btn-group" role="group" aria-label="Gender Selection" style="width:100%;">
                                <input type="button" style="margin-right:10px" class="btn btn-primary" id="newBtn_female" name="NEW" value="NEW">
                                <input type="button"  style="margin-left:10px" class="btn btn-primary" id="renewBtn_female" name="RENEW" value="RENEW">
                                </div>
                                    <div class="form-group">
                                        <select hidden class="form-control" name="counter_type">
                                            <option value="NEW">NEW</option>
                                            <option value="RENEW">RENEW</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                       <label for="counter_section">Counter Section:<b style="font-size:17px;font-family: 'Times New Roman', Times, serif;" >FEMALE</b></label>
                                        
                                        <select  hidden   class="form-control" name="counter_section" >
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE" selected>FEMALE</option>
                                        </select>
                                    </div>
                        <button type="button"   name="printToken" style="width:100%;font-size:20px" class="btn btn-sm btn-primary">Save & Print</button>
                        </form>
                        </div>
                </div>
            </div>
        </div>



    </div>
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid" >
                    <p class="grid-header">Token List</p>
                    <div class="grid-body" style="overflow-y: auto;max-height: 400px;">
                        <div class="item-wrapper grid-container" id='token_list'>
                            @foreach($cardsData as $card)
                            <a  class="custom-link">
                            <div class="card" value="{{$card['id']}}" name='retoken'>
                                <div class="card-body">
                                    <h3 style="text-align:center"><b>Token:</b> {{ $card['token_name'] }}</h3>
                                    <p style="text-align:left;font-size:15px"><b>Time:</b> {{ \Carbon\Carbon::parse($card['created_at'])->format('Y-m-d H:i') }}</p>
                                    <p style="text-align:left;font-size:15px"><b>Type:</b> {{ $card['section'] }}</p>
                                    <p style="text-align:center;font-size:17px;"> <b> {{ $card['token_status'] }} </b> </p>
                                     
                                </div>
                            </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </div>

<div class="row d-none" id="print-div" style="margin:0px !important">
    <div style="border: 1px solid;  border-radius: 10px; ">
    <br>
        <div class="ticket" style="text-align: center;padding: 0px 0px 0px 0px ;margin: 0px 0px 0px 0px ;" >
            <h2>DHA-NEW MUHAISNAH MEDICAL FITNESS CENTER</h2> 
        </div>
        <div>
            <div style="text-align: centered; padding-top: 10px; border-radius:10px; "></div>
                <div style=" border: 2px solid; padding:5px; margin: 5px 10px 5px 10px; ">
                    <h4 class="centered"  style="padding: 0px 0px 0px 0px ;margin: 0px 0px 0px 0px ;">TOKEN NO.</h4>
                    <h1 class="centered" style="font-size: 330%;padding: 0px 0px 0px 0px ;margin: 0px 0px 0px 0px ;" id="token_name">  </h1>
                </div>
                <h4 class="centered" id="section_type" style="text-align:center;padding: 0px 0px 0px 0px ;margin: 0px 0px 0px 0px ;">  </h4>
                <h3 class="centered" id="visa_type"  style="text-align:center;padding: 0px 0px 0px 0px ;margin: 0px 0px 0px 0px ;">VISA MEDICAL </h3> 
                <div class="pl-2" class="centered" style="text-align:center;padding: 0px 0px 0px 0px ;margin: 0px 0px 0px 0px ;"  id="created_at">
                    DATE & TIME:
                </div>
            <p class="centered" style="text-align:center;padding: 0px 0px 0px 0px ;margin: 0px 0px 0px 0px ;">
                Thank you for choosing us... <br />
            </p>
            
        </div>
        <br>
            <br>
            <br>
    </div>
</div>



<style>
   
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
        gap: 10px; 
    }
    .custom-link {
        color: inherit;
        text-decoration: none;
    }
    .custom-link:hover {
        text-decoration: none; 
        color: inherit; 
    }
    .card {
        background-color: #d5f9fa;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border: 2px solid #000;

    }
   
    </style>
@stop
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
       
        $('#newBtn_male').on('click',function()
        {
               $('#token_male select[name="counter_type"]').val(this.value);
               $('#renewBtn_male').css('background-color', '#696ffb');
               $('#newBtn_male').css('background-color', '#45d65a');
        });
        $('#renewBtn_male').on('click',function()
        {
               $('#token_male select[name="counter_type"]').val(this.value);
               $('#newBtn_male').css('background-color', '#696ffb');
               $('#renewBtn_male').css('background-color', '#45d65a');
        });
        
        $('#newBtn_female').on('click',function()
        {
               $('#token_female select[name="counter_type"]').val(this.value);
               $('#renewBtn_female').css('background-color', '#696ffb');
               $('#newBtn_female').css('background-color', '#45d65a');
        });
        $('#renewBtn_female').on('click',function()
        {
               $('#token_female select[name="counter_type"]').val(this.value);
               $('#newBtn_female').css('background-color', '#696ffb');
               $('#renewBtn_female').css('background-color', '#45d65a');
        });
        
        
        $('button[name="printToken"]').on('click',function()
        {
            var formId = $(this).closest('form').attr('id');
            var type=$('#'+formId+' select[name="counter_type"]').val();
            var section=$('#'+formId+' select[name="counter_section"]').val();

            $.ajax({
                url: '{{ route('token_create' ) }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'type':type,
                    'section':section
                },
                success: function(response) {
                    if(response.data.customer_token!=null)
                    {   
                        var dateString = new Date(response.data.customer_token.created_at);
                        var formattedDate = moment(dateString).format('YYYY-MM-DD   h:mm:ss A');
                        console.log(response.data.customer_token);
                        $('#created_at').text(' DATE & TIME:'+formattedDate);
                        $('#token_name').text(response.data.customer_token.token_name);
                        $('#visa_type').text('VISA MEDICAL '+response.data.customer_token.type);
                          $('#section_type').text(response.data.customer_token.section);
                        var content = $('#print-div').html();
                        var printWindow = window.open('', '_blank');
                        printWindow.document.write('<html><head><title>Print</title>');
                        printWindow.document.write('<link rel="stylesheet" href="print-style.css" type="text/css" media="print">');
                        printWindow.document.write('</head><body>' + content + '</body><style>  .centered { text-align: center;align-content: center;} .ticket { width: 390px;} @media print {.hidden-print,.hidden-print * {display: none !important;}} @page { size: auto;  margin: 0mm; } </style></html>');
                        printWindow.document.close();
                        printWindow.print();
                        printWindow.close();
                    }
                    else{
                        console.log(response.data);
                    }
                },
                error: function(xhr, status, error) {
                    
                    console.log(xhr.responseText);
                }
            });
        });
        function re_print()
        {
                $('[name=retoken]').click(function(event) {
                var nameValue = $(this).attr('value');
                event.preventDefault();
                swal({
                    title: `Are you sure ?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((reprint) => {
                    if (reprint) {
                        $.ajax({
                        url: '/reprint-token/'+nameValue,
                        type: 'GET',
                        success: function(response) {
                            if(response.data.customer_token!=null)
                            {   
                                var dateString = new Date(response.data.customer_token.created_at);
                                var formattedDate = moment(dateString).format('YYYY-MM-DD   h:mm:ss A');

                                $('#created_at').text(' DATE & TIME:'+formattedDate);
                                $('#token_name').text(response.data.customer_token.token_name);
                                $('#visa_type').text('VISA MEDICAL '+response.data.customer_token.type);
                                  $('#section_type').text(response.data.customer_token.section);
                                var content = $('#print-div').html();
                                var printWindow = window.open('', '_blank');
                                printWindow.document.write('<html><head><title>Print</title>');
                                printWindow.document.write('<link rel="stylesheet" href="print-style.css" type="text/css" media="print">');
                                printWindow.document.write('</head><body>' + content + '</body><style>  .centered { text-align: center;align-content: center;} .ticket { width: 390px;} @media print {.hidden-print,.hidden-print * {display: none !important;}} @page { size: auto;  margin: 0mm; } </style></html>');
                                printWindow.document.close();
                                printWindow.print();
                                printWindow.close();  
                            }
                            else{
                                alert(nameValue);
                                console.log(response.data);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                    }
                });
            });
        }
      setInterval(
        function () {
            $.ajax({
                url: '/token-list',
                type: 'GET',
                success: function(response) {
                    if(response.data.cardsData!=null)
                    {   
                        $("#token_list").html("");
                       for (var j = 0; j < response.data.cardsData.length; j++) {
                                var cardDetails=response.data.cardsData[j];
                                var div = $('<a>').addClass('custom-link');
                                var card = $('<div>').addClass('card');
                                card.attr('name', 'retoken');
                                card.attr('value', cardDetails.id);
                                var cardBody = $('<div>').addClass('card-body');
                                var cardTitle = $('<h3>').css({'text-align':'center'});
                                var tokenDetails=$('<p>').css({'text-align':'left','font-size':'15px'});
                                var tokenDetails2=$('<p>').css({'text-align':'left','font-size':'15px'});
                                var tokenStatus=$('<p>').addClass('card-text').css({'text-align':'center','font-size':'17px'});
                                var tokenHead = $('<b>');
                                var tokenHead2 = $('<b>');
                                var tokenHead3 = $('<b>');
                                var dateString = new Date(cardDetails.created_at);
                                var formattedDate = moment(dateString).format('YYYY-MM-DD   h:mm');
                                cardTitle.append(tokenHead.text('Token: '),' '+cardDetails.token_name+'');
                                tokenDetails.append(tokenHead2.text('Time: '),' '+formattedDate+'');
                                tokenDetails2.append(tokenHead3.text('Type: '),' '+cardDetails.section+'');
                                tokenStatus.append((cardDetails.token_status));

                                cardBody.append(cardTitle,tokenDetails,tokenDetails2,tokenStatus);
                                card.append(cardBody);
                                div.append(card);
                                $('#token_list').append(div);
                                
                       }
                    }
                    else{
                        alert(nameValue);
                        console.log(response.data);
                    }
                    re_print();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

        }, 8000);

    });
</script>

@stop('script')
