<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical Fitness Center</title>
  <!-- Include Bootstrap CSS -->
  <style>
    body, html {
      height: 100%;
      background: rgb(0,121,109);

      
      @if( $service == 'Blood Collection' )
        background: linear-gradient(207deg, rgb(255, 121, 121) 0%, rgb(182, 13, 13) 57%, rgb(255, 91, 99) 100%); 
      @else
          background: linear-gradient(207deg, rgba(0,121,109,1) 0%, rgba(13,182,166,1) 57%, rgba(20,240,217,1) 100%); 
      @endif
    }
    .centered-text {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top:10px;
    }
    .container-fluid {
      height: 100%;
    }
    .cardheader {
      padding: 20px 5px 20px 5px;
      margin-top: 2px;
      height: 100%;
      color:#fff;
      text-shadow: 2px 2px 4px #000;
      text-align:center;
    }
    .cardheader h1 {
      font-size: 4vw;
      font-weight: bold;
    }

    .tokencard
    {
      border-radius: 10px;
      border: 3px solid #00000052;
      background-color: #1441654a;
      height: 97%;
      display: flex;
      text-align:center;
      box-shadow: 2px 2px 10px;
    }
    .pendingtoken
    {
      border-radius: 10px;
      border: 3px solid #000;
      background-color: #1441654a;
      height: 97%;
      text-align:center;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
        gap: 10px; 
    }

    .tokencard h1
    {
      font-size: 7vw;
    }
    .card {
        border-radius: 10px;
        flex-wrap: nowrap;
        border: 3px solid #000;
        color:#000;
        background-color: #fff;
        Width:100%;
    }
    .card  .counter
    {
      font-size:3vw;
      font-weight: bold;
      display: block; 
      text-align: center;
    }
    .card  .token
    {
      font-size:3vw;
      font-weight: bold;
      background-color:#222;
      color:#fff;
      border-radius: 10px;
      padding:10px 10px 10px 10px;
      display: block; 
      text-align: center;

    }
       .cardnull-token
    {
       font-size:3vw;
      font-weight: bold;
      background-color:#222;
      color:transparent;
      border-radius: 10px;
      padding:10px 10px 10px 10px;

    }
  
   .cardnull {
        background-color: #222;
        border-radius: 10px;
        flex-wrap: nowrap;
        border: 3px solid #000;
        color:#444;
        background-color: #444;
        Width:100%;
    }
      .cardnull-counter
    {
      font-size:3vw;
      color:#666;
      background-color: #444;
      font-weight: bold;
    }
    .card-title {
      display: flex;
      justify-content: space-between;
}

.carheaderpending{
  background-color: #ffffffbd;
  border: 3px solid #33333399;
  border-radius: 10px;
  text-shadow: 1px 1px 2px #000000;
  color:#000;
  margin:10px;
  font-weight: bold;

}
.carheaderpending span{
  font-size:2vw;
}
   
  </style>
  
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


</head>
<body>
  <div class="container-fluid d-flex flex-column">
    <!-- First row with one column -->
    <div class="row" style="margin-bottom: 15px;">
      <div class="col" style="padding-right:5px;padding-left:5px;">
        <div class="cardheader">
          <h1>    {{ strtoupper($service) }}</h1>
        </div>      
      </div>
    </div>

    <!-- Second row with two columns -->
    <div class="row flex-grow-1" >
      <div class="col-8 d-flex " style="padding-right:2px;padding-left:5px;">
        <div class="tokencard flex-grow-1" >
        <div id="tokenDiv" class="row"  style="margin 0 0 0;height:100%;padding: 10px 10px 10px 10px;">
                
                   
        </div> 
      </div>
      </div>

      <div class="col-4 d-flex "  style="padding-left:2px;padding-right:5px;">
        <div class="tokencard flex-grow-1" >
          <div>
     <div class="carheaderpending" >
          <span>WAITING LIST</span>
        </div>      

          <div id="pendingToken" class="row row-cols-1 row-cols-sm-2 row-cols-md-4"  style="padding:10px 10px 10px 10px;">
       
            </div>
         </div>
       </div>
       <div>


    </div>
  </div>

 
</body>

<script>
  $(document).ready(function() {
    $('#cadRow').empty();

       var textArray = [];
        var counters = [];
        var currentIndex = 0;
        function swapText() {
          for (var j = 0; j < counters.length; j++) {
          if(counters[j].type==='new' && counters[j].token!=null)
              {
                var elements = document.querySelectorAll('.card');
                var div = elements[j];
                counters[j].type='display';
                div.style.backgroundColor = '#33cc33';
              }
            }
            for (var j = 0; j < counters.length; j++) {
              if(counters[j].type==='display' && counters[j].token!=null)
              {
                  counters[j].type='old';
                
                 break;
              }
           }


        }
        var  intervalId=setInterval(swapText, 5000); 
        function refresh() {
            $.ajax({
                url: '{{$ajxa_url}}',
                type: 'GET',
                 data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                  $('#tokenDiv').empty();
                  if(response.data.counters) {
                    if (response.data.counters.length<=8)
                    {
                      rowCount=8;
                    }
                    else
                    {
                        rowCount=response.data.counters.length;
                    }
                      for (var i = 0; i < rowCount; i++) {
                          if(i<response.data.counters.length)
                          {
                                      var item = response.data.counters[i];
                                      var no_counter=true;
                                      // Process each item here
                                      var div = $('<div>').addClass('col-lg-6 d-flex justify-content-center align-items-center');
                                      var card = $('<div>').addClass('card');
                                      var cardBody = $('<div>').addClass('card-body').css({'padding-bottom': '0px','padding-top': '0px'});
                                      var cardTitle = $('<div>').addClass('card-title').css({'padding-top':'10px','padding-bottom':'10px', 'margin':'0 0 0 0'});
                                      var counterSpan = $('<span>').addClass('counter centered-text').text('COUNTER '+ item.counter_name);
                                      if (item.token_name===null)
                                      {
                                        var tokenSpan = $('<span>').addClass('cardnull-token .centered-text').text('0');
                                      }
                                      else
                                      {
                                        var tokenSpan = $('<span>').addClass('token centered-text').text(item.token_name);
                                      }
                                      for (var j = 0; j < counters.length; j++) {
                                        if (counters[j].counter === item.counter_name) {
                                          if( counters[j].token != item.token_name)
                                          {
                                              counters[j].token = item.token_name;
                                              counters[j].type='new';
                                          }
                                          no_counter=false;
                                          break; 
                                        }
                                      }
                                      if(counters.length===0 || no_counter)
                                      {
                                          counter={'counter':item.counter_name,'token':item.token_name,'type':'new'};
                                          counters.push(counter);
                                      }
                                      
                                      
                                      cardTitle.append(counterSpan, tokenSpan);
                                      cardBody.append(cardTitle);
                                      card.append(cardBody);
                                      div.append(card);
                                      $('#tokenDiv').append(div);
                          }
                          else{

                                      // empty counter
                                      var div = $('<div>').addClass('col-lg-6 d-flex justify-content-center align-items-center');
                                      var card = $('<div>').addClass('cardnull');
                                      var cardBody = $('<div>').addClass('card-body').css({'padding-bottom': '0px','padding-top': '0px'});
                                      var cardTitle = $('<div>').addClass('card-title').css({'padding-top':'10px','padding-bottom':'10px', 'margin':'0 0 0 0'});
                                      var counterSpan = $('<span>').addClass('cardnull-counter .centered-text').text('No Counter');
                                      var tokenSpan = $('<span>').addClass('cardnull-token centered-text').text('0');
                                      cardTitle.append(counterSpan, tokenSpan);
                                      cardBody.append(cardTitle);
                                      card.append(cardBody);
                                      div.append(card);
                                      $('#tokenDiv').append(div);
                          }
                          
                          
                      }
                   }

                   if(response.data.pendingtoken)
                   {
                    $('#pendingToken').empty();
                     if(response.data.pendingtoken.length<8)
                     {
                      rowCount=8;
                     }
                     else
                     {
                      rowCount=response.data.pendingtoken.length;
                     }
                     for (var i = 0; i < rowCount; i++) {
                              if(i<response.data.pendingtoken.length)
                              {
                                      var pendingToken = response.data.pendingtoken[i];
                                      var div = $('<div>').addClass('col-lg-3');
                                      var card = $('<div>').addClass('card mb-3');
                                      var counterSpan = $('<span>').addClass('ftoken centered-tex').css({'font-size':'2vw'});
                                      var bold = $('<b>').text(pendingToken.token_name);
                                      counterSpan.append(bold);
                                      card.append(counterSpan);
                                      div.append(card);
                                      $('#pendingToken').append(div);
                              }
                              else
                              {
                                      var div = $('<div>').addClass('col-lg-3');
                                      var card = $('<div>').addClass('card mb-3').css({'background-color':'transparent','border-color':'transparent','color':'transparent'});
                                      var counterSpan = $('<span>').addClass('ftoken centered-tex').css({'font-size':'2vw'});
                                      var bold = $('<b>').text('N00');
                                      counterSpan.append(bold);
                                      card.append(counterSpan);
                                      div.append(card);
                                      $('#pendingToken').append(div);
                              }

                         
                     }
                   }
                },
                error: function(xhr, status, error) {
                    console.log("error");
                }
            });
        }
        refresh();
        setInterval(refresh, 5000); // 5000 milliseconds = 5 seconds
    });
  </script>


 <!--  -->

  </html>
