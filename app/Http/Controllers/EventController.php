<?php

namespace App\Http\Controllers;

use App\Models\event;
use App\Http\Requests\eventRequest;
use App\Services\EventService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('admin')->orderBy('id', 'desc')->get();
        return view('admin.dashboard', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.event_create');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:0,1'
        ]);

        try {
            $this->eventService->updateStatus($request->event_id, $request->status);

            return redirect()->back()->with('success', 'Event status updated.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Status update failed.');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(eventRequest $request)
    {
        try {
            $event = $this->eventService->createEvent($request->validated(), Auth::id());

            return redirect()->route('event')->with('success', 'Event created successfully!');
        } catch (Exception $e) {
            Log::error('Event creation failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.event_create', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(eventRequest $request, event $event)
    {
        try {
            $this->eventService->updateEvent($event, $request->validated(), Auth::id());

            return redirect()->route('event')->with('success', 'Event updated successfully.');
        } catch (Exception $e) {
            Log::error('Event update failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update event.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->eventService->deleteEvent($id);

            return redirect()->back()->with('success', 'Event deleted successfully.');
        } catch (Exception $e) {
            Log::error('Event deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete the event.');
        }
    }

    public function event_data(){

        $today = Carbon::today();

        $todayEvents = event::select('title', 'description', 'date', 'time', 'location')->where('status','1')->whereDate('date', $today)->get();
        $futureEvents = event::select('title', 'description', 'date', 'time', 'location')->where('status','1')->whereDate('date', '>', $today)->get();
        $pastEvents = event::select('title', 'description', 'date', 'time', 'location')->where('status','1')->whereDate('date', '<', $today)->get();

        return response()->json([
            'today' => $todayEvents,
            'future' => $futureEvents,
            'past' => $pastEvents
        ]);
    }

}
