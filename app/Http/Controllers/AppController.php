<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Itstructure\GridView\DataProviders\EloquentDataProvider;

class AppController extends Controller
{
    public function dashboard(Request $request): View
    {
        $dataProvider = new EloquentDataProvider(Client::query());
        return view('dashboard', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
