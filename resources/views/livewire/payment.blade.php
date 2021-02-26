
  <div class="container">

    <div class="row">
          <div class="col-md-12">
              @if(session()->has('message'))
              <div class="alert alert-warning">
                  {{ session('message') }} 
              </div>  
              @endif 
          </div>
      </div> 

      <div class="row justify-content-center">
          <div class="col-md-6"> 
              @if($is_pay == 1)
              <div class="card">
                  <div class="col-md-12">
                      <div class="row">
                         <div class="col">
                            <table class="table" style="border-top : hidden">
                                  <tr>
                                      <td>Virtual Akun</td>
                                      <td>:</td>
                                      <td>{{$va_number}}</td>
                                  </tr>
                                  <tr>
                                      <td>Bank</td>
                                      <td>:</td>
                                      <td>{{$bank}}</td>
                                  </tr>
                                  <tr>
                                      <td>Total Harga</td>
                                      <td>:</td>
                                      <td>{{$gross_amount}}</td>
                                  </tr>
                                  <tr>
                                      <td>Status</td>
                                      <td>:</td>
                                      <td>{{$transaction_status}}</td>
                                  </tr>
                                  <tr>
                                      <td>Batas Waktu Pembayaran</td>
                                      <td>:</td>
                                      <td>{{$deadline}}</td>
                                  </tr>
                            </table>  
                            <button class="btn btn-primary btn-block" wire:click="konfirmasiPembayaran({{$order_id}})" >
                                Konfirmasi telah terbayar
                            </button> 
                            <br>
                        </div> 
                    </div>
                </div>
            </div>
            @endif
          </div>   
      </div>
  </div>
  <div>
  
  @if($is_pay == 0)
  <div class="container">
    <div class="row">
        <div class="col-md-12">
          <button id="pay-button" type='button' class='btn btn-primary center-block'>pay!</button>
        </div>
    </div>
  </div>
  @endif




    <form id="payment-form" method="get" action="Payment">
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <input type="hidden" name="result_data" id="result-data" value=""></div>
      <input type="hidden" name="result_type" id="result-type" value=""></div>
    </form>
     
   </body>

<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-RVrIF1elaKLhtnrT"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step

        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');
        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          //resultType.innerHTML = type;
          //resultData.innerHTML = JSON.stringify(data);
        } 

        snap.pay('<?=$token?>', {
          // Optional
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result); 
            $("#payment-form").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      };
    </script>
