<table>
    <thead>
    <tr>
        <th>ID</th>
        <th></th>
        <th></th>
        <th></th>
        <th>Type</th>
        <th>Order</th>
        <th>Online Hours</th>
        <th>Offline Hours</th>
        <th>Online Cost</th>
        <th>Offline Cost</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td></td>
            <td></td>
            <td>Product</td>
            <td>{{ $product->order }}</td>
            <td>{{ $product->online_hours }}</td>
            <td>{{ $product->offline_hours }}</td>
            <td>{{ $product->online_cost }}</td>
            <td>{{ $product->offline_cost }}</td>
        </tr>
        @foreach($product->solutions()->get() as $solution)
            <tr>
                <td>{{ $solution->id }}</td>
                <td></td>
                <td>{{ $solution->name }}</td>
                <td></td>
                <td>Solution</td>
                <td>{{ $solution->order }}</td>
                <td>{{ $solution->online_hours }}</td>
                <td>{{ $solution->offline_hours }}</td>
                <td>{{ $solution->online_cost }}</td>
                <td>{{ $solution->offline_cost }}</td>
            </tr>
            @foreach($solution->projects()->get() as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $project->name }}</td>
                    <td>Project</td>
                    <td>{{ $project->order }}</td>
                    <td>{{ $project->total_online_hours }}</td>
                    <td>{{ $project->total_offline_hours }}</td>
                    <td>{{ $project->total_online_cost }}</td>
                    <td>{{ $project->total_offline_cost }}</td>
                </tr>
            @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>
