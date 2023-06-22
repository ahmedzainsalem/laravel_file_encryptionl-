@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Organization Details</h1>
        <table class="table table-bordered">
            <tr>
                <th>Name:</th>
                <td>{{ $organization->name }}</td>
            </tr>
            <tr>
                <th>public key:</th>
                <td>{{ $organization->public_key }}</td>
            </tr>
            <tr>
                <th>private key:</th>
                <td>{{ $organization->private_key }}</td>
            </tr>
        </table>
        <a href="{{ route('organizations.edit', $organization->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection