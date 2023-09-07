@extends('layout')

@section('content')

    <h2 class="subtitle has-text-centered mt-4">商品管理システム</h2>

    <form id="searchForm" method="get">
        <div class="form-group">
            <input type="text" name="searchword" class="form-control" value="{{$searchword}}" placeholder="キーワード">
        </div>
        <div class="form-group">
            <input type="submit" value="検索">
        </div>
    </form>
    <div id="searchResults"></div>
   

    <form id="searchFormCompany" method="get">
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

        <button class="button is-primary my-4" onclick="sortResults('price', 'asc')">昇順</button>
        <button class="button is-primary my-4" onclick="sortResults('price', 'desc')">降順</button>


        <button class="button is-primary my-4" onclick="sortResults('stock', 'asc')">在庫数昇順</button>
        <button class="button is-primary my-4" onclick="sortResults('stock', 'desc')">在庫数降順</button>

        <table class="table is-bordered is-striped has-text-centered">
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格<button class="button" onclick="sortResults('price', 'asc')">昇順</button><button class="button" onclick="sortResults('price', 'desc')">降順</button></th>
                <th>在庫数<button class="button" onclick="sortResults('stock', 'asc')">昇順</button><button class="button" onclick="sortResults('stock', 'desc')">降順</button></th>
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
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <button type="button" class="button is-danger delete-product" data-product-id="{{ $product->id }}">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <script>

    function sortResults(column, order) {
    var searchword = $('input[name="searchword"]').val();
    var companyName = $('select[name="company_name"]').val();
    var formData = { searchword: searchword, company_name: companyName };

    if (column === 'price') {
        formData['price_order'] = order;
    } else if (column === 'stock') {
        formData['stock_order'] = order;
    }
    $.ajax({
        type: 'GET',
        url: '{{ route('products.sort') }}', 
        data: formData,
        dataType: 'json',
        success: function(data) {
            displaySearchResults(data);
        },
        error: function(error) {
            console.log(error);
        }
    });


    searchProducts(formData);
}


    function searchProducts(formData) {
        $.ajax({
            type: 'GET',
            url: '{{ route('products.search') }}',
            data: formData,
            dataType: 'json',
            success: function(data) {
                displaySearchResults(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }


    function displaySearchResults(data) {
        var searchResults = $('#searchResults');
        searchResults.empty();

        if (data.length > 1) {
            var table = $('<table class="table is-bordered is-striped has-text-centered"></table>');
            var tableHead = $('<tr><th>ID</th><th>商品画像</th><th>商品名</th><th>価格<button class="button" onclick="sortResults(\'price\', \'asc\')">昇順</button><button class="button" onclick="sortResults(\'price\', \'desc\')">降順</button></th><th>在庫数<button class="button" onclick="sortResults(\'stock\', \'asc\')">昇順</button><button class="button" onclick="sortResults(\'stock\', \'desc\')">降順</button></th><th>メーカー名</th></tr>');
            table.append(tableHead);

            $.each(data, function(index, product) {
                var tableRow = $('<tr><td>' + product.id + '</td><td><img src="' + product.img_path + '" alt="Product Image" width="100" height="100"></td><td>' + product.product_name + '</td><td>' + product.price + '</td><td>' + product.stock + '</td><td>' + (product.company ? product.company.company_name : '登録なし') + '</td></tr>');
                table.append(tableRow);
            });

            searchResults.append(table);
        } else {
            searchResults.append('<p>検索結果がありません。</p>');
        }
    }

    
    $(document).ready(function() {
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            searchProducts(formData);
        });

        $('#searchFormCompany').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            searchProducts(formData);
        });
    });

    $(document).ready(function() {
    // ...

    $('.delete-product').on('click', function() {
    var $button = $(this);
    var productId = $button.data('product-id');

    $.ajax({
        type: 'DELETE',
        url: '/products/destroy/' + productId,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            // 削除成功時の処理
            alert(data.message);
            // 該当行を非表示にする
            $button.closest('tr').hide();
        },
        error: function(error) {
            console.log(error);
            // エラー時の処理
        }
    });
});


});


</script>



@endsection
