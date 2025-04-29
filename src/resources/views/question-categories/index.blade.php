@section('title','Question Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Question Categories</h1>
    @can('create', App\Models\QuestionCategory::class)
        <a href="{{ route('question-categories.create') }}" class="btn btn-primary">New Category</a>
    @endcan
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr x-data="{ confirmDelete: false }">
            <td>{{ $category->id }}</td>
            <td><a href="{{ route('question-categories.show', $category) }}">{{ $category->name }}</a></td>
            <td>{{ \Illuminate\Support\Str::limit($category->description,50) }}</td>
            <td>
                @can('update', $category)
                    <a href="{{ route('question-categories.edit', $category) }}" class="btn btn-sm btn-secondary">Edit</a>
                @endcan
                @can('delete', $category)
                    <form action="{{ route('question-categories.destroy', $category) }}" method="POST" class="d-inline" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete = true">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" x-text="confirmDelete ? 'Confirm?' : 'Delete'"></button>
                    </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
