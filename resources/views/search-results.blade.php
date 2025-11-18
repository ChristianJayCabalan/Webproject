@extends('layouts.app') {{-- or your main layout --}}

@section('content')
<div class="container">
  <h3 class="my-4">Search results for "{{ $query }}"</h3>

  <h4>Products</h4>
  @if ($products->count())
    <ul>
      @foreach ($products as $product)
        <li>
          <a href="{{ route('product.details', $product->id) }}">{{ $product->title }}</a>
        </li>
      @endforeach
    </ul>
  @else
    <p>No matching products found.</p>
  @endif

  <h4 class="mt-4">Categories</h4>
  @if ($categories->count())
    <ul>
      @foreach ($categories as $category)
        <li>
          <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
        </li>
      @endforeach
    </ul>
  @else
    <p>No matching categories found.</p>
  @endif
</div>
@endsection
