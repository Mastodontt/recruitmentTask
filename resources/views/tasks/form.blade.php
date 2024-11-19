@php
    $taskExists = isset($task);
    $task = $taskExists ? $task : optional(null);
@endphp

<div class="mb-3 col-md-12">
    <label for="name">{{ __('tasks.name') }}</label>
    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') ?? $task->name }}" required>
    @include('inc.form_err', ['key' => 'name'])
</div>

<div class="mb-3 col-md-12">
    <label for="description">{{ __('tasks.description') }}</label>
    <textarea style="height:200px;" id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') ?? $task->description }}</textarea>
    @include('inc.form_err', ['key' => 'description'])
</div>

<div class="mb-3 col-md-6">
    <label for="priority">{{ __('tasks.priority') }}</label>
    <select class="form-control @error('priority') is-invalid @enderror" name="priority" id="priority" required>
        <option value="">{{ __('global.select') }}</option>
        @foreach($priorities as $key => $value)
            <option value="{{ $key }}" {{ (old('priority') ?? $task->priority->value ?? '') === $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
    @include('inc.form_err', ['key' => 'priority'])
</div>

<div class="mb-3 col-md-6">
    <label for="status">{{ __('tasks.status') }}</label>
    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
        <option value="">{{ __('global.select') }}</option>
        @foreach($statuses as $key => $value)
            <option value="{{ $key }}" {{ (old('status') ?? $task->status->value ?? '') === $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
    @include('inc.form_err', ['key' => 'status'])
</div>

<div class="mb-3 col-md-12">
    <label for="due_date">{{ __('tasks.due_date') }}</label>
    <input class="form-control @error('due_date') is-invalid @enderror" type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date') ?? ($task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '') }}" required>
    @include('inc.form_err', ['key' => 'due_date'])
</div>
