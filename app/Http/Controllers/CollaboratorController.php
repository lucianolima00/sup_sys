<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class CollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $collaborators = new EloquentDataProvider(Collaborator::query());

        return view('collaborator.index', compact('collaborators'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('collaborator.create');
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
            'description' => 'required',
            'price' => 'required'
        ]);

        $collaborator = new Collaborator($request->all());
        $collaborator->save();

        return redirect()->route('collaborator.index')
            ->with('success', 'Collaborator created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Collaborator $collaborator
     * @return View
     */
    public function show(Collaborator $collaborator): View
    {
        return view('collaborator.show', compact('collaborator'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Collaborator $collaborator
     * @return View
     */
    public function edit(Collaborator $collaborator): View
    {
        return view('collaborator.edit', compact('collaborator'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Collaborator $collaborator
     * @return RedirectResponse
     */
    public function update(Request $request, Collaborator $collaborator): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);
        $collaborator->update($request->all());

        return redirect()->route('collaborator.index')
            ->with('success', 'Collaborator updated successfully');
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

        return redirect()->route('collaborator.index')
            ->with('success', 'Collaborator deleted successfully');
    }
}
