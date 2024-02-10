<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Add your CSS styles here */
      #total-taken {text-align: center;font-family: sans-serif;font-size: 16px;}table {border-collapse: collapse;margin: 10px auto;}th, td {border: 1px solid black;padding: 5px;text-align: center;}.thtotal{font-size: 30px;background-color: #eee;}.thtyperenew{font-size: 25px;background-color: rgb(255, 252, 252);}.thtypenew{font-size: 25px;background-color: rgb(222, 191, 191);}th:nth-child(1), th:nth-child(2), th:nth-child(4), th:nth-child(5) {width: 100px;}th:nth-child(3), th:nth-child(6) {width: 50px;}   .centered { text-align: center;align-content: center;} .ticket { width: 390px;} @media print {.hidden-print,.hidden-print * {display: none !important;}} @page { size: auto;  margin: 0mm; } 
    </style>
</head>
<body>

@php
    $newMale = 0;
    $newFemale = 0;
    $RenewMale = 0;
    $RenewFemale = 0;
    $New= 0;
    $Renew= 0;
    $Total= 0; // Initialize male count for type 'new'
@endphp

@foreach($result as $line)
    {{-- Check if the record matches the condition: type = 'new' and section = 'male' --}}
    @php
      $Total += $line->count;
    @endphp
    @if($line->type === 'NEW' && $line->section === 'MALE')
        @php
            $newMale += $line->count;
        @endphp
    @endif

    @if($line->type === 'NEW' && $line->section === 'FEMALE')
        @php
            $newFemale += $line->count;
        @endphp
    @endif

    @if($line->type === 'RENEW' && $line->section === 'MALE')
        @php
            $RenewMale += $line->count;
        @endphp
    @endif

    @if($line->type === 'RENEW' && $line->section === 'FEMALE')
        @php
            $RenewFemale += $line->count;
        @endphp
    @endif

    @if($line->type === 'RENEW' )
        @php
            $Renew += $line->count;
        @endphp
    @endif

    @if($line->type === 'NEW' )
        @php
            $New += $line->count;
        @endphp
    @endif

@endforeach

    <h1>DHA Daily Report</h1>

    <p>This is the DHA Daily Report Generated {{ now()->format('Y-m-d H:i:s') }}.</p>

    <div   id="printDiv" >
      <div id="total-taken">
        <h2>DHA-NEW MUHAISNAH MEDICAL FITNESS CENTER </h2> 
        <hr/>

        <table>
          <tr>
            <th colspan="4" class="thtotal">Total Token <br/><span name="total">{{$Total}}</span></th>
          </tr>
          <tr>
            <th colspan="2" class="thtyperenew">RENEW<br/><span name="renew">{{$Renew}}</span></th>

            <th colspan="2" class="thtypenew">NEW <br/><span name="new">{{$New}}</span></th>
          </tr>
          <tr>
            <th  class="thtyperenew">MALE <br/><span name="renew_male">{{$RenewMale}}</span></th>
            <th  class="thtyperenew">FEMALE <br/><span name="renew_female"> {{$RenewFemale}}</span></th>
            <th  class="thtypenew">MALE <br/><span name="new_male">{{$newFemale}}</span></th>
            <th  class="thtypenew">FEMALE <br/><span name="new_female">{{$newMale}}</span></th>
           
          </tr>
          
         
        </table>
        <hr/>
      </div>
          <span style=" font-weight:normal;font-size:10px;text-align:left;">Report time:<span name="report_time"></span>
</div>
</body>
</html>
