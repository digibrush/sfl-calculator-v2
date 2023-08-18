<x-filament::page>
    <x-filament::card>
        <style>
            .mouse-point {
                cursor: pointer;
            }
        </style>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: [
                            @foreach(\App\Models\Quote::where('type','standard')->orderBy('created_at')->get() as $quote)
                        {
                            id: '{{ $quote->id }}',
                            title: '{{ $quote->reference }}',
                            start: '{{ $quote->created_at->format('Y-m-d') }}',
                            "className": "mouse-point",
                            @if ($quote->converted)
                            "backgroundColor": '#40c90a',
                            @else
                            "backgroundColor": '#e8ad4e',
                            @endif
                        },
                        @endforeach
                    ],
                    eventClick: function(info) {
                        info.jsEvent.preventDefault(); // don't let the browser navigate
                        if (info.event.id) {
                            window.location.replace('/admin/quotes/'+info.event.id+'/edit');
                        }
                    }
                });
                calendar.render();
            });

        </script>
        <div id='calendar'></div>
    </x-filament::card>
</x-filament::page>
