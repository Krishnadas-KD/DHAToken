@extends('base')

@section('title')
    Counters
@endsection('title')
@section('content')


<div class="content">
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                <div class="grid-body"  style="text-align:center;" id="empty" >
                    <form id="counterselect" action="{{ route('counter_selected') }}" method="POST">
                    @csrf
                        <div class="form-group text-center" >
                        <label for="maleselectlabel">MALE</label><br>
                            <select class="form-control text-center" name="malecounter" id="maleselect" >
                            <option value="" disabled selected>Select an option</option>
                            @foreach ($counter_stat as $cstat)
                                @if( $cstat->counter_section == 'MALE' )
                                <option value="{{$cstat->id}}" @if($cstat->counter_user) class="option-selected" @endif>{{$cstat->counter_name}} - {{$cstat->service}}  @if($cstat->counter_user) -live @endif</option>
                                @endif
                            @endforeach
                            </select>
                        </div>                    
                        <div class="form-group text-center">
                            <label for="femaleselectLable">FEMALE</label>
                            <select class="form-control text-center" name="femalecounter" id="femaleselect">
                            <option value="" disabled selected>Select an option</option>
                            @foreach ($counter_stat as $cstat)
                                @if( $cstat->counter_section == 'FEMALE' )
                                <option value="{{$cstat->id}}"  @if($cstat->counter_user) class="option-selected" @endif>{{$cstat->counter_name}} - {{$cstat->service}}  @if($cstat->counter_user) live @endif</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <button type="submit"  class="btn btn-sm btn-primary" style="padding:25px 39px 25px 39px; font-size:20px">Next</button>
                    </form>
                </div>
                

                
            </div>
        </div>            
    </div>



</div>

<style>

.grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
        gap: 10px; 
    }
    .form-control{
        width: 50%; 
        margin: 0 auto; 
        display: ruby-text; 
        justify-content: center;
    }
    .option-selected
    {
        background-color:#b01e36;
        color:black;
    }
    
    </style>
@stop

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
    $(document).ready(function() {

        $('select').change(function() {
            // Reset all select boxes except the one that was changed
            $('select').not(this).prop('selectedIndex', 0);
        });

        $("#counterselect").submit(function(event) {
           
            var maleSelect = $("#maleselect");
            var femaleSelect = $("#femaleselect");
        
            if (!maleSelect.val() && !femaleSelect.val()) {
                swal("Warning", "Please select counter", "warning");
                event.preventDefault();
            }
            var selectedvalue=(!maleSelect.val())?femaleSelect : maleSelect;
            if (selectedvalue.find('option:selected').attr('class')==="option-selected")
            {
                event.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Already a User in This Counter.",
                    icon: "warning",
                    buttons: {
                        cancel: "Cancel",
                        confirm: "OK",
                    },
                    dangerMode: true,
                })
                .then((userResponse) => {
                    // Handle the user's response
                    if (!userResponse) {
                        event.preventDefault();
                    }
                    else
                    {
                        $('#counterselect').off('submit').submit(); 
                    }
                   
                });
            }


        });

    });
</script>



@stop('script')
