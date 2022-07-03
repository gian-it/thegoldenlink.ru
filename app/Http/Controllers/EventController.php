<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService,
    ) {
    }

    public function index(): View
    {
        return view('site.controllers.event.index', [
            'eventGroups' => $this->eventService->getEventsByGroups(),
        ]);
    }

    public function show1()
    {
        return view('site.controllers.event.show');
    }

    public function show2()
    {
        return view('site.controllers.event.show2');
    }
}
