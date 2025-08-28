<div>
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Kalender Acara</h3>
            <div class="flex space-x-2">
                <button wire:click="changeView('month')" class="px-3 py-1 text-sm font-medium rounded-md {{ $view === 'month' ? 'bg-primary-100 text-primary-700' : 'text-gray-500 hover:text-gray-700' }}">
                    Bulan
                </button>
                <button wire:click="changeView('week')" class="px-3 py-1 text-sm font-medium rounded-md {{ $view === 'week' ? 'bg-primary-100 text-primary-700' : 'text-gray-500 hover:text-gray-700' }}">
                    Minggu
                </button>
                <button wire:click="changeView('day')" class="px-3 py-1 text-sm font-medium rounded-md {{ $view === 'day' ? 'bg-primary-100 text-primary-700' : 'text-gray-500 hover:text-gray-700' }}">
                    Hari
                </button>
            </div>
        </div>

        <div class="border-t border-gray-200">
            <div class="p-6">
                <!-- Calendar Navigation -->
                <div class="flex items-center justify-between mb-4">
                    <button wire:click="navigate('prev')" class="p-2 rounded-md hover:bg-gray-100">
                        <x-heroicon-s-chevron-left class="h-5 w-5" />
                    </button>
                    <h2 class="text-xl font-semibold text-gray-900">
                        {{ $currentDate->translatedFormat('F Y') }}
                    </h2>
                    <button wire:click="navigate('next')" class="p-2 rounded-md hover:bg-gray-100">
                        <x-heroicon-s-chevron-right class="h-5 w-5" />
                    </button>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-2 mb-2">
                    @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                    <div class="text-center text-sm font-medium text-gray-500 py-2">
                        {{ $day }}
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-2">
                    @php
                        $firstDay = $currentDate->copy()->startOfMonth();
                        $lastDay = $currentDate->copy()->endOfMonth();
                        $startDay = $firstDay->copy()->startOfWeek();
                        $endDay = $lastDay->copy()->endOfWeek();
                        $currentDay = $startDay->copy();
                    @endphp

                    @while($currentDay <= $endDay)
                        @php
                            $isCurrentMonth = $currentDay->month === $currentDate->month;
                            $isToday = $currentDay->isToday();
                            $dayEvents = array_filter($events, function($event) use ($currentDay) {
                                $eventStart = Carbon::parse($event['start']);
                                $eventEnd = Carbon::parse($event['end']);
                                return $currentDay->between($eventStart, $eventEnd);
                            });
                        @endphp

                        <div class="min-h-24 p-2 border border-gray-200 {{ !$isCurrentMonth ? 'bg-gray-50' : '' }} {{ $isToday ? 'bg-primary-50' : '' }}">
                            <div class="text-right">
                                <span class="text-sm {{ $isCurrentMonth ? 'text-gray-900' : 'text-gray-400' }} {{ $isToday ? 'font-bold' : '' }}">
                                    {{ $currentDay->day }}
                                </span>
                            </div>
                            
                            <div class="mt-1 space-y-1">
                                @foreach($dayEvents as $event)
                                <div class="text-xs p-1 rounded {{ 
                                    $event['color'] === 'green' ? 'calendar-event-dinas' : 
                                    ($event['color'] === 'blue' ? 'calendar-event-approved' :
                                    ($event['color'] === 'yellow' ? 'calendar-event-pending' :
                                    'calendar-event-rejected'))
                                }}">
                                    {{ $event['title'] }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        @php
                            $currentDay->addDay();
                        @endphp
                    @endwhile
                </div>
            </div>
        </div>
    </div>
</div>