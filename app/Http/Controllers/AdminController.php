<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class AdminController
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    public function users()
    {
        $users = DB::table('users')->paginate(10);

        return view(
            'users.index',
            [
                'users' => $users
            ]
        );
    }

    public function update(Request $request, $id)
    {
        DB::table('users')->updateOrCreate(
            [
                'id' => $id
            ],
            [
                'role' => $request->role,
            ]
        );

        return response()->json(['success' => true]);

    }

    public function destroy($id)
    {

        $user = User::find()->where('id', $id)->first();
        $user->delete();
        return response()->json([
            'message' => 'Data deleted successfully!'
        ]);

    }
}
