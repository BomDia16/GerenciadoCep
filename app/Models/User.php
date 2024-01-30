<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    public function inserir($dados) {
        $cadastrar = $this->create([
            'nome'          => $dados['nome'],
            'email'         => $dados['email'],
            'password'         => bcrypt($dados['senha']),
        ]);

        if($cadastrar){
            return [
                'status' => true,
                'message' => 'Sucesso ao cadastrar o usuário!'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Falha ao cadastrar o usuário!',
            ];
        }
    }

    public function login($dados) {
        $credenciais = [
            'email' => $dados['email'],
            'password' => $dados['senha']
        ];
        return Auth::attempt($credenciais);
    }

    public function logout() {
        return Auth::logout();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function equacao($dados)
    {
        $a = $dados['a'];
        $b = $dados['b'];
        $c = $dados['c'];

        $delta = $b*$b-4*$a*$c;

        if($delta > 0){
            $multi = 2*$a;

            $x1 = -$b+sqrt($delta);
            $x1 = $x1/$multi;

            $x2 = -$b-sqrt($delta);
            $x2 = $x2/$multi;
        
            dd($x1, $x2);
        } elseif($delta == 0) {
            $multi = 2*$a;

            $x = -$b+sqrt($delta);
            $x = $x/$multi;

            dd($x);
        } else {
            dd('Delta < que 0, não tem como fazer o cálculo.');
        }
    }

    public function consultar($dados) {
        $response = Http::dd()->get(" https://www.google.com.br/");

        if ($response->ok()) {
            return dd($response);
        }

        return [
            'status'    => false,
            'message'   => 'Falha ao fazer a consulta',
        ];
    }
}
