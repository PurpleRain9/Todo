<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];

            return response()->json($response);
        }

        $todo = new Todo();
        $todo->title = $request->get('title');
        $todo->description = $request->get('description');
        $todo->user_id = $request->get('user_id');
        $todo->save();

        return response()->json([
            'message' => 'Todo successfully created.'
        ]);
    }

    public function index(){
        $todo =  Todo::with(['user'])->latest()->get();

        return response()->json($todo);
    }


    public function delete(Request $request)
    {
        $todo = Todo::find($request->get('id'));
        $todo->delete();

        return response()->json([
            'todo' => $todo,
            'message' => 'Todo successfully deleted.'
        ]);
    }


    public function maskAs(Request $request){
        $todo = Todo::find($request->get('id'));
        $todo->done = true;
        $todo->update();

        return response()->json([
            'todo' => $todo,
            'message' => 'Todo successfully marked as done'
        ]);

    }


    public function maskDown(Request $request){
        $todo = Todo::find($request->get('id'));
        $todo->done = false;
        $todo->update();

        return response()->json([
            'todo' => $todo,
            'message' => 'Todo successfully marked as undone'
        ]);
    }
}
