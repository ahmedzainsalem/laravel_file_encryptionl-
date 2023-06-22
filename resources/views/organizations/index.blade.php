@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Organizations</h1>
        <a href="{{ route('organizations.create') }}" class="btn btn-primary">Create Organization</a>
        <br><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($organizations as $organization)
                    <tr>
                        <td>{{ $organization->name }}</td>
                        <td>{{ $organization->public_key }}</td>
                        <td>{{ $organization->private_key }}</td>
                        <td>
                            <a href="{{ route('organizations.show', $organization->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('organizations.edit', $organization->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection