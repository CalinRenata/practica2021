<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = Auth::user();

        $boards = Board::query();

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        //Suntem in tabela de board_users
                        $query->where('user_id', $user->id);
                    });
            });
        }


        $nrboards = $boards->count();

        $boards = $boards->first();

        $tasks= $boards->tasks()->count();

        $nruser=User::where('role',User::ROLE_USER)->count();
        $nradmin=User::where('role',User::ROLE_ADMIN)->count();

        return view(
            'dashboard.index',
            [
                'nrboards' => $nrboards,
                'tasks' =>$tasks,
                'nruser'=>$nruser,
                'nradmin'=>$nradmin
            ]
        );
    }
}
