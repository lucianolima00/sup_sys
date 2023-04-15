<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Support;
use Illuminate\Support\Arr;
use App\Models\Collaborator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Lucianolima00\GridView\DataProviders\EloquentDataProvider;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $dataProvider = new EloquentDataProvider(Support::query());
        return view('supports.index', [
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
        $support = new Support();

        return view('supports.create', [
            'support' => $support
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

        $support = new Support($request->all());
        $support->cpf_cnpj = $support->cpf_cnpj ? preg_replace('/[.\/-]/', '', $support->cpf_cnpj) : $support->cpf_cnpj;
        $support->save();

        return redirect()->route('supports.index')
            ->with('success', 'Chamado cadastrado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Support $support): View
    {
        return view('supports.update', [
            'supports' => $support
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Support $support
     * @return RedirectResponse
     */
    public function update(Request $request, Support $support): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        //Another approach to fill the model is try remove _token from input field and load all to the model

        $support->opening_date = $request->input('opening_date');
        $support->status = $request->input('status');
        $support->primary_collaborator_id = $request->input('primary_collaborator_id');;
        $support->secondary_collaborator_id = $request->input('secondary_collaborator_id');
        $support->start_datetime = $request->input('start_datetime');
        $support->client_id = $request->input('client_id');
        $support->address = $request->input('address');
        $support->requester_id = $request->input('requester_id');
        $support->description = $request->input('description');
        $support->solution = $request->input('solution');

        $support->save();

        return redirect()->route('supports.index')
            ->with('success', 'Chamado atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     * @param Support $support
     * @return RedirectResponse
     */
    public function destroy(Support $support): RedirectResponse
    {
        $support->delete();

        return redirect()->route('supports.index')
            ->with('success', 'Chamado excluído com sucesso');
    }

    /**
     * @param $search
     * @return \Illuminate\Http\JsonResponse
     */
    public function collaborators(Request $request) {
        $data = [];

        if ($request->search) {
            $items = Collaborator::orderby("name", "asc")
                ->select('id', 'name')
                ->where('name', 'like', '%' . $request->search . '%')
                ->where('type', $request->type);

            if ($request->used_id) {
                $items = $items->where('id', '<>', $request->used_id);
            }

            $items = $items->get();

            foreach ($items as $item) {
                $data[] = [
                    'id' => $item->id, 'text' => $item->name
                ];
            }
        }

        return response()->json($data);

    }


    /**
     * @param $search
     * @return \Illuminate\Http\JsonResponse
     */
    public function clients(Request $request) {
        $data = [];

        if ($request->search) {
            $items = Client::orderby("name","asc")
                ->select('id','name')
                ->where('name', 'like', '%' . $request->search . '%')
                ->get();

            foreach ($items as $item) {
                $data[] = [
                    'id' => $item->id, 'text' => $item->name
                ];
            }
        }

        return response()->json($data);

    }
}
