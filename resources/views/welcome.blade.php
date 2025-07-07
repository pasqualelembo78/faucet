<!doctype html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Faucet - Mercoin</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/css/mdb.min.css" rel="stylesheet">
    </head>
    <body class="landing">
        <div id="page-wrapper">

            <!-- Header -->
            <header id="header" class="alt">
                <h1><a href="{{ url('/home') }}">Mevacoin</a></h1>
                <nav id="nav">
                    <div class="flex-center position-ref full-height">
                        @if (Route::has('login'))
                            <div class="top-right links">
                                @auth
                                    <a href="{{ url('/home') }}" class="button special">Home</a>
                                @else
                                    <a href="{{ route('login') }} " class="button special">Accedi</a>
                                    <a href="{{ route('register') }}" class="button">Registrati</a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </nav>
            </header>

            <!-- Banner -->
            <section id="banner">
                <h2>Faucet - Mevacoin</h2>
                <p>Ottieni 0.5 MVC gratis ogni 2 ore e 2 MVC per ogni referral. Cosa aspetti a registrarti?</p>
                <ul class="actions">
                    <li><a href="{{ route('register') }}" class="button special">Registrati!</a></li>
                    <li><a href="https://mevacoin.it/" class="button">Informazioni su Mevacoin</a></li>
                </ul>
            </section>

            <!-- Main -->
            <section id="main" class="container">

                <section class="box special">
                    <header class="major">
                        <h2>Cos'è un Faucet Mevacoin?</h2>
<p>Un faucet è un modo semplice per ricevere gratuitamente piccole quantità di Mevacoin.<br />
Ogni utente può richiedere un premio a intervalli regolari, per iniziare a conoscere la criptovaluta e testare il sistema senza rischi.<br />
È pensato per chi vuole esplorare il mondo di Mevacoin in modo facile, veloce e gratuito.<br />
Richiedi subito il tuo premio e inizia il tuo viaggio!</p>

                        <div class="container">
                            <div class="row">
                                <div class="col-sm"><div id="SC_TBlock_545499" class="SC_TBlock">caricamento...</div></div>
                                <div class="col-sm"><div id="SC_TBlock_545503" class="SC_TBlock">caricamento...</div></div>
                                <div class="col-sm"><div id="SC_TBlock_545504" class="SC_TBlock">caricamento...</div></div>
                            </div>
                        </div>
                    </header>
                    <span class="image featured"><img src="images/pic01.jpg" alt="" /></span>
                </section>

                <section class="box special features">
    <div class="features-row">
        <section>
            <span class="icon major fa-gift accent2"></span>
            <h3>Ricompense Gratuite</h3>
            <p>Ricevi Mevacoin senza costi: è veloce, semplice e perfetto per iniziare nel mondo crypto.</p>
            <div id="SC_TBlock_545508" class="SC_TBlock">caricamento...</div>
        </section>
        <section>
            <span class="icon major fa-chart-line accent3"></span>
            <h3>Andamento in Tempo Reale</h3>
            <p>Controlla saldo, richieste e cronologia direttamente dal sito. Tutto trasparente, tutto sotto controllo.</p>
            <div id="SC_TBlock_545509" class="SC_TBlock">caricamento...</div>
        </section>
    </div>
    <div class="features-row">
        <section>
            <span class="icon major fa-globe accent4"></span>
            <h3>Accessibile da Ovunque</h3>
            <p>Funziona su qualsiasi dispositivo. Basta un browser per accedere al faucet Mevacoin.</p>
            <div id="SC_TBlock_545511" class="SC_TBlock">caricamento...</div>
        </section>
        <section>
            <span class="icon major fa-shield-alt accent5"></span>
            <h3>Tutto in Sicurezza</h3>
            <p>Connessione sicura, dati protetti e transazioni criptate. Il tuo Mevacoin è al sicuro.</p>
            <div id="SC_TBlock_545512" class="SC_TBlock">caricamento...</div>
        </section>
    </div>
</section>


            <!-- Footer -->
            <footer id="footer">
                <ul class="icons">
                    <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                    <li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
                    <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
                    <li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
                </ul>
                <ul class="copyright">
                    <li><a href="https://axolot.me/"><img src="https://i.imgur.com/nGxet6T.png" alt="axolot" height="100" width="100"></a></li>
                </ul>
            </footer>

        </div>

        <!-- Script di Annunci -->
        <script type="text/javascript" src="//st-n.tckn-code.com/js/a.js"></script>

        <!-- Script extra -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.dropotron.min.js"></script>
        <script src="assets/js/jquery.scrollgress.min.js"></script>
        <script src="assets/js/skel.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.4/js/mdb.min.js"></script>
    </body>
</html>