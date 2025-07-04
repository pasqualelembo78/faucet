<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Dove reindirizzare dopo la registrazione.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Costruttore del controller.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validazione dei dati in input per la registrazione.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address'  => 'required|string|max:255',
        ]);
    }

    /**
     * Creazione dell'utente dopo la validazione.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'address'  => $data['address'],
            'code'     => Str::random(10),
            'referido' => Str::random(10),
            'active'   => 1, // ✅ Utente attivo subito
        ]);
    }
}