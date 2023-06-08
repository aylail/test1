
@extends('layout')
 
@section('content')
<h2 class="subtitle has-text-centered mt-4">編集</h2>

 
<form method="POST" action="{{ route('products.update',$products->id) }}">


    @csrf

    <h3 class="has-text-weight-bold">商品名:</h3>
    <input type="text" name="product_name" value="{{ $products->product_name }}">
    <h3 class="has-text-weight-bold">会社名:</h3>
    <input type="text" name="company_name" value="{{ $products->company_name }}">
    <h3 class="has-text-weight-bold">価格:</h3>
    <input type="text" name="price" value="{{ $products->price }}">
    <h3 class="has-text-weight-bold">在庫数:</h3>
    <input type="text" name="stock" value="{{ $products->stock }}">
    <h3 class="has-text-weight-bold">詳細:</h3>
    <input type="text" name="comment" value="{{ $products->comment }}">

    <div class="columns">
        <div class="column">
            <button type="submit" class="button is-success my-4">更新</button>
        </div>
        <div class="has-text-right column">
            <a class="button is-info my-4" href="{{ route('products') }}"> 戻る</a>
        </div>
    </div>
</form>
@endsection