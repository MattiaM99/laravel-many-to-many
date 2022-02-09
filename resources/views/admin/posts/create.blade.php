@extends('layouts.admin')


@section('title')
 | Crea nuovo post
@endsection

@section('content')
<div class="container">
  <h1>Crea un nuovo post</h1>

  @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{route('admin.posts.store')}}" method="post">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Titolo</label>
      <input type="text" 
      class="form-control @error('title') is-invalid @enderror" 
      id="title" name="title" placeholder="Titolo del post" value="{{old('title')}}">

      @error('title')
      <div class="text-danger">
        {{$message}}
      </div>
      @enderror

    </div>

    <div class="mb-3">
      <label for="content" class="form-label">Contenuto</label>
      <textarea class="form-control @error('content') is-invalid @enderror" 
      id="content" name="content" rows="3" placeholder="Testo del post">{{old('content')}}</textarea>

      @error('content')
      <div class="text-danger">
        {{$message}}
      </div>
      @enderror

    </div>

    <div class="mb-3">
      <label for="title" class="form-label">Categoria</label>
      <select name="category_id" id="category_id" class="form-control">
        <option value="">Seleziona</option>
        @foreach ($categories as $cat)
          <option 
          @if ($cat->id == old('category_id'))
            selected
          @endif
          value="{{$cat->id}}">{{$cat->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      Seleziona i tag del post
      @foreach ($tags as $tag)
        <div>
          <input type="checkbox" name="tags[]" value="{{$tag->id}}" id="tag{{$tag->id}}"
          @if (in_array($tag->id, old('tags', [])))
            checked
          @endif>
          <label style="cursor: pointer" 
          for="tag{{$tag->id}}">{{$tag->name}}</label>
        </div>
      @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Invia</button>
    <button type="reset" class="btn btn-secondary">Reset</button>

  </form>

</div>
@endsection