<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Lucianolima00\GridView\DataProviders\EloquentDataProvider;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $dataProvider = new EloquentDataProvider(Client::query());
        return view('clients.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $client = new Client();

        return view('clients.create', [
            'client' => $client
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $client = new Client($request->all());
        $client->cpf_cnpj = $client->cpf_cnpj ? preg_replace('/[.\/-]/', '', $client->cpf_cnpj) : $client->cpf_cnpj;
        $client->save();

        return redirect()->route('clients.index')
            ->with('success', 'Cliente cadastrado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): View
    {
        return view('clients.update', [
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Client $client
     * @return RedirectResponse
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        //Another approach to fill the model is try remove _token from input field and load all to the model

        $client->name = $request->input('name');
        $client->company_name = $request->input('company_name');
        $client->cpf_cnpj = $client->cpf_cnpj ? preg_replace('/[.\/-]/', '', $request->input('cpf_cnpj')) : $client->cpf_cnpj;
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->address_public_place = $request->input('address_public_place');
        $client->address_number = $request->input('address_number');
        $client->address_complement = $request->input('address_complement');
        $client->address_zip_code = $request->input('address_zip_code');
        $client->address_neighborhood = $request->input('address_neighborhood');
        $client->address_city = $request->input('address_city');
        $client->address_state = $request->input('address_state');

        $client->save();

        return redirect()->route('clients.index')
            ->with('success', 'Cliente atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     * @param Client $client
     * @return RedirectResponse
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Cliente excluído com sucesso');
    }
}
