<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\User;
use App\Wallet;

class HomeController extends Controller
{
    public function __construct() {}

    private function callRpc($method, $params = [])
    {
        $payload = json_encode([
            'jsonrpc' => '2.0',
            'id' => '1',
            'method' => $method,
            'params' => (object) $params,
        ]);

        $ch = curl_init('http://127.0.0.1:17082/json_rpc');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) return null;

        $decoded = json_decode($response, true);
        return $decoded['result'] ?? null;
    }

    private function getFaucetBalance()
    {
        $address = 'bickdGgqeVAWAKjbGCZoMfd2Ea6181wkAR3UzbaMkFWSMMgvZuPWpbJ1eJAcYbeSxJKSk34C8zCGFfETW17B1YkU1T5TCnjHts';
        $result = $this->callRpc('getBalance', ['address' => $address]);
        return $result ? $result['availableBalance'] / 100000 : null;
    }

    private function getNodeStatus()
    {
        return $this->callRpc('getStatus');
    }

    private function getFeeInfo()
    {
        return $this->callRpc('nodeFeeInfo');
    }

    public function index()
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => Auth::id()],
            ['balance' => 0, 'last_retiro' => null]
        );

        $faucetBalance = $this->getFaucetBalance();
        $nodeStatus = $this->getNodeStatus();
        $feeInfo = $this->getFeeInfo();

        return view('home', compact('wallet', 'faucetBalance', 'nodeStatus', 'feeInfo'));
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|max:255',
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

        return redirect()->route('login')->with('status', 'Registrato con successo');
    }

    public function perfil()
    {
        $user = User::find(Auth::id());
        $wallet = Wallet::where('user_id', Auth::id())->first();
        return view('perfil', compact('user', 'wallet'));
    }

    public function perfilPost(Request $request)
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => Auth::id()],
            ['balance' => 0, 'last_retiro' => null]
        );
        $now = Carbon::now();

        if (is_null($wallet->last_retiro)) {
            $wallet->last_retiro = $now->subSeconds(10);
        }

        $action = $request->input('dato');

        if ($action === 'empezar') {
            $wallet->last_retiro = $now->addSeconds(5);
            $wallet->balance = 0.50;
            $wallet->save();
            return redirect('/home')->with('status', 'Hai iniziato a generare Mevacoin!');
        }

        if ($action === 'retirar') {
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

        return redirect('/home')->with('error', 'Azione non riconosciuta.');
    }

    public function referido($code)
    {
        $user = User::where('referido', $code)->first();
        return $user ? view('auth.referido', compact('user', 'code')) : redirect('/');
    }

    public function referidoPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|max:255',
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
        $wallet = Wallet::where('user_id', Auth::id())->first();

        if (!$wallet) {
            Log::error("Wallet non trovata per utente ID: " . Auth::id());
            return redirect()->route('perfil')->with('error', 'Wallet non trovata.');
        }

        $address = $wallet->user->address;
        $amount = $wallet->balance;

        if ($amount <= 0) {
            return redirect()->route('perfil')->with('error', 'Saldo insufficiente per il ritiro.');
        }

        $amountAtomic = intval($amount * 100000);
        $changeAddress = 'bickdGgqeVAWAKjbGCZoMfd2Ea6181wkAR3UzbaMkFWSMMgvZuPWpbJ1eJAcYbeSxJKSk34C8zCGFfETW17B1YkU1T5TCnjHts';

        $params = [
            'addresses' => [],
            'transfers' => [['address' => $address, 'amount' => $amountAtomic]],
            'fee' => 10000,
            'anonymity' => 0,
            'changeAddress' => $changeAddress,
        ];

        $response = $this->callRpc('sendTransaction', $params);

        if ($response) {
            $wallet->balance = 0.00;
            $wallet->save();
            return redirect()->route('perfil')->with('status', 'Hai ritirato con successo! Controlla il tuo wallet.');
        } else {
            return redirect()->route('perfil')->with('error', 'Errore durante il prelievo.');
        }
    }

    public function activar($code)
    {
        $user = User::find(Auth::id());

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
        $data = [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'code' => Auth::user()->code
        ];

        Mail::send('auth.mail', $data, function ($mensaje) use ($data) {
            $mensaje->to($data['email'], $data['name'])->subject('Conferma Mercoin');
        });

        return redirect()->route('verificar')->with('status', 'Messaggio inviato correttamente');
    }

    public function verificar()
    {
        return Auth::user()->active === 1
            ? view('auth.verificar')
            : redirect()->route('home');
    }

    public function editarPost(Request $request)
    {
        $user = User::find(Auth::id());
        $user->address = $request->get('address');
        $user->save();

        return redirect()->route('perfil')->with('status', 'Wallet cambiata con successo');
    }
}
