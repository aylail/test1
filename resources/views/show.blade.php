
@extends('layout')
 
@section('content')


<h2 class="subtitle has-text-centered mt-4"> 詳細</h2>

<table class="table is-bordered is-striped has-text-centered">
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>メーカー</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>コメント</th>

        </tr>
    
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->company_id }}</td>
            <td>{{ $product->img_path}}</td>
            <td>{{ $product->product_name }}</td>
            <td>{{ $companies->company_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->comment }}</td>
@endforeach
</table>

    <div class="has-text-right">
        <a class="button is-info my-4 has-right" href="{{ route('products') }}"> 戻る</a>
    </div>
</div>
@endsection