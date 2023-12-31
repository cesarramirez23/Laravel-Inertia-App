<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('login', [LoginController::class, 'create']) ->name('login');
Route::post('login', [LoginController::class, 'store']) ->name('login');
Route::post('logout', [LoginController::class, 'destroy'])->middleware('auth') ;

Route::middleware('auth')-> group( function(){
    Route::get('/', function () {
        return Inertia::render('Welcome',[
            'username' => 'Nombre usuario',
        ]);
    });

    Route::get('/users', function () {
        return Inertia::render('Users/Index',[
            'users' => User::query()
                ->when(Request::input('search'), function($query,$search){
                    $query->where('name', 'like', "%{$search}%");
                })
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) =>[
                    'id' => $user->id,
                    'name' => $user->name,
                ]),

                'filters' => Request::only(['search']),
                'can' =>[
                    'createUser' => true//validate admin profile
                ]
        ]);
    });


    Route::get('/users/create', function () {
        return Inertia::render('Users/Create',[
            
        ]);
    });

    Route::post('/users', function () {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($attributes);

        return redirect('/users');
    });


    Route::get('/settings', function () {
        return Inertia::render('Settings',[]);
    });
});