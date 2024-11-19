@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container-fluid mt-5 custom-container">
        <a href="{{ route('tasks.index') }}">
            <button class="btn btn-secondary" type="button">{{ __('global.back') }}</button>
        </a>
        <div class="row">
            <div class="card-body mt-3">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        @include('tasks.form')
                    </div>
                    <button class="btn btn-primary">{{ __('tasks.add') }}</button>
                </form>
            </div>
        </div>
</div>
</div>
@endsection
