@extends('layouts.app_adm')
<link href="{{ asset('css/layoutCSS.css') }}" rel="stylesheet">
@section('content')
<!-- Latest compiled and minified CSS -->


 <createvente :produits="{{$produits}}" :clients="{{$clients}}"></createvente>

@endsection
