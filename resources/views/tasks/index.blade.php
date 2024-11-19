@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid mt-5 custom-container">
        @include('inc.alerts')
        <a href="{{ route('tasks.create') }}">
            <button class="btn btn-primary mb-3">{{ __('tasks.add') }}</button>
        </a>
        @foreach($tasks as $task)
        <div class="card custom-card mb-4">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">{{ $task->name }}</h6>
                    <div class="d-flex align-items-center">
                        @can('update', $task)
                        <div class="buttons d-flex">
                            <a href="{{ route('tasks.edit', $task->id) }}">
                                <button class="btn btn-secondary">{{ __('global.edit') }}</button>
                            </a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return showConfirmation()">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger ml-3">{{ __('global.delete') }}</button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
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
        @endforeach
        {{ $tasks->links() }}
    </div>
</div>
<script>
    let deleteConfirmation = @json(__('tasks.confirm_deletion'));
    function showConfirmation() {
        return confirm(deleteConfirmation);
    }
</script>
@endsection
