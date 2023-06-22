@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Organization</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('organizations.update', $organization->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $organization->name }}">
            </div>
            <div class="form-group">
                <label for="name">public key:</label>
                <input type="text" name="public_key" id="public_key" class="form-control" value="{{ $organization->public_key }}">
            </div>
            <div class="form-group">
                <label for="name">private key:</label>
                <input type="text" name="private_key" id="private_key" class="form-control" value="{{ $organization->private_key }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection