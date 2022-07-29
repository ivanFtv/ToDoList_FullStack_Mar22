

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                    <form method="POST" action="{{ route('todos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="container p-4">

                            {{-- Gestione messaggio successo --}}
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ $message }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Titolo</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="title">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Descrizione</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                            </div>
                            <div class="mb-3 d-flex justify-content-around">
                                <div>
                                    <label for="expired-date" class="form-label">Scadenza</label>
                                    <input type="date" name="expiring_date" id="expired-date">
                                </div>
                                <div>
                                    <label for="expired-date" class="form-label">Immagine</label>
                                    <input type="file" name="image" id="image">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-4">Salva nuovo TODO</button>

                            {{-- Gestione errori --}}
                            @if ($message = Session::get('errors'))
                            <div class="alert alert-danger mt-4" role="alert">
                                @foreach ($errors->all() as $error)
                                {{ $error }} <br />
                                @endforeach
                            </div>
                            @endif

                        </div>
                    </form>
                <div class="card-body">
                    <hr>
                    <h3 class="mt-5 mb-1">Lista Todos</h3>
                </div>
                <div class="container d-flex justify-content-center flex-column">
                    @foreach ($todos as $todo)
                        <div class="card my-2 {{ $todo->completed == 0 ?  "bg-light" : "alert alert-danger"}} " style="width: 100%">
                            <div class="card-body">
                            <h5 class="card-title mb-0"><u>{{ strtoupper($todo->title) }}</u></h5>
                            <small>Scadenza: {{ $todo->getHumanDateAttribute() }}</small>
                            <p class="card-text mt-3">{{ $todo->description }}</p>
                            @if ($todo->image != '')
                                <img src="todo_images/{{ $todo->image }}" class="card-img-top mb-3" alt="...">
                            @endif
                            @if ($todo->completed == 0)
                            <div class="d-flex justify-content-end">
                                <form method="POST" action="{{ route('todos.complete', $todo) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success mx-1">Complete</button>
                                </form>
                                <form method="POST" action="{{ route('todos.destroy', $todo) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mx-1">Delete</button>
                                </form>
                            <a href="{{ route('todos.edit', $todo) }}" class="btn btn-warning mx-1">Edit</a>
                            <form method="POST" action="{{ route('todos.update', $todo) }}">
                                @csrf
                                @method('PATCH')
                                <input type="string" name="expiring_date" value="{{ \Carbon\Carbon::parse($todo->expiring_date)->addDay() }}" hidden>
                                <button type="submit" class="btn btn-primary mx-1">Ritarda di 1 giorno</button>
                            </form>
                            </div>
                            @endif
                            </div>
                        </div>
                    @endforeach
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
