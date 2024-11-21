@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid mt-5 custom-container">
        <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="priority" class="form-label">{{ __('tasks.priority') }}</label>
                    <select name="priority" id="priority" class="form-control">
                        <option value="">{{ __('global.select') }}</option>
                        @foreach(\App\Enums\TaskPriority::options() as $key => $value)
                            <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="status" class="form-label">{{ __('tasks.status') }}</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">{{ __('global.select') }}</option>
                        @foreach(\App\Enums\TaskStatus::options() as $key => $value)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="due_date_from" class="form-label">{{ __('tasks.due_date_from') }}</label>
                    <input type="date" name="due_date[from]" id="due_date_from" class="form-control"
                           value="{{ request()->input('due_date.from') }}">
                </div>

                <div class="col-md-3">
                    <label for="due_date_to" class="form-label">{{ __('tasks.due_date_to') }}</label>
                    <input type="date" name="due_date[to]" id="due_date_to" class="form-control"
                           value="{{ request()->input('due_date.to') }}">
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">{{ __('global.filter') }}</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary ml-2">{{ __('global.clear_filters') }}</a>
            </div>
        </form>
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

                        @if(!$task->publicAccessToken || !$task->publicAccessToken->expires_at->isFuture())
                        <form action="{{ route('tasks.generate-link', $task->id) }}" method="POST" class="ml-2">
                            @csrf
                            <button type="submit" class="btn btn-info">{{ __('Generate Link') }}</button>
                        </form>
                        @endif

                        @if($task->publicAccessToken && $task->publicAccessToken->expires_at->isFuture())
                        <form action="{{ route('tasks.revoke-link', $task->id) }}" method="POST" class="ml-2">
                            <input type="text" 
                            value="{{ route('tasks.public.show', ['token' => $task->publicAccessToken->token]) }}" 
                            class="form-control"
                            readonly>
                            @csrf
                            <button type="submit" class="btn btn-warning">{{ __('Revoke Link') }}</button>
                        </form>
                        @endif
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
