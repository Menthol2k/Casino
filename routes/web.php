<?php

use App\Models\User;
use Inertia\Inertia;
use App\Models\Score;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {

        $user = User::with('scores')->get();

        $finalResults = [];
        
        foreach ($user as $player) {
            $winCount = $player->scores->where('win', true)->count();
            $finalResults[] = [
                'player_name' => $player->name,
                'win_count' => $winCount,
            ];
        }
        
        usort($finalResults, function ($a, $b) {
            return $b['win_count'] - $a['win_count'];
        });

        $current_balance = User::get();

        dd($current_balance);

        return Inertia::render('Dashboard', [
            'score' => $finalResults,
            'balance' => $current_balance->balance,
        ]);
    })->name('dashboard');
});

Route::post('/score/{win}', function ($win) {

    $user = auth()->user();

    if ($win == '1') {
        Score::create([
            'user_id' => $user->id,
            'win' => true,
        ]);
    } else {
        Score::create([
            'user_id' => $user->id,
            'win' => false,
        ]);
    }
});
