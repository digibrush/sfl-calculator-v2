<table>
    <thead>
    <tr>
        <th>Created At</th>
        <th>Updated At</th>
        <th>ID</th>
        <th></th>
        <th></th>
        <th></th>
        <th>Type</th>
        <th>Order</th>
        <th>Hours</th>
        <th>Cost</th>
        <th>Category</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
            <td>{{ $product->updated_at->format('Y-m-d H:i:s') }}</td>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td></td>
            <td></td>
            <td>Product</td>
            <td>{{ $product->order }}</td>
            <td>{{ $product->hours }}</td>
            <td>{{ $product->cost }}</td>
            <td></td>
        </tr>
        @foreach($product->solutions()->get() as $solution)
            <tr>
                <td>{{ $solution->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $solution->updated_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $solution->id }}</td>
                <td></td>
                <td>{{ $solution->name }}</td>
                <td></td>
                <td>Solution</td>
                <td>{{ $solution->order }}</td>
                <td>{{ $solution->hours }}</td>
                <td>{{ $solution->cost }}</td>
                <td></td>
            </tr>
            @foreach($solution->projects()->get() as $project)
                <tr>
                    <td>{{ $project->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $project->updated_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $project->id }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $project->name }}</td>
                    <td>Project</td>
                    <td>{{ $project->order }}</td>
                    <td>{{ $project->total_hours }}</td>
                    <td>{{ $project->total_cost }}</td>
                    <td>{{ $project->price_category }}</td>
                </tr>
            @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>
