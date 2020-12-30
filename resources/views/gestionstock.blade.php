@extends('layouts.app_adm')
<link href="{{ asset('css/layoutCSS.css') }}" rel="stylesheet">
@section('content')

 <stock :produits="{{$produits}}"></stock>

@endsection
