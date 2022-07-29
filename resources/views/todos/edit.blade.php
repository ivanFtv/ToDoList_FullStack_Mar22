

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifica TODO</div>
                <form method="POST" action="{{ route('todos.update', $todo) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="container p-4">

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Titolo</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="title" value="{{ $todo->title }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Descrizione</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description">{{ $todo->description }}</textarea>
                        </div>
                        <div class="mb-3 d-flex justify-content-around">
                            <div>
                                <label for="expired-date" class="form-label">Scadenza</label>
                                <input type="date" name="expiring_date" id="expired-date" value="{{ $todo->expiring_date }}">
                            </div>
                            <div>
                                <label for="expired-date" class="form-label">Immagine</label>
                                <input type="file" name="image" id="image">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Modifica TODO</button>

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
                
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
