@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form action="{{ route('uploadFile') }}" method="post" enctype="multipart/form-data" class="my-4">
                        @csrf

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="userFile" name="userFile">
                                <label class="custom-file-label" for="userFile">Choose a file</label>
                            </div>
                            
                        </div>
                        <div class="form-group">
                                <select name="organization_id" class="form-control">
                                    <option value="">Select Organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        <button type="submit" class="btn btn-primary">Upload</button>

                        @if (session()->has('message'))
                            <div class="alert alert-success mt-3">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if (session()->has('faildmessage'))
                            <div class="alert alert-danger mt-3">
                                {{ session('faildmessage') }}
                            </div>
                        @endif

                    </form>

                    <ul class="list-group">
                    @php
    $counter = 1;
@endphp
                        @forelse ($files as $file)
                            <!-- <li class="list-group-item">
                                <a href="{{ route('downloadFile', basename($file)) }}">
                                    {{ basename($file) }}
                                </a>
                            </li> -->
                            <li class="list-group-item">
                                <a href="#" data-toggle="modal" data-target="#publicKeyModal{{ $counter }}">
                                    {{ basename($file) }}
                                </a>
                            </li>

                            <!-- Public Key Modal -->
                            <div class="modal fade" id="publicKeyModal{{ $counter }}" tabindex="-1" role="dialog" aria-labelledby="publicKeyModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="publicKeyModalLabel">Enter Public Key</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('downloadFile') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="filename" value="{{ basename($file) }}" > 
                                                <div class="form-group">
                                                    <label for="public_key">Public Key</label>
                                                    <input type="text" class="form-control" id="public_key" name="public_key" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Download</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
    $counter++;
@endphp
                        @empty
                            <li class="list-group-item">You have no files</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
