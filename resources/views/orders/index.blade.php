@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Show all orders</h1>
                <a href="{{ route('orders.create') }}">
                    <div class="btn btn-lg btn-flat bg-success">
                        Add New
                    </div>
                </a>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">orders</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div class="container-fluid">
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="data_start">Start Date</label>
                                <input type="date" name="data_start" id="data_start" class="form-control" inputmode="numeric" value="{{ old('data_start') }}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="data_end">End Date</label>
                                <input type="date" name="data_end" id="data_end" class="form-control" inputmode="numeric" value="{{ old('data_end') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="submit" value="Search" class="btn btn-success">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <p>
    <table id="list" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Destiny</th>
                <th>Going Date</th>
                <th>Back Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order["destiny"] }}</td>
                    <td>{{ date('d/m/Y', strtotime($order['going_date'])) }}</td>
                    <td>{{ date('d/m/Y', strtotime($order['back_date'])) }}</td>
                    <td>{{ getStatusOrder($order['status']) }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('orders.show', $order['id']) }}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('orders.edit', $order['id']) }}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>

                        <form class="btn btn-sm"  action="{{ route('orders.delete', $order['id']) }} " method="POST">
                            @csrf()
                            @method('DELETE')
                            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Destiny</th>
                <th>Going Date</th>
                <th>Back Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
    </p>
@stop

@section('plugins.Datatables', true)
@section('js')
    <script>
        $(function() {
            $('#list').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop
