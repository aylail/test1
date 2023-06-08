@extends('layout')
@section('content')

<h2 class="subtitle has-text-centered mt-4">新規作成</h2>
 
<div class="column is-8 is-offset-2">
    <form action="{{ route('products.store') }}" method="post">
        @csrf
        <h3 class="has-text-weight-bold">商品名:</h3>
        <input class="input" type="text" name="product_name" placeholder="商品名">
        <h3 class="has-text-weight-bold">価格:</h3>
        <textarea class="input" name="price" placeholder="価格"></textarea>
        <h3 class="has-text-weight-bold">在庫数:</h3>
        <input class="input" type="text" name="stock" placeholder="在庫数">
        <h3 class="has-text-weight-bold">詳細:</h3>
        <input class="input" type="text" name="comment" placeholder="詳細">
        <h3 class="has-text-weight-bold">id:</h3>
        <input class="input" type="text" name="company_id" placeholder="id">

        <form action="/upload" enctype="multipart/form-data" method="post">
        <h3 class="has-text-weight-bold">画像:アップロード</h3>
        <input type="file" class="input" name="img_path">
        <button type="submit" class="button is-success my-4">送信</button>
</form>

        <div class="columns">
            <div class="column">
            </div>
            <div class="has-text-right column">
                <a class="button is-info my-4" href="{{ route('products') }}"> 戻る</a>
            </div>
        </div>
    </form>



</div>
@endsection