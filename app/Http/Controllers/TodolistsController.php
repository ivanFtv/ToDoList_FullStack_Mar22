<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todolist::where('user_id', Auth()->user()->id)->orderBy('expiring_date')->get();
        return view('todos.index')->with('todos', $todos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $request->validate([
        'title' => ['required', 'min:4', 'max:15'],
        'description' => ['required', 'min:10'],
        'expiring_date' => ['required'],
        'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2048']
       ]);

       $file_name = '';
       if($request->hasFile('image')) {
        $file_name = date('Y-m-d').'-'.$request->file('image')->getClientOriginalName();
        $request->image->move(public_path('todo_images'), $file_name);
       }

       Todolist::create([
        'user_id' => Auth()->user()->id,
        'title' => $request->title,
        'description' => $request->description,
        'expiring_date' => $request->expiring_date,
        'image' => $file_name
       ]);

       return redirect()->back()->with('success', 'Todo salvato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todolist::findOrFail($id);
        
        return view('todos.edit')->with('todo', $todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todolist::findOrFail($id);

        if ($request->isMethod('PUT')) {
            $request->validate([
                'title' => ['required', 'min:4', 'max:15'],
                'description' => ['required', 'min:10'],
                'expiring_date' => ['required'],
                'image' => ['nullable', 'mimes:jpeg,png,jpg', 'max:2048']
            ]);
            
            $file_name = $todo->image;
            if($request->hasFile('image')) {
                $file_name = date('Y-m-d').'-'.$request->file('image')->getClientOriginalName();
                $request->image->move(public_path('todo_images'), $file_name);
            }
            $todo->update([
                // 'user_id' => Auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'expiring_date' => $request->expiring_date,
                'image' => $file_name
            ]);
        } else {
            $todo->update($request->All());
        }

        return redirect()->route('todos.index')->with('success', 'Todo aggiornato con successo');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todolist::findOrFail($id);
        $todo->delete();

        return redirect()->back()->with('success', 'Todo cancellato con successo!');
    }

    public function completeTodo($id) {
        $todo = Todolist::findOrFail($id);
        $todo->update(['completed' => '1']);

        return redirect()->back()->with('success', 'Todo completato!');
    }
}
