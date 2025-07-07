@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="panel panel-default">
                <div class="panel-heading">Pannello di controllo</div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="row" style="padding: 20px;">
                    <div class="col-sm-6">
                        <h3>Saldo di {{ $wallet->user->name }}</h3>
                        <p style="text-align: center">
                            <button type="button" class="btn btn-primary btn-lg btn-block">
                                @if(!is_null($user->wallet->balance))
                                    {{ $user->wallet->balance }}
                                @else
                                    0.000
                                @endif
                                MVC
                            </button>
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <h3>Referenti</h3>
                        <p>Puoi guadagnare 2 MVC per ogni persona che inviti. Condividi semplicemente il tuo link di riferimento e riceverai 2 MVC per ogni utente che si registra usando il tuo link.</p>
                        <p>
                            Numero di referenti:
                            <b>
                                @if(!is_null($user->wallet->balance))
                                    {{ $user->wallet->refferal }} Utente
                                @else
                                    0 Utente
                                @endif
                            </b>
                        </p>
                    </div>

                    <div class="col-sm-12 form-group">
                        <h3>Link di riferimento</h3>
                        <div class="form-control disabled">{{ url('/') }}/{{ Auth::user()->referido }}</div>
                    </div>

                    <div class="col-sm-12">
                        <form class="" action="{{route('retirarPost')}}" method="post">
                            {{ csrf_field() }}
                            @if($user->wallet->balance >= 2)
                                <button class="btn btn-primary btn-lg btn-block">Preleva MVC</button>
                            @else
                                <div class="btn btn-danger btn-lg btn-block">
                                    Hai bisogno di almeno 20 MVC per prelevare
                                </div>
                            @endif
                        </form>

                        <form class="form-group" action="{{ route('editarPost') }}" method="post">
                            {{ csrf_field() }}
                            <h3>Cambia indirizzo wallet</h3>
                            <input type="text" name="address" class="form-control" value="{{ Auth::user()->address }}">
                            <button class="btn btn-primary btn-lg btn-block">Modifica</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
