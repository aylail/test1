@extends('layout')
 
@section('content')
<h2 class="subtitle has-text-centered mt-4">商品管理システム</h2>


<form method="get">
    <div class="form-group">
        <input type="text" name="searchword" class="form-control" value="{{$searchword}}" placeholder="キーワード">
    </div>
    <div class="form-group">
        <input type="submit" value="検索">
    </div>
</form>

            <form method="get" action="{{ route('products')}}">
                <select> 
                    @foreach ($products as $product)
                        <option>{{$product->company_id}}</option>
                    @endforeach
                </select>
                <input type="submit" name="company_id" class="form-control"value="検索">
            </form>
        </div>


<div class="column is-8 is-offset-2">
    <a class="button is-primary my-4" href="{{ route('regists.create') }}"> 新規作成</a>
   
    <table class="table is-bordered is-striped has-text-centered">
        <tr>
            <th>ID</th>
            <th>会社ID</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>詳細</th>
            <th>画像</th>

        </tr>
        @foreach ($products as $product)

        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->company_id }}</td>
            <td>{{ $product->product_name}}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->comment }}</td>
            <td>{{ $product->img_path}}</td>
          


            <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    <a class="button is-info" href="{{ route('products.show',$product->id) }}">詳細を表示</a>
                    <a class="button is-success" href="{{ route('products.edit',$product->id) }}">編集</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button is-danger">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
 
@endsection