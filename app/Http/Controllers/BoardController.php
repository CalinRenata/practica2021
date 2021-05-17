<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function boards()
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::with(['user', 'boardUsers']);

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
        $boards = $boards->paginate(10);

        return view(
            'boards.index',
            [
                'boards' => $boards
            ]
        );
    }

    public function updateBoard(Request $request, $id): JsonResponse
    {
        $board = Board::find($id);

        $error = '';
        $success = '';

        if ($board) {
            $name = $request->get('name');
            $user = $request->get('user');

            /* if () {
                 $board->name = $name;
                 $board->user=$user;
                 $board->save();
                 $board->refresh();

                 $success = 'Board saved';
             } else {
                 $error = 'Board name or User selected is not valid!';
             }
         } else {
             $error = 'Board not found!';
            */
        }

        return response()->json(['error' => $error, 'success' => $success, 'user' => $board]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteBoard(Request $request, $id): JsonResponse
    {
        $board = Board::find($id);

        $error = '';
        $success = '';

        if ($board) {
            $board->delete();

            $success = 'Board deleted';
        } else {
            $error = 'Board not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function board($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::query();

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $board = clone $boards;
        $board = $board->where('id', $id)->first();

        $boards = $boards->select('id', 'name')->get();

        if (!$board) {
            return redirect()->route('boards.all');
        }

        $tasks = Task::with(['user', 'board']);

        $tasks = $tasks->where(function ($query) use ($board) {
            //Suntem in tabele de tasks in continuare
            $query->where('board_id', $board->id)
                ->orWhereHas('board', function ($query) use ($board) {
                    //Suntem in tabela de boards
                    $query->where('board_id', $board->id);
                });
        });

        $tasks = $tasks->oldest()->paginate(10);
        return view(
            'boards.view',
            [
                'board' => $board,
                'boards' => $boards,
                'tasks' => $tasks
            ]
        );
    }

    public function updateTask(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);

        $error = '';
        $success = '';

        if ($task) {
            $name = $request->get('name');
            $description = $request->get('description');
            $assignment = $request->get('assignment');
            $status = $request->get('status');
            $create_date = $request->get('created_at');

            /*if () {
                $task->name = $name;
                $task->description=$description;
                $task->assignment=$assignment;
                $task->status=$status;
                $task->created_at=$create_date;
                $task->save();
                $task->refresh();

                $success = 'Task saved';
            } else {
                $error = 'Task selected is not valid!';
            }
        } else {
            $error = 'Task not found!';
            */
        }


        return response()->json(['error' => $error, 'success' => $success, 'user' => $task]);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteTask(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);

        $error = '';
        $success = '';

        if ($task) {
            $task->delete();

            $success = 'Task deleted';
        } else {
            $error = 'Task not found!';
        }

        return response()->json(['error' => $error, 'success' => $success]);
    }
}
