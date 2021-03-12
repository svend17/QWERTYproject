@csrf
<div class="form-group">
    <input type="text" class="form-control" name="title" placeholder="Tittle" required value="{{ $post->title ?? '' }}">
</div>
<div class="form-group">
    <textarea class="form-control" name="excerpt" placeholder="Excerpt" required>{{ $post->excerpt ?? '' }}</textarea>
</div>
<div class="form-group">
    <textarea class="form-control" name="body" placeholder="Text" rows="7" required>{{ $post->body ?? '' }}</textarea>
</div>
<div class="form-group">
    <textarea class="form-control" name="tags" placeholder="Tags">@if(isset($post))@foreach($post->tags as $tag){{ $tag->name }},@endforeach @endif</textarea>
</div>
<select class="custom-select" name="category_id">
        @foreach($categories as $category)
        @if(isset($post) && $category->id == $post->category->id)
            <option selected value="{{ $category->id }}">{{ $post->category->name }}</option>
        @else
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endif
        @endforeach
</select>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Save</button>
</div>
