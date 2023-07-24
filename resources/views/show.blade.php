
@extends('layout')
 
@section('content')


<h2 class="subtitle has-text-centered mt-4"> 詳細</h2>
<form method="POST" action="{{ route('products.show',$products->id) }}">
 
<div class="media-content column is-8 is-offset-2">
    <h3 class="has-text-weight-bold">ID:</h3>
    <div class="box">
        <p>{{ $products->company_id }}</p>
    </div>
    <h3 class="has-text-weight-bold">画像:</h3>
    <div class="box">
        <p>{{ $products->img_path }}</p>
    </div>
    <h3 class="has-text-weight-bold">商品名:</h3>
    <div class="box">
        {{ $products->product_name }}
    </div>
    <h3 class="has-text-weight-bold">メーカー名:</h3>
    <div class="box">
        <p>{{ $companies->company_name }}</p>

    </div> <h3 class="has-text-weight-bold">価格:</h3>
    <div class="box">
        <p>{{ $products->price }}</p>
    </div> <h3 class="has-text-weight-bold">在庫数:</h3>
    <div class="box">
        <p>{{ $products->stock }}</p>
    </div>
    <h3 class="has-text-weight-bold">コメント:</h3>
    <div class="box">
        <p>{{ $products->comment }}</p>
    </div>
         <a class="button is-info" href="{{ route('products.edit', $products->id) }}">編集</a>    
        <a class="button is-info" href="{{ route('products') }}"> 戻る</a>
    </div>
</form>
</div>
@endsection