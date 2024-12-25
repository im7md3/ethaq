@extends('api.layout')
@section('title',$order->title)
@section('content')
<x-order.contract :order="$order"></x-order.contract>
@endsection