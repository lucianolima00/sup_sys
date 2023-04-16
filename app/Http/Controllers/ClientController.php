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

        $request->request->add(['cpf_cnpj' => preg_replace('/[.\/-]/', '', $request->input('cpf_cnpj'))]);
        $request->request->add(['phone' => preg_replace('/[ .()\/-]/', '', $request->input('phone'))]);
        $request->request->add(['address_zip_code' => preg_replace('/[.\/-]/', '', $request->input('address_zip_code'))]);
        $client = new Client($request->all());
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

        $request->request->remove("_token");
        $request->request->add(['cpf_cnpj' => preg_replace('/[.\/-]/', '', $request->input('cpf_cnpj'))]);
        $request->request->add(['phone' => preg_replace('/[ .()\/-]/', '', $request->input('phone'))]);
        $request->request->add(['address_zip_code' => preg_replace('/[.\/-]/', '', $request->input('address_zip_code'))]);

        $client->update($request->all());

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
