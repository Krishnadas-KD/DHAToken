@extends('base')

@section('title')
    Counters
@endsection('title')

@section('content')
<div class="content-viewport">
    <div class="row">
        <div class="col-lg-4 equel-grid">
            
        </div>
        </div>
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
                        <div class="card-title" style="display: block; font-size:30px;">Token Name: <span id="token_name" > </span></div>
                        <div  class="card-title" style="display: block; font-size:30px;">Visa type: <span id="type"> </span></div>
                        <div  class="card-title" style="display: block; font-size:30px;">Section: <span id="section"> </span></div>
                        <div class="grid-body d-flex justify-content-between">
                        @if( $counter_user->service_name == 'Registration' )
                         <button class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#myModal" style="padding:25px 39px 25px 39px; font-size:20px">Cancel</button>
                         @endif
                         @if( $counter_user->service_name == 'Blood Collection' || $counter_user->service_name == 'X-Ray')
                         <button id="complete_a" href="/counter-next/complete" class="btn btn-sm btn-success" style="padding:25px 39px 25px 39px; font-size:20px">Completed</a>
                         @endif
                         @if( $counter_user->service_name == 'Registration' || $counter_user->service_name == 'Blood Collection' )
                         <button id="next_a" href="/counter-next/next" class="btn btn-sm btn-primary" style="padding:25px 39px 25px 39px; font-size:20px">Next</a>
                         @endif
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


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Token</h5>
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
                    <button  type="submit" class="btn btn-danger">Submit</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <p class="grid-header">Token List  <span style=" float: right;" id="pendingCount">Total Pending:</span></p>
                    <div class="grid-body" style="overflow-y: auto;max-height: 400px;">
                        <div class="item-wrapper grid-container" id='token_list'>
                           
                        </div>
                    </div>
            </div>
        </div>

<style>
    .highlight-textarea {
            background-color: #f8f9fa; /* Set the background color */
            color: #000000; /* Set the text color */
            border: 1px solid #ced4da; /* Set border color */
            border-radius: .2rem; /* Add some border radius for aesthetics */
            resize: none; /* Disable resizing of the textarea */
            min-height: 150px; /* Set a minimum height */
        }
    .card-title {
    display: block; /* Make each element a block element */
    margin-bottom: 10px; /* Add some spacing between elements */
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Adjust column width as needed */
        gap: 10px; /* Adjust the gap between cards */
    }
    .custom-link {
        color: inherit;
        text-decoration: none;
        user-select: none;
        cursor:pointer;
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


    <script>
    $(document).ready(function() {
        var scrollPosition = $('#token_list').scrollTop();

        token_list();
        var isProcess=false;
        $('#complete_a').on('click',function()
        {
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
                         isProcess=false;
                        refresh();
                        token_list();
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


        $('#next_a').on('click',function()
        {
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
                         isProcess=false;
                        refresh();
                        token_list();
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

        $('#next_token').on('click',function()
        {
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
                        }
                        else{
                            isProcess=false;
                        }
                    },
                    error: function(xhr, status, error) {
                        
                        console.log(xhr.responseText);
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
                        $('#complete_a').attr('href', '/counter-next/'+response.data.current_token.id+'/Completed');
                        $('#next_a').attr('href', '/counter-next/'+response.data.current_token.id+'/next');
                    }
                    else{
                        $('#not_empty').hide();
                        $('#empty').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
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
                       for (var j = 0; j < response.data.queue_token.length; j++) {
                                var cardDetails=response.data.queue_token[j];
                                var div = $('<div>').addClass('custom-link');
                                var card = $('<div>').addClass('card');
                                card.attr('name', 'retoken');
                                card.attr('value', cardDetails.id);
                                card.attr('data-value', cardDetails.token_name);
                                var cardBody = $('<div>').addClass('card-body');
                                var cardTitle = $('<h3>').css({'text-align':'center','cursor':'pointer'});
                                var tokenDetails2=$('<p>').css({'text-align':'center','font-size':'17px','cursor':'pointer'});
                                var tokenStatus=$('<p>').css({'text-align':'center','font-size':'17px','cursor':'pointer'});
                                var tokenHead = $('<b>');
                                cardTitle.append(tokenHead.text('Token: '),' '+cardDetails.token_name+'');
                                tokenDetails2.append(('Type: '),' '+cardDetails.section+'');
                                tokenStatus.append((cardDetails.token_status));
                                cardBody.append(cardTitle,tokenDetails2,tokenStatus);
                                card.append(cardBody);
                                div.append(card);
                                $('#token_list').append(div);
                                $('#token_list').scrollTop(scrollPosition);
                                select_call();
                       }
                       $("#pendingCount").text('Total Pending : '+response.data.total_count)
                    }
                    else{
                        console.log(response.data);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });

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
                                        console.log(xhr.responseText);
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
