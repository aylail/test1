
@extends('layout')
 
@section('content')
<h2 class="subtitle has-text-centered mt-4"> 詳細</h2>
 
<div class="media-content column is-8 is-offset-2">
    <h3 class="has-text-weight-bold">会社名:</h3>
    <div class="box">
        <p>{{ $companies->company_name }}</p>
    </div>
    <h3 class="has-text-weight-bold">住所:</h3>
    <div class="box">
        <p>{{ $companies->street_address }}</p>
    </div>
    <h3 class="has-text-weight-bold">代表者:</h3>
    <div class="box">
        {{ $companies->representative_name }}
    </div>
    <div class="has-text-right">
        <a class="button is-info my-4 has-right" href="{{ route('products') }}"> 戻る</a>
    </div>
</div>
@endsection