<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index_login() {
        return view('user.login');
    }

    public function index_register() {
        return view('user.register');
    }

    public function login(Request $request) {
        $dados = $request->all();
        $login = $this->user->login($dados);
        if(!$login) {
            return back()
                    ->withInput()
                    ->withErrors([
                        'As credenciais fornecidas não correspondem aos nossos registros.'
                    ]);
        }
        return redirect()->intended(route('user.index'));
    }

    public function logout() {
        $this->user->logout();
        return redirect()->route('user.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return view('user.index');
        }
        
        return redirect()->route('view.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        
        $inserir = $this->user->inserir($dados);
        if($inserir['status']) {
            return redirect()->route('welcome');
        }
        return redirect()
                ->back()
                ->withErrors($inserir['message']);
    }

    public function equacao(Request $request)
    {
        $dados = $request->all();

        $equacao = $this->user->equacao($dados);
    }

    public function financeiro(Request $request){
        $dados = $request->all();

        $inserir = $this->user->consultar($dados);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function pagseguro(){
        return view('pagseguro');
    }

    public function plano(){
        $response = Http::withOptions(['verify' => false])
                        ->withHeaders([
            'Accept' => 'application/vnd.pagseguro.com.br.v3+xml;charset=ISO-8859-1',
            'Content-Type' => 'application/json'
        ])->post(
            'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/request/?email=herbertbiscaia@gmail.com&token=9B579D341A10410C9CFF27E1ACFD1C94', 
            [
                'reference' => 'referencia-livewire-3',
                'preApproval' => [
                    'name' => 'Plano Mensal',
                    'charge' => 'AUTO',
                    'period' => 'MONTHLY',
                    'amountPerPeriod' => '39.99',
                    'amountPerPayment' => '39.99',

                ]
            ]
        );
        dd($response->json());
    }

    public function boleto(){
        $base64Credentials = base64_encode(auth()->user()->nome . ':' . auth()->user()->password);

        $data = [
            //'email' => 'herbertbiscaia@gmail.com',
            //'token' => '9B579D341A10410C9CFF27E1ACFD1C94',
            'document: value' => '33776491744',
            'reference' => 'boleto-1',
            'firstDueDate' => '2023-10-30',
            'numberOfPayments' => 1,
            'periodicity' => 'monthly',
            'amount' => '15.69',
            'description' => 'Assinatura de Sorvete',
            'document: type' => 'CPF',
            'name' => 'Alini QA',
            'instructions' => 'juros de 1% ao dia e mora de 5,00',
            'phone: areaCode' => '11',
            'phone: number' => '80804040',
            'email' => 'compradoralini@xpto.com.br',
            'address: postalCode' => '01046010',
            'address: street' => 'Av. Ipiranga',
            'address: number' => '100',
            'address: district' => 'Republica',
            'address: state' => 'SP',
            'address: city' => 'Sao Paulo',
        ];

        $response = Http::withOptions(['verify' => false])
                        ->withHeaders([
            'Accept' => 'application/json;charset=ISO-8859-1',
            'Content-Type' => 'application/json;charset=ISO-8859-1',
            'Authorization' => 'Basic ' . $base64Credentials
        ])->post(
            'https://ws.sandbox.pagseguro.uol.com.br/recurring-payment/boletos?email=herbertbiscaia@gmail.com&token=9B579D341A10410C9CFF27E1ACFD1C94', 
            $data
        );
        dd($response->status());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cotacao(){
        $moeda = null;

        return view('cotacoes',
                    compact('moeda'));
    }

    // https://economia.awesomeapi.com.br/last/{moeda}-BRL

    public function pesquisa_cotacao(Request $request){
        $dados = $request->all();

        $pesquisa = Http::withOptions(['verify' => false])
                            ->get("https://economia.awesomeapi.com.br/last/{$dados['moeda']}-BRL");
        $moeda = $pesquisa->json()['USDBRL']['bid'];

        return view('cotacoes',
                    compact('moeda'));
    }
}
