<?php        

namespace App\Http\Controllers;        

use Illuminate\Http\Request;        
use Illuminate\Support\Facades\Auth;        
use Carbon\Carbon;        
use App\User;        
use App\Wallet;        
use Illuminate\Support\Facades\Mail;        

class HomeController extends Controller        
{        
    public function __construct()        
    {        
    }        

    // Funzione privata per ottenere il saldo del faucet dal wallet RPC

private function getFaucetBalance()
{
    $rpcUrl = 'http://127.0.0.1:17082/json_rpc';

    $postData = [
        'jsonrpc' => '2.0',
        'id' => '1',
        'method' => 'getStatus',
        'params' => (object)[]
    ];

    $ch = curl_init($rpcUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['result']['blockCount'])) {
        return $result['result']['blockCount'];
    }

    return null;
}

    public function index()        
    {        
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();        
        if (!isset($wallet)) {        
            $wallet = new Wallet();        
            $wallet->user_id = Auth::user()->id;        
            $wallet->save();        
        }

        $faucetBalance = $this->getFaucetBalance();

        return view('home', compact('wallet', 'faucetBalance'));        
    }        

    public function registrar(Request $request)        
    {        
        $request->validate([        
            'name' => 'required|string|max:255',        
            'email' => 'required|string|email|max:255|unique:users',        
            'password' => 'required|string|min:6|confirmed',        
            'address' => 'required|string|max:255'        
        ]);        

        $registrar = new User();        
        $registrar->refferal_id = $request->get('user');        
        $registrar->name = $request->get('name');        
        $registrar->email = $request->get('email');        
        $registrar->password = bcrypt($request->get('password'));        
        $registrar->address = $request->get('address');        
        $registrar->code = str()->random(10);        
        $registrar->referido = str()->random(10);        
        $registrar->active = 1;        
        $registrar->save();        

        return redirect()->route('login')->with('status', 'Registrado exitosamente');        
    }        

    public function perfil()        
    {        
        $user = User::find(Auth::user()->id);        
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();        
        return view('perfil', compact('user','wallet'));        
    }        

    public function perfilPost(Request $request)
{
    $wallet = Wallet::firstOrCreate(
        ['user_id' => Auth::id()],
        ['balance' => 0, 'last_retiro' => null]
    );
    $now = Carbon::now();

    // Se non è mai stato impostato last_retiro, lo consideriamo già scaduto
    if (is_null($wallet->last_retiro)) {
        $wallet->last_retiro = $now->subSeconds(10);
    }

    $action = $request->input('dato'); // 'empezar' o 'retirar'

    if ($action === 'empezar') {
        // Primo avvio: settiamo il timer e inizializziamo il saldo
        $wallet->last_retiro = $now->addSeconds(5);
        $wallet->balance = 0.50;
        $wallet->save();

        return redirect('/home')->with('status', 'Hai iniziato a generare Mercoin!');
    }

    if ($action === 'retirar') {
        // Verifichiamo se il tempo è scaduto
        if (Carbon::parse($wallet->last_retiro)->isPast()) {
            $wallet->last_retiro = $now->addSeconds(5);
            $wallet->balance += 0.50;
            $wallet->save();

            return redirect('/home')->with('status', 'Hai ricevuto 0.5 MRN! Puoi réclamarlo di nuovo tra 5 secondi.');
        } else {
            $diff = Carbon::parse($wallet->last_retiro)->diffForHumans();
            return redirect('/home')->with('error', "Devi aspettare ancora: $diff.");
        }
    }

    // Qualunque altra azione non valida
    return redirect('/home')->with('error', 'Azione non riconosciuta.');
}    public function referido($code)        
    {        
        $user = User::where('referido', $code)->first();        
        if ($user) {        
            return view('auth.referido', compact('user', 'code'));        
        }        
        return redirect('/');        
    }        

    public function referidoPost(Request $request)        
    {        
        $request->validate([        
            'name' => 'required|string|max:255',        
            'email' => 'required|string|email|max:255|unique:users',        
            'password' => 'required|string|min:6|confirmed',        
            'address' => 'required|string|max:255'        
        ]);        

        $registrar = new User();        
        $registrar->refferal_id = $request->get('user');        
        $registrar->name = $request->get('name');        
        $registrar->email = $request->get('email');        
        $registrar->password = bcrypt($request->get('password'));        
        $registrar->address = $request->get('address');        
        $registrar->code = str()->random(10);        
        $registrar->referido = str()->random(10);        
        $registrar->active = 1;        
        $registrar->save();        

        return redirect()->route('home');        
    }        

    public function retirarPost(Request $request)        
    {        
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();        
        $address = $wallet->user->address;        
        $balance = $wallet->balance;        

        if ($balance <= 0) {
            return redirect()->route('perfil')->with('error', 'Saldo insuficiente per il ritiro.');
        }

        $payload = json_encode([
            'jsonrpc' => '2.0',
            'id' => '1',
            'method' => 'sendTransaction',
            'params' => [
                'addresses' => [$address],
                'transfers' => [
                    [
                        'address' => $address,
                        'amount' => intval($balance * 100000000) // supponendo unità atomiche (adatta se serve)
                    ]
                ],
                'fee' => 100000,
                'anonymity' => 3
            ]
        ]);

        $ch = curl_init('http://127.0.0.1:17082/json_rpc');        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);        

        $response = curl_exec($ch);        
        curl_close($ch);        

        $wallet->balance = 0.00;        
        $wallet->save();        

        return redirect(route('perfil'))->with('status', 'Ya retiraste tu mercoin, puedes revisar en tu monedero.');        
    }        

    public function prueba()        
{        
    $payload = json_encode([
        'jsonrpc' => '2.0',
        'id' => '1',
        'method' => 'getStatus',
        'params' => (object)[] // oppure semplicemente []
    ]);

    $ch = curl_init('http://127.0.0.1:17082/json_rpc'); // <-- indirizzo RPC corretto
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // ritorna i dati, o visualizzali
    return response()->json($result);
}

    public function activar($code)        
    {        
        $user = User::find(Auth::user()->id);        

        if ($user->active === 2) {            
            return redirect()->route('home')->with('status', 'Ya tu usuario esta activo');        
        }        

        if ($user->code === $code) {        
            $user->active = 2;        
            $user->save();        

            if (!empty($user->refferal_id)) {        
                $set = Wallet::where('user_id', $user->refferal_id)->first();        
                $set->balance += 2.00;        
                $set->refferal += 1;        
                $set->save();        
            }        

            return redirect()->route('home');        
        }        

        return redirect()->route('verificar')->with('status', 'Codigo incorrecto');        
    }        

    public function reenviar()        
    {        
        $data['name'] = Auth::user()->name;        
        $data['email'] = Auth::user()->email;        
        $data['code'] = Auth::user()->code;        

        Mail::send('auth.mail', $data, function ($mensaje) use ($data) {        
            $mensaje->to($data['email'], $data['name'])->subject('Confirmacion Mercoin');        
        });        

        return redirect()->route('verificar')->with('status', 'Mensaje enviado satifactoriamente');        
    }        

    public function verificar()        
    {        
        if (Auth::user()->active === 1) {        
            return view('auth.verificar');        
        }        
        return redirect()->route('home');        
    }        

    public function editarPost(Request $request)        
    {        
        $user = User::find(Auth::user()->id);        
        $user->address = $request->get('address');        
        $user->save();        

        return redirect()->route('perfil')->with('status', 'Wallet cambiada Satifactoriamente');        
    }        
}
