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
                <h1><a href="{{ url('/home') }}">Mercoin</a></h1>
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
                <h2>Faucet - Mercoin</h2>
                <p>Ottieni 0.5 MRN gratis ogni 2 ore e 2 MRN per ogni referral. Cosa aspetti a registrarti?</p>
                <ul class="actions">
                    <li><a href="{{ route('register') }}" class="button special">Registrati!</a></li>
                    <li><a href="https://mercoin.org/" class="button">Informazioni su Mercoin</a></li>
                </ul>
            </section>

            <!-- Main -->
            <section id="main" class="container">

                <section class="box special">
                    <header class="major">
                        <h2>Servizio Professionale<br />
                        Design e Sviluppo di Faucet</h2>
                        <p>Offriamo servizi di progettazione e sviluppo di faucet su Mercoin o su altre criptovalute.<br />
                        Perché creare una faucet? <br/>
                        Puoi monetizzarla con pubblicità o usarla per attirare traffico verso un sito web, un gruppo Telegram, ecc.<br />
                        Una faucet porta molto traffico e nuovi utenti per i tuoi progetti. Per maggiori informazioni, contattaci!</p>
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
                            <span class="icon major fa-bolt accent2"></span>
                            <h3>Alta Performance</h3>
                            <p>Sistema ottimizzato per massime prestazioni e affidabilità.</p>
                            <div id="SC_TBlock_545508" class="SC_TBlock">caricamento...</div>
                        </section>
                        <section>
                            <span class="icon major fa-area-chart accent3"></span>
                            <h3>Statistiche Dettagliate</h3>
                            <p>Monitora il tuo traffico e i guadagni in tempo reale con report chiari.</p>
                            <div id="SC_TBlock_545509" class="SC_TBlock">caricamento...</div>
                        </section>
                    </div>
                    <div class="features-row">
                        <section>
                            <span class="icon major fa-cloud accent4"></span>
                            <h3>Cloud Ready</h3>
                            <p>Il nostro sistema è pronto per essere distribuito in ambienti cloud scalabili.</p>
                            <div id="SC_TBlock_545511" class="SC_TBlock">caricamento...</div>
                        </section>
                        <section>
                            <span class="icon major fa-lock accent5"></span>
                            <h3>Sicurezza Avanzata</h3>
                            <p>Protezione avanzata dei dati con i migliori standard di sicurezza.</p>
                            <div id="SC_TBlock_545512" class="SC_TBlock">caricamento...</div>
                        </section>
                    </div>
                </section>

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