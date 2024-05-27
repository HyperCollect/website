@extends('filament::page')

@section('title', 'Selected Records')

@section('content')
    <div class="filament-page">
        <h2 class="text-lg font-bold mb-4">Selected Records</h2>
        <div class="space-y-4">
            @foreach($records as $record)
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-md font-semibold">{{ $record->name }}</h3>
                    <p>{{ $record->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
