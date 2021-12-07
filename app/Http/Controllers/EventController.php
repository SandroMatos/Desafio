<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Acaronlex\LaravelCalendar\Calendar;
use App\Models\Room;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)
    {

        $events = [];
        $calendar = null;
        $rooms = Room::all();
        $room = $request->input('room_id');

        if ($room != null) {

            $results = Room::find($room)->events()->get();

            foreach ($results as $result) {
                $events[] = Calendar::event(
                    $result->title,
                    false,
                    $result->start,
                    $result->end,
                    $result->id,
                );
            }

            $calendar = new Calendar();
            $calendar->addEvents($events);
            $calendar->setOptions([
                'firstDay' => 0,
                'locale' => 'pt-br',
                'displayEventTime' => true,
                'selectable' => true,
                'initialView' => 'timeGridWeek',
                'headerToolbar' => [
                    'left' => 'prev,next today',
                    'center' => 'title',
                    'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
                ],
            ]);
            $calendar->setId('1');
            $calendar->setCallbacks([
                'select' => 'function(event) {
                    var title = prompt(\'Nome da aula:\');
                    var room_id = new URL(window.location.toLocaleString()).searchParams.get("room_id");
                    if (title) {
                        var start=moment(event.startStr).format(\'YYYY-MM-DDTHH:mm:ssZ\'); 
                        var end=moment(event.endStr).format(\'YYYY-MM-DDTHH:mm:ssZ\'); 
                        console.log(event);
                        $.ajax({
                            headers: {
                                \'X-CSRF-TOKEN\': $(\'meta[name="csrf-token"]\').attr(\'content\')
                            },
                            url: "http://127.0.0.1/event",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                room_id: room_id,
                            },
                            type: "POST",
                            success: function(data) {
                                document.location.reload(true);
                            },
                            error: function(error) {
                                alert(error.responseText);
                            }
                        });
                    }
                }',
                'eventClick' => 'function(event) {
                    var deleteMsg = confirm("Você tem certeza que deseja deletar?");
                    if (deleteMsg) {
                        $.ajax({
                            headers: {
                                \'X-CSRF-TOKEN\': $(\'meta[name="csrf-token"]\').attr(\'content\')
                            },
                            type: "DELETE", 
                            url: \'http://127.0.0.1/event/\' + event.event.id, 
                            success: function(response) {
                                event.event.remove();
                            },
                            error: function(error) {
                                alert(error.responseText);
                            }
                        });
                    }
                }'
            ]);
        }

        return view('dashboard', compact(['calendar', 'rooms']));
    }

    public function create(Request $request)
    {
        $userEvents = auth()->user()->events()->get();

        $start = new \DateTime($request->start);
        $end = new \DateTime($request->start);
        $end = $end->add(new \DateInterval('PT1H'));

        foreach ($userEvents as $event) {
            $eventStart = new \DateTime($event->start);
            $eventEnd = new \DateTime($event->end);
            if (($start >= $eventStart && $start < $eventEnd) || ($end >= $eventStart && $end < $eventEnd)) {
                return response('Você já possui horário marcado em outra sala.', 401);
            }
        }

        Event::create([
            'title' => $request->title,
            'start' => $start,
            'end' => $end,
            'room_id' => $request->room_id,
            'user_id' => auth()->user()->id
        ]);
    }

    public function delete(Event $event)
    {
        if ($event->user()->first()->id == auth()->user()->id) {
            $event->delete();
        } else {
            return response('Você não tem permissão para remover a reserva de outro usuário.', 401);
        }
    }
}
