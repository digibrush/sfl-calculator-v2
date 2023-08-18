<x-filament::page :widget-data="['record' => $record]">
    <x-filament::card>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="basic" class="w-full text-sm text-left text-gray-500 dark:text-gray-400" style="table-layout: fixed">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 8%;">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 8%;">
                        Online Hours
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 8%;">
                        Offline Hours
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 8%;">
                        Online Cost
                    </th>
                    <th scope="col" class="px-6 py-3" style="width: 8%;">
                        Offline Cost
                    </th>
                    <th colspan="2" scope="col" class="px-6 py-3 text-end" style="width: 15%;">
                        Action
                    </th>
                </tr>
                </thead>
                @foreach($this->record->products as $product)
                    <tr data-node-id="{{ $product->id }}" class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a id="product-{{ $product->id }}"></a>
                            {{ $product->name }}
                        </th>
                        <td class="px-6 py-4">
                            <div class="min-h-6 inline-flex items-center justify-center space-x-1 whitespace-nowrap rounded-xl px-2 py-0.5 text-sm font-medium tracking-tight rtl:space-x-reverse text-success-700 bg-success-500/10">
                                <span class="">
                                    Product
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->online_hours }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $product->offline_hours }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($product->online_cost, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($product->offline_cost, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($product->status)
                                <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-danger-600 hover:text-danger-500 filament-tables-link-action" href="/simulator/products/{{ $product->id }}/select" dusk="filament.tables.action.deselect">
                                    <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Deselect
                                </a>
                            @else
                                <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-success-600 hover:text-success-500 filament-tables-link-action" href="/simulator/products/{{ $product->id }}/select" dusk="filament.tables.action.select">
                                    <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Select
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-primary-600 hover:text-primary-500 filament-tables-link-action" href="/admin/products/{{ $product->id }}/edit?type=simulation" dusk="filament.tables.action.edit">
                                <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @foreach($product->solutions()->get() as $solution)
                        <tr data-node-id="{{ $product->id }}.{{ $solution->id }}" data-node-pid="{{ $product->id }}" class="border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-light text-gray-900 whitespace-nowrap dark:text-white">
                                <a id="solution-{{ $solution->id }}"></a>
                                {{ $solution->name }}
                            </th>
                            <td class="px-6 py-4">
                                <div class="min-h-6 inline-flex items-center justify-center space-x-1 whitespace-nowrap rounded-xl px-2 py-0.5 text-sm font-medium tracking-tight rtl:space-x-reverse text-warning-700 bg-warning-500/10">
                                    <span class="">
                                        Solution
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $solution->online_hours }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $solution->offline_hours }}
                            </td>
                            <td class="px-6 py-4">
                                {{ number_format($solution->online_cost, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ number_format($solution->offline_cost, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($solution->status)
                                    <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-danger-600 hover:text-danger-500 filament-tables-link-action" href="/simulator/solutions/{{ $solution->id }}/select" dusk="filament.tables.action.deselect">
                                        <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Deselect
                                    </a>
                                @else
                                    <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-success-600 hover:text-success-500 filament-tables-link-action" href="/simulator/solutions/{{ $solution->id }}/select" dusk="filament.tables.action.select">
                                        <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Select
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-primary-600 hover:text-primary-500 filament-tables-link-action" href="/admin/solutions/{{ $solution->id }}/edit?type=simulation" dusk="filament.tables.action.edit">
                                    <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @foreach($solution->projects()->get() as $project)
                            <tr data-node-id="{{ $product->id }}.{{ $solution->id }}.{{ $project->id }}" data-node-pid="{{ $product->id }}.{{ $solution->id }}" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-light text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $project->name }}
                                </th>
                                <td class="px-6 py-4">
                                    <div class="min-h-6 inline-flex items-center justify-center space-x-1 whitespace-nowrap rounded-xl px-2 py-0.5 text-sm font-medium tracking-tight rtl:space-x-reverse text-gray-700 bg-gray-500/10">
                                        <span class="">
                                            Project
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $project->total_online_hours }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $project->total_offline_hours }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($project->total_online_cost, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($project->total_offline_cost, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($project->status)
                                        <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-danger-600 hover:text-danger-500 filament-tables-link-action" href="/simulator/projects/{{ $project->id }}/select" dusk="filament.tables.action.deselect">
                                            <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Deselect

                                        </a>
                                    @else
                                        <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-success-600 hover:text-success-500 filament-tables-link-action" href="/simulator/projects/{{ $project->id }}/select" dusk="filament.tables.action.select">
                                            <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Select
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-primary-600 hover:text-primary-500 filament-tables-link-action" href="/admin/projects/{{ $project->id }}/edit?type=simulation" dusk="filament.tables.action.edit">
                                        <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </table>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@kanety/jquery-simple-tree-table@0.5.1/dist/jquery-simple-tree-table.min.js"></script>
        <script>
            $('#basic').simpleTreeTable({
                expander: $('#expander'),
                collapser: $('#collapser')
            });
            @if(\Illuminate\Support\Facades\Session::has('product'))
                $(document).ready(function() {
                    document.getElementById("product-{{ \Illuminate\Support\Facades\Session::get('product') }}").scrollIntoView();
                });
            @endif
            @if(\Illuminate\Support\Facades\Session::has('solution'))
                $(document).ready(function() {
                    document.getElementById("solution-{{ \Illuminate\Support\Facades\Session::get('solution') }}").scrollIntoView();
                });
            @endif
        </script>
    </x-filament::card>
</x-filament::page>
