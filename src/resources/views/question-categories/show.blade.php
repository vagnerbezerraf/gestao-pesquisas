@section('title','Question Category Detail')

@section('content')
<div class="mb-3">
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>
</div>
<div>
    @can('update', $category)
        <a href="{{ route('question-categories.edit', $category) }}" class="btn btn-secondary">Edit</a>
    @endcan
    @can('delete', $category)
        <form action="{{ route('question-categories.destroy', $category) }}" method="POST" class="d-inline" x-data="{confirmDelete:false}" x-on:submit.prevent="confirmDelete ? $el.submit() : confirmDelete=true">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" x-text="confirmDelete?'Confirm?':'Delete'"></button>
        </form>
    @endcan
</div>
@endsection
