@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid mt-5 custom-container">
        <div class="card custom-card mb-4">
            <div class="card-header">
                <h6 class="mb-0">{{ $task->name }}</h6>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $task->description }}</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ __('tasks.priority') }}: {{ $task->priority->label() }}</li>
                    <li class="list-group-item">{{ __('tasks.status') }}: {{ $task->status->label() }}</li>
                    <li class="list-group-item">{{ __('tasks.due_date') }}: {{ $task->due_date->format('Y-m-d H:i') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
