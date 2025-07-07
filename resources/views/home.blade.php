
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
    <p>Compra e vendi MVC cliccando qui</p>  
  </div>  
</a>  

  </div>  
</div>  
<div id="SC_TBlock_541497" class="SC_TBlock"><div>  
<h3>🔹 Informazioni Faucet</h3>

@if($faucetBalance !== null)
<p><strong>Saldo disponibile:</strong> {{ number_format($faucetBalance, 5) }} MVC</p>
@else
<p class="text-danger">❌ Impossibile recuperare il saldo del faucet.</p>
@endif

@if($nodeStatus !== null)
<p><strong>Blocco corrente:</strong> {{ $nodeStatus['blockCount'] ?? 'N/D' }}</p>
<p><strong>Versione del nodo:</strong> {{ $nodeStatus['version'] ?? 'N/D' }}</p>
<p><strong>Peer attivi:</strong> {{ $nodeStatus['peerCount'] ?? 'N/D' }}</p>
@else
<p class="text-danger">❌ Stato del nodo non disponibile.</p>
@endif


@if($feeInfo !== null)
<p><strong>Fee minima di rete:</strong> {{ number_format($feeInfo['minimalFee'] / 100000, 5) }} MVC</p>
@else
<p class="text-warning">⚠️ Informazioni fee non disponibili.</p>
@endif




</div>...</div>  
      </div>  
    </div>    <!-- content -->    <div class="col-md-9 ">  
    <div class="panel panel-default">  
      <div class="panel-heading">Pannello di controllo</div>  <div class="panel-body text-center">  
    <p>Mevacoin nasce come simbolo di unione e progresso digitale.  
Non è solo una criptovaluta: è uno strumento creato per rafforzare l’economia locale e dare voce a una nuova generazione di utenti.  
Pensata per la comunità, vicina alle persone, pronta a diventare parte della vita quotidiana di chi crede in un futuro più libero e connesso.</p>


    @if (session('status'))  
      <div class="alert alert-success">  
          {{ session('status') }}  
      </div>  
    @endif  

    <p class="alert alert-info" role="alert">  
      Per prelevare devi raggiungere 20 MVC. Il pulsante sarà sbloccato ogni 2 ore e ti darà un importo di 0.5 MVC  
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
          Inizia a guadagnare MVC  
        </button>  
      @else  

        @if($wallet->last_retiro <=  \Carbon\Carbon::now())  
          <input type="hidden" name="dato" value="retirar">  
          <button id="envio" class="btn btn-success btn-lg btn-block" style="cursor: pointer">  
            Preleva MVC  
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
      <div class="panel-heading">Social MVC</div>  
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

