@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order {{ $order->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index')}}">Orders</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <p>
    <div class="card card-primary">
        <div class="card-body" style="display: block;">
            <div class="form-group">
                <label for="destiny">Destiny</label>
                {{ $order->destiny }}
            </div>
            <div class="form-group">
                <label for="status">State</label>
                {{ $order->status }}
            </div>
            <div class="form-group">
                <label for="going_date">Going Date</label>
                {{ $order->going_date }}
            </div>
            <div class="form-group">
                <label for="back_date">Back Date</label>
                {{ $order->back_date }}
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{ route('orders.index')}}" class="btn btn-secondary">Back orders</a>
            <form action="{{ route('orders.delete', $order->id) }} " method="POST" >
                @csrf()
                @method('delete')
                <input type="submit" value="Delete Product" class="btn btn-danger float-right">
            </form>
            
        </div>
    </div>
    </p>
@stop
