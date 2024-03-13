@extends('base')

@section('title')
    Counters
@endsection('title')
@section('content')


<div class="content">
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    @if (!is_null($counter_user))
                    <div class="grid-body" style="text-align:center;">
                        <div class="card-title" style="display: inline-block; margin-right: 30px; font-size:20px;">User Name: {{ $counter_user->name }}</div>
                        <div class="card-title" style="display: inline-block; margin-right: 30px; font-size:20px;">Counter Section: {{ $counter_user->counter_section }}</div>
                        <div class="card-title" style="display: inline-block; margin-right: 30px; font-size:20px;">User Type: {{ $counter_user->type }}</div>
                        <div class="card-title" style="display: inline-block; margin-right: 30px; font-size:20px;"> Counter Name: {{ $counter_user->counter_name }}</div>
                        <div class="card-title" style="display: inline-block; margin-right: 0px; font-size:20px;">Service: {{ $counter_user->service_name }}</div>
                        
                    </div>
                    @else
                         Counter not Assigned
                    @endif
            </div>
        </div>
            
    </div>


    <div class="row">
        <div class="col-lg-12 equel-grid">
            <div class="grid">
            @if (!is_null($counter_user))
                    <div class="grid-body" style="text-align:center;display:none;"  id="not_empty" >
                        <div class="card-title" style="display: block; font-size:30px;"><b>Token Name</b>: <span id="token_name" > </span></div>
                        <div  class="card-title" style="display: block; font-size:30px;"><b>Visa type</b>: <span id="type"> </span></div>
                        <div  class="card-title" style="display: block; font-size:30px;"><b>Section</b>: <span id="section"> </span></div>
                        <div class="grid-body d-flex justify-content-center align-items-center">
                        @if( $counter_user->service_name == 'Registration' )
                         <button class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#myModal" style="padding:25px 39px 25px 39px; font-size:20px;margin-right:150px">Cancel</button>
                         @endif
                         @if( $counter_user->service_name == 'Blood Collection' || $counter_user->service_name == 'X-Ray')
                         <button id="complete_a" href="/counter-next/complete" class="btn btn-sm btn-success" style="padding:25px 39px 25px 39px; font-size:20px">Completed</button>
                         @endif
                         @if( $counter_user->service_name == 'Blood Collection'  )
                         <button id="next_a" href="/counter-next/next" class="btn btn-sm btn-primary" style="padding:25px 39px 25px 39px; font-size:20px">X-Ray</button>
                         @endif
                         @if( $counter_user->service_name == 'Registration' )
                         <button class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#regModel" style="padding:25px 39px 25px 39px; font-size:20px">Next</button>
                         @endif
                         <button id="hold_a" href="token-hold/" class="btn btn-sm btn-warning" style="background-color:rgb(255, 182, 42);border-color:rgb(255, 182, 42);padding:25px 39px 25px 39px; font-size:20px;margin-left:150px">Hold</button>
                    </div>
                    </div>
                    
                    <div class="grid-body"  style="text-align:center;" id="empty" >
                        <div class="card-title" style="display: block; font-size:30px;">Counter Empty</div>
                        <button id="next_token"  class="btn btn-sm btn-primary" style="padding:25px 39px 25px 39px; font-size:20px">Next</button>
                    </div>
                @endif
            </div>
        </div>
</div>



<div class="row">
    <div class="col-lg-6 equel-grid">
        <div class="grid" >
            <p class="grid-header">Token List  <span style=" float: right;" id="total_pendingCount">Total Pending:</span></p>
            <div class="grid-body" style="overflow-y: auto;max-height: 500px;">
                <div class="item-wrapper grid-container" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));" id='token_list'>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 equel-grid">
        <div class="grid" >
            <p class="grid-header">Hold List  <span style=" float: right;" id="hold_pendingCount">Total Pending:</span></p>
            <div class="grid-body" style="overflow-y: auto;max-height: 500px;">
                <div class="item-wrapper grid-container" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));"  id='hold_list'>
                    
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="regModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="regModalLabel">Cancel Token</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="cancel_form"  action="/counter-cancel/" method="GET">
                <div class="modal-body">
                    <div class="form-group">
                            <label for="textArea">Reason</label>
                            <textarea name="reason" class="form-control highlight-textarea"id="reason" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button  type="submit" class="btn btn-danger">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="regModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> X-Ray</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="next_reg"  action="/counter-next/next" method="GET">
                <div class="modal-body">
                    <div class="form-group custom-control-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="yesOption" name="xray" value="1" class="custom-control-input" required>
                            <label class="custom-control-label" for="yesOption">Yes</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="noOption" name="xray"  value="0" class="custom-control-input" required>
                            <label class="custom-control-label" for="noOption">No</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button  type="submit" id="regNext" class="btn btn-sm btn-success">Next</button>
                </div>
                </form>
            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
    $(document).ready(function() {
        var scrollPosition = $('#token_list').scrollTop();

        token_list();
        var isProcess=false;
        $('#complete_a').on('click',function()
        {
          if (isProcess==false)
            {
           isProcess=true;
            var form_url = $(this).attr('href');
            $.ajax({
                url: form_url,
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.data="Done")
                    {   
                        
                        refresh();
                        token_list();
                         isProcess=false;
                    }
                    else
                    {
                      isProcess=false;
                    }
                },
                error: function(error) {
                    isProcess=false;
                    console.log("error");
                }
            });
            }
        });


        $('#next_a').on('click',function()
        {

          if (isProcess==false)
            {
            isProcess=true;
            
            var form_url = $(this).attr('href');
            $.ajax({
                url: form_url,
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.data="Done")
                    {   
                         
                        refresh();
                        token_list();
                        isProcess=false;
                        
                    }
                    else
                    {
                      isProcess=false;
                    }
                },
                error: function(error) {
                    isProcess=false;
                    console.log("error");
                }
            });
            }
           
        });
        $('#hold_a').on('click',function()
        {
          if (isProcess==false)
            {
            isProcess=true;
            var form_url = $(this).attr('href');
            $.ajax({
                url: form_url,
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.data="Done")
                    {   
                        
                        refresh();
                        token_list();
                        isProcess=false;
                    }
                    else
                    {
                      isProcess=false;
                    }
                },
                error: function( error) {
                    isProcess=false;
                    console.log("error");
                }
            });
            }
        });
        
        $('#regNext').click(function() {
        var loader = $('#loader');
        // Toggle the visibility of the loader
        loader.toggleClass('d-none');
        // Hide the loader after 3 seconds (3000 milliseconds)
        
      });
        $('#next_token').on('click',function()
        {
            $(this).prop('disabled', true);
            if (isProcess==false)
            {
                isProcess=true;
                var formId = $(this).closest('form').attr('id');
                $.ajax({
                    url: '/counter-next/call',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.data==="Done")
                        {   

                            refresh();
                            token_list();
                            isProcess=false;
                            
                            setTimeout(function() {$('#next_token').prop('disabled', false); }, 5000);
                        }
                        else{
                            isProcess=false;
                            
                            setTimeout(function() {$('#next_token').prop('disabled', false); }, 5000);
                        }
                    },
                    error: function( error) {
                        isProcess=false;
                        console.log("error");
                    }
                });
         }
         token_list();
        });

        refresh();
        
        setInterval(function(){ token_list()}, 5000);

        function refresh() {
            $.ajax({
                
                url: '{{ route('counter_user_refreshcall') }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.data.current_token)
                    {   
                        $('#not_empty').show();
                        $('#empty').hide();
                        $('#token_name').text(response.data.current_token.token_name);
                        $('#type').text(response.data.current_token.type);
                        $('#section').text(response.data.current_token.section);
                        $('#cancel_form').attr('action', '/counter-cancel/'+response.data.current_token.id);
                        if (response.data.current_token.is_x_ray===1 &&  response.data.current_token.service_name==='Blood Collection')
                        {
                            $('#next_a').show();
                            $('#next_a').attr('href', '/counter-next/'+response.data.current_token.id+'/next');
                            $('#complete_a').hide();
                        }
                        else
                        {
                            $('#complete_a').show();
                            $('#next_a').hide();
                            $('#complete_a').attr('href', '/counter-next/'+response.data.current_token.id+'/Completed');
                        }
                        $('#hold_a').attr('href', '/token-hold/'+response.data.current_token.id+'');
                        $('#next_reg').attr('action', '/counter-next/'+response.data.current_token.id+'/next');
                        
                    }
                    else{
                        $('#not_empty').hide();
                        $('#empty').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("error");
                }
            });
        }
        function token_list() {
            $.ajax({
                url: '{{ route('counter_token_list_ajax') }}',
                type: 'GET',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.data.queue_token!=null)
                    {   
                        $("#token_list").html("");
                        $('#hold_list').html("");
                        var total_pendingCount=0;
                        var hold_pendingCount=0;
                       for (var j = 0; j < response.data.queue_token.length; j++) {
                                var cardDetails=response.data.queue_token[j];
                                var div = $('<a>').addClass('custom-link');
                                var card = $('<div>').addClass('card');
                                card.attr('name', 'retoken');
                                card.attr('value', cardDetails.id);
                                var cardBody = $('<div>').addClass('card-body').css({'padding':'0 10px 0 10px'});
                                var cardTitle = $('<h4>').css({'text-align':'center','font-size':'20px'});
                                var tokenDetails2=$('<p>').css({'text-align':'center','font-size':'14px'});
                                var tokenStatus=$('<p>').addClass('card-text').css({'text-align':'center','font-size':'13px'});
                                var tokenHead = $('<b>');
                                var tokenHead2 = $('<b>');
                                var tokenHead3 = $('<b>');
                                cardTitle.append(tokenHead.text('Token: '),' '+cardDetails.token_name+'');
                                tokenDetails2.append(tokenHead3.text('Type: '),' '+cardDetails.section+'');
                                tokenStatus.append((cardDetails.token_status));
                                cardBody.append(cardTitle,tokenDetails2,tokenStatus);
                                card.append(cardBody);
                                div.append(card);
                                if(cardDetails.closed === 0)
                                {
                                    total_pendingCount+=1;
                                    $('#token_list').append(div);
                                }
                                else
                                {
                                    hold_pendingCount+=1;
                                    $('#hold_list').append(div);
                                }
                                
                       }
                       $("#total_pendingCount").text('Total Pending : '+total_pendingCount)
                       $("#hold_pendingCount").text('Total Pending : '+hold_pendingCount)
                    }
                    select_call();
                },
                error: function(xhr, status, error) {
                    console.log("error");
                }
            });
            
         setTimeout(function() {$('#next_token').prop('disabled', false); }, 5000);
        }

         function select_call(){
                if($("#empty").is(":visible"))
                {
                            $('[name=retoken]').click(function(event) {
                            var nameValue = $(this).attr('value');
                            var tokenName = $(this).attr('data-value');
                            event.preventDefault();
                            swal({
                                title: `Are you sure To call Token `+tokenName+` ?`,
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((reprint) => {
                                if (reprint) {
                                    $.ajax({
                                    url: '/select-call-token/'+nameValue,
                                    type: 'GET',
                                    success: function(response) {
                                        refresh();
                                    },
                                    error: function(xhr, status, error) {
                                        console.log("error");
                                    }
                                });
                                }
                            });
                        });    
            }
               
        }

    });
</script>



@stop('script')
