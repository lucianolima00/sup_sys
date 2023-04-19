<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Lucianolima00\GridView\DataProviders\EloquentDataProvider;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $dataProvider = new EloquentDataProvider(User::query());
        return view('users.index', [
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
        $user = new User();

        return view('users.create', [
            'user' => $user
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
        $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'email.required'=> 'Email é obrigatório',
                'email.email'=> 'Formato inválido para o email',
                'password.required'=> 'Senha é obrigatório',
            ]);

        $request->request->add(['password' => Hash::make( $request->input('password'))]);

        $user = new User($request->all());
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('users.update', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate(
        [
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'email.required'=> 'Email é obrigatório',
            'email.email'=> 'Formato inválido para o email',
            'password.required'=> 'Senha é obrigatório',
        ]);

        $request->request->add(['password' => Hash::make( $request->input('password'))]);
        $request->request->remove("_token");

        $user->update($request->all());

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso');
    }

}
