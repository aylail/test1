@extends('layout')
@section('content')

<div>
  <form action="{{ route('products') }}" method="GET">
    <input type="text" name="keyword" value="{{ $searchword }}">
    <input type="submit" value="検索">
  </form>
</div>

<h1>
  <a href="{{ route('regists') }}">[Add]</a>
</h1>

<table>
  <tr>
    <th></th>
  </tr>

  @forelse ($products as $product)
    <tr>
      <td><a href="{{ route('show' , $products) }}">{{ $product->company_id }}</td></a>
      <td>{{ $product->product_name }}</td>
    </tr>
  @empty

  @endforelse
</table>