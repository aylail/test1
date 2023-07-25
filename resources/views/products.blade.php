@extends('layout')

@section('content')
<div>
    <h2 class="subtitle has-text-centered mt-4">商品管理システム</h2>

    <form method="get">
        <div class="form-group">
            <input type="text" name="searchword" class="form-control" value="{{$searchword}}" placeholder="キーワード">
        </div>
        <div class="form-group">
            <input type="submit" value="検索">
        </div>
    </form>

    <form method="get" action="{{ route('products') }}">
    <select name="company_name" class="form-control">
        <option value="">メーカーを選択</option>
        @foreach ($companies as $company)
            <option value="{{ $company->company_name }}">
                {{ $company->company_name }}
            </option>
        @endforeach
    </select>
    <input type="submit" class="form-control" value="検索">
</form>



    <div class="column is-8 is-offset-2">
        <a class="button is-primary my-4" href="{{ route('regists.create') }}"> 新規作成</a>

        <table class="table is-bordered is-striped has-text-centered">
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
            </tr>

            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ Storage::url($product->img_path) }}" alt="Product Image" width="100" height="100"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if ($product->company)
                            {{ $product->company->company_name }}
                        @else
                            登録なし
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            <a class="button is-info" href="{{ route('products.show', $product->id) }}">詳細を表示</a>
                            <a class="button is-info" href="{{ route('products.edit', $product->id) }}">編集</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button is-danger"
                                onclick='return confirm("削除しますか？");'>削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $('.form-control').on('click', function(){
            id = $('input[name="company_name","searchWord"]').val();
            $.ajax({
                url: "{{ route('products') }}",
                method: "POST",
                data: { company_name,searchWord : id },
                dataType: "json",
            }).done(function(res){
                    console.log(res);
                    $('ul').append('<li>'+ res + '</li>');
            }).fail(function(){
                alert('通信の失敗をしました');
            });
        });
    </script>
</div>
@endsection
