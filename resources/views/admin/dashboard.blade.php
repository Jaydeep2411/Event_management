@extends('theme.default')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Events List</h1>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('add_event') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Event
        </a>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            All Events
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Admin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->description }}</td>
                            <td>{{ $event->date }}</td>
                            <td>{{ $event->time }}</td>
                            <td>{{ $event->location ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('event.updateStatus') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                        <option value="1" {{ $event->status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$event->status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ $event->admin->name ?? 'Not Assigned' }}</td>
                            <td>
                                 <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No events found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

