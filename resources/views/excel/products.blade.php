<table>
    <thead>
    <tr>
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
