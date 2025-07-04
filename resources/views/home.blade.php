
@extends('layouts.app')

@section('content')

<div class="container">  
    <div class="row">    <!-- sidebar -->  <div class="col-sm-3">  
  <div class="">  
    <div class="panel panel-default">  
        <div class="panel-heading">Telegram</div>  
        <div class="panel-body text-center">  
          <a href="https://t.me/MercoinTALK">  
        <div class="">  
          <i class="fa fa-telegram fa-5x" aria-hidden="true"></i>  
          <h3 style="color: black"> Telegram </h3>  
          <p>Accedi a contenuti esclusivi cliccando qui</p>  
        </div>  
      </a>  
        </div>  
  </div>  
  <div class="panel panel-default">  
  <div class="panel-heading">Exchange</div>  

  <div class="panel-body text-center">  

    <a href="https://www.southxchange.com/Market/Book/MRN/BTC">  
  <div class="">  
    <i class="fa fa-exchange fa-5x" aria-hidden="true"></i>  
    <h3 style="color: black"> Southexchange</h3>  
    <p>Compra e vendi MRN cliccando qui</p>  
  </div>  
</a>  

  </div>  
</div>  
<div id="SC_TBlock_541497" class="SC_TBlock"><div>  
<h3>Saldo Faucet</h3>  
@if($faucetBalance !== null)  
<p>Altezza della blockchain: {{ number_format($faucetBalance) }}</p>

@else
<p>Impossibile caricare lo stato del nodo</p>
@endif

</div>...</div>  
      </div>  
    </div>    <!-- content -->    <div class="col-md-9 ">  
    <div class="panel panel-default">  
      <div class="panel-heading">Pannello di controllo</div>  <div class="panel-body text-center">  
    <p>Chiamata così in onore del MERCOSUR, è una nuova altcoin che, a differenza delle altre criptovalute, pensata per essere utilizzata esclusivamente nella regione latinoamericana. Questo non significa che siano vietate transazioni con il resto del mondo, ma che la regione sia la prima ad adottarla come criptovaluta ufficiale. L'obiettivo è che i cittadini della comunità si sentano parte di essa.</p>  

    @if (session('status'))  
      <div class="alert alert-success">  
          {{ session('status') }}  
      </div>  
    @endif  

    <p class="alert alert-info" role="alert">  
      Per prelevare devi raggiungere 20 MRN. Il pulsante sarà sbloccato ogni 2 ore e ti darà un importo di 0.5 MRN  
    </p>  

    <p>Tempo rimanente:</p>

{{-- DEBUG TEMPORANEO --}}

<div class="alert alert-warning">  
  <strong>Debug:</strong><br>  
  last_retiro =   
  @if(!isset($wallet->last_retiro))  
    <span style="color: red;">NULL (non impostato)</span>  
  @else  
    <span style="color: green;">{{ $wallet->last_retiro }}</span><br>  
    Ora attuale: {{ \Carbon\Carbon::now() }}<br>  
    Differenza: {{ \Carbon\Carbon::parse($wallet->last_retiro)->diffForHumans() }}  
  @endif  
</div>  <form class="" action="{{ route('perfilPost')}}" method="post">  
      <center>  
        <div class="g-recaptcha" data-sitekey="6Ld2rlorAAAAAB72L6WzCq6TDrcXkSJi9CgcENH4"></div>  
      </center>  
      {{ csrf_field() }}  

      @if(!isset($wallet->last_retiro))  
        <input type="hidden" name="dato" value="empezar">  
        <button id="envio" class="btn btn-info btn-large" style="cursor: pointer">  
          Inizia a guadagnare MRN  
        </button>  
      @else  

        @if($wallet->last_retiro <=  \Carbon\Carbon::now())  
          <input type="hidden" name="dato" value="retirar">  
          <button id="envio" class="btn btn-success btn-lg btn-block" style="cursor: pointer">  
            Preleva MRN  
          </button>  
        @else  
          <p>Ti restano <b>  
            {{  
             \Carbon\Carbon::parse($wallet->last_retiro)->diffForHumans()  
            }}  
          </b></p>  
          <div id="envio" class="btn btn-danger btn-lg btn-block" style="cursor: pointer">  
            Non puoi ancora prelevare  
          </div>  
        @endif  

      @endif  
    </form>  

    <div id="SC_TBlock_541490" class="SC_TBlock">caricamento...</div>  

  </div>  
</div>

  </div>    <div class="col-md-3 ">  
    <div class="panel panel-default">  
      <div class="panel-heading">Esploratore</div>  
      <div class="panel-body text-center">  
        <a href="https://t.me/MercoinTALK">  
          <div class="">  
            <i class="fa fa-google-wallet fa-5x" aria-hidden="true"></i>  
          </div>  
        </a>  
      </div>  
    </div>  
  </div>    <div class="col-md-3 ">  
    <div class="panel panel-default">  
      <div class="panel-heading">Social MRN</div>  
      <div class="panel-body text-center">  
        <a href="https://beta.mercoin.org/">  
          <div class="">  
            <i class="fa fa-heart fa-5x" aria-hidden="true"></i>  
          </div>  
        </a>  
      </div>  
    </div>  
  </div>    <div class="col-md-3 ">  
    <div class="panel panel-default">  
      <div class="panel-heading">Wallet</div>  
      <div class="panel-body text-center">  
        <a href="https://mercoin.org/recursos/">  
          <div class="">  
            <i class="fa fa-credit-card-alt fa-5x" aria-hidden="true"></i>  
          </div>  
        </a>  
      </div>  
    </div>  
  </div>    <div id="SC_TBlock_544334" class="SC_TBlock col-sm-3">caricamento...</div>  
  <div id="SC_TBlock_544336" class="SC_TBlock col-sm-3">caricamento...</div>  
  <div id="SC_TBlock_544337" class="SC_TBlock col-sm-3">caricamento...</div>  
  <div id="SC_TBlock_544338" class="SC_TBlock col-sm-3">caricamento...</div>  </div>  
</div>  @endsection

