@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Organization</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('organizations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="public_key">Public Key:</label>
                <input type="text" name="public_key" id="public_key" class="form-control" >
            </div>
            <div class="form-group">
                <label for="private_key">Private Key:</label>
                <input type="text" name="private_key" id="private_key" class="form-control" >
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection