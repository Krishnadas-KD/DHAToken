@extends('base')

@section('title')
    Dashboard
@endsection('title')

@section('style-css')

<style>
    .centered {
        text-align: center;
        align-content: center;
    }

    .ticket {
        width: 390px;
        /* max-width: 155px; */
    }

    img {
        max-width: inherit;
        width: inherit;
    }



    @media print {
        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }
    @page { size: auto;  margin: 0mm; }

</style>


@endsection('style-css')
@section('content')
<div class="content-viewport">
    <div class="row" id="det-div">
        <div class="col-lg-5 col-md-6 col-sm-12 equel-grid">
            <div class="grid">
                <div class="grid-body">
                    <div class="d-flex mb-3">
                        <small class="mb-0 text-primary">Token Information</small>
                    </div>
            
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <p class="text-black">Service Type </p>
                        <p class="text-gray">{{ $customer_token->type }}</p>
                    </div>

                    <div class="split-header mt-3">
                        <p class="card-title">Token</p>
                        <span class="btn action-btn btn-xs component-flat" data-toggle="tooltip" data-placement="left">
                            {{-- <i class="mdi mdi-information-outline text-muted mdi-2x"></i> --}}
                        </span>
                    </div>
                    <div class="d-flex align-items-end mt-2">
                        <h3>{{ $customer_token->token_name }}</h3>
                        <p class="ml-1 font-weight-bold"></p>
                    </div>
                    <div class="d-flex mt-2">
                        <div class="wrapper d-flex pr-4">
                            <small class="text-success font-weight-medium mr-2">Series</small>
                            <small class="text-gray">{{ $customer_token->section }}</small>
                        </div>
                    </div>
                    <div class="d-flex flex-row mt-4 mb-4">

                        <a class="btn btn-outline-light text-gray component-flat w-50 mr-2" href="{{ route('token_index') }}">NEW CUSTOMER</a>
                        <button id="printToken" class="btn btn-primary w-50 ml-2">PRINT TOKEN</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>


<div class="row d-none" id="print-div" style="margin:0px !important">
    <div style="border: 1px solid; padding:5px; border-radius: 10px;">
    <br>
        <div class="ticket" style="text-align: center">
            <h2>DHA-NEW MUHAISNAH MEDICAL FITNESS CENTER</h2> 
        </div>
        <div>
            <div style="text-align: left; padding-top: 10px; border-radius:10px;"></div>
                <div style=" border: 1px solid; padding:5px; margin: 2px 10px 2px 10px;">
                    <h4 class="centered" >TOKEN NO.</h4>
                    <h1 class="centered" style="font-size: 330%;">  {{ $customer_token->token_name }}</h1>
                </div>
                <h3 class="centered" s>VISA MEDICAL {{$customer_token->type}}</h3> 
               
                <div class="pl-2" class="centered" style="text-align:center;">
                    DATE & TIME:{{ \Carbon\Carbon::parse($customer_token->created_at) }}
                </div>
            <p class="centered">
                Thank you for choosing us... <br />
            </p>
            <br>
            <div class="pt-3"></div>
            <hr>
        </div>
    </div>
</div>

@stop

@section('script')
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        // $('.page-content-wrapper').css('margin-top', '1px;');
        $('#printToken').click(function() {

        //    alert('Printing...');
            $('#det-div').addClass('d-none');
            $('#footer').addClass('d-none');
            $('#header-div').addClass('d-none');
            $('#print-div').removeClass('d-none');
            $('#succesmsg').addClass('d-none');

            window.print();
            $('#print-div').addClass('d-none');
           window.location.href = "/print-token/{{$customer_token->id}}";

           
          //  printFunc();
           //   printFunc();

        });
        // JsBarcode("#barcode", "Hi world!");

    });

    function printFunc() {
            var divToPrint = document.getElementById('print-div');



            var htmlToPrint = '' +
                `<style type="text/css">
                    *{
                        font-size: 95%
                    }
                    table th, table td {
                        border:1px solid #000;
                        padding;0.5em;
                    }
                    hr{
                        border-top: 1px solid rgb(0 0 0);
                    }
                    img{
                        width: 60%;
                        padding-bottom: 10px;
                    }

                </style>`;
            htmlToPrint = divToPrint.outerHTML;

           // console.log(htmlToPrint);

            //alert("Printing...");
            newWin = window.open("");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
            return true;
        }


</script>

@endsection('script')
