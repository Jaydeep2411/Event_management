@extends('theme.default')

@section('content')
    <div class="container-fluid px-4">
        <div class="container-fluid mt-4">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Create Event</h4>
                </div>
                <div class="card-body">
                    <form action="{{ isset($event) ? route('events.update', $event->id) : route('events.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($event))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="{{ old('title', $event->title ?? '') }}"
                                class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description ?? '') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" value="{{ old('date', $event->date ?? '') }}"
                                class="form-control @error('date') is-invalid @enderror">
                            @error('date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" name="time"
                                value="{{ old('time', isset($event->time) ? \Carbon\Carbon::createFromFormat('H:i:s', $event->time)->format('H:i') : '') }}"
                                class="form-control @error('time') is-invalid @enderror">

                            @error('time')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" value="{{ old('location', $event->location ?? '') }}"
                                class="form-control @error('location') is-invalid @enderror">
                            @error('location')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1"
                                    {{ old('status', $event->status ?? '') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0"
                                    {{ old('status', $event->status ?? '') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($event) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
