<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth('api')->user();

        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);

        if ($page == 1 && $limit == 10) {
            $tasks = Task::where('user_id', $user->id)->get();
        } else {
            $tasks = Task::where('user_id', $user->id)
                ->paginate($limit, ['*'], 'page', $page);
        }

        return response()->json([
            'success' => true,
            'tasks' => $tasks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create([
            'user_id' => $user->id,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);
        return response()->json([
            'success' => true,
            'task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth('api')->user();
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        if ($task->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'forbidden'
            ], 403);
        }
        return response()->json([
            'success' => true,
            'task' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = auth('api')->user();
        $task = Task::find($id);


        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }


        if ($task->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'task' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = auth('api')->user();
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        if ($task->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403);
        }

        $task->delete();
        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ], 200);

    }
}
