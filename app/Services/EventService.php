<?php

namespace App\Services;

use App\Models\event;
use App\Models\eventLog;

class EventService
{
    public function createEvent(array $data, $adminId): event
    {
        $data['admin_id'] = $adminId;

        return event::create($data);
    }

    public function updateEvent(Event $event, array $newData, int $adminId)
    {
        $oldData = $event->getOriginal();
        $event->update($newData);

        eventLog::create([
            'event_id' => $event->id,
            'admin_id' => $adminId,
            'action' => 'update',
            'old_values' => json_encode($oldData),
            'new_values' => json_encode($newData),
        ]);
    }

    public function deleteEvent(int $eventId)
    {
        $event = event::findOrFail($eventId);
        $event->delete();
    }

    public function updateStatus(int $eventId, int $status)
    {
        $event = event::findOrFail($eventId);
        $event->status = $status;
        $event->save();
    }
}
