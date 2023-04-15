<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Lucianolima00\GridView\DataProviders\EloquentDataProvider;

class CollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $dataProvider = new EloquentDataProvider(Collaborator::query());

        return view('collaborators.index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $collaborator = new Collaborator();

        return view('collaborators.create', [
            'collaborator' => $collaborator
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'cpf_cnpj' => 'required',
            'type' => 'required',
        ]);

        $collaborator = new Collaborator($request->all());
        $collaborator->cpf_cnpj = preg_replace('/[.\/-]/', '', $collaborator->cpf_cnpj);
        $collaborator->save();

        return redirect()->route('collaborators.index')
            ->with('success', 'Colaborador cadastrado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Collaborator $collaborator
     * @return View
     */
    public function edit(Collaborator $collaborator): View
    {
        return view('collaborators.update', [
            'collaborator' => $collaborator
        ]);
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Collaborator $collaborator
     * @return RedirectResponse
     */
    public function update(Request $request, Collaborator $collaborator): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'cpf_cnpj' => 'required',
            'type' => 'required',
        ]);

        $collaborator->name = $request->input('name');
        $collaborator->cpf_cnpj = preg_replace('/[.\/-]/', '', $request->input('cpf_cnpj'));
        $collaborator->save();

        return redirect()->route('collaborators.index')
            ->with('success', 'Colaborador atualizado com sucesso');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param Collaborator $collaborator
     * @return RedirectResponse
     */
    public function destroy(Collaborator $collaborator): RedirectResponse
    {
        $collaborator->delete();

        return redirect()->route('collaborators.index')
            ->with('success', 'Colaborador excluído com sucesso');
    }
}
