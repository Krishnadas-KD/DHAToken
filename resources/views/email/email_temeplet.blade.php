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
    <h1>DHA Daily Report</h1>

    <p>This is the DHA Daily Report Generated {{ now()->format('Y-m-d H:i:s') }}.</p>

    <div   id="printDiv" >
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
</body>
</html>
