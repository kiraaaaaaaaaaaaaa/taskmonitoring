<?php

namespace App\Services;

use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarService
{
    public function createEvent($task)
    {
        $event = new Event();

        $event->name = $task->title;

        $event->description = $task->description;

        $event->startDateTime = Carbon::parse($task->start_date);

        $event->endDateTime = Carbon::parse($task->end_date);

        $event->setcolorid($task->color_id);

        $event =$event->save();

        

        return $event->id;

    }

    public function updateEvent($googleEventId, $task)
    {
        $event = Event::find($googleEventId);

        if (!$event) {
            return false;
        }

        $event->name = $task->title;
        $event->description = $task->description;
        $event->startDateTime = Carbon::parse($task->start_date);
        $event->endDateTime = Carbon::parse($task->end_date);

        $event->save();

        return true;
    }

    public function deleteEvent($googleEventId)
    {
        $event = Event::find($googleEventId);

        if ($event) {
            $event->delete();
        }
    }
}