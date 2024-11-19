@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid mt-5 custom-container">
        <a href="{{ route('tasks.index') }}">
            <button class="btn btn-secondary" type="button">{{ __('global.back') }}</button>
        </a>
        <div class="row">
            <div class="card-body mt-3">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        @include('tasks.form', ['task' => $task])
                    </div>
                    <button class="btn btn-primary">{{ __('tasks.edit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
