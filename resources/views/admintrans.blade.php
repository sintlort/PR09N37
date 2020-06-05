@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Transaksi</h1>
        <p class="mb-4">Semua Transaksi ada di sini!!.....</a>.</p>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Timeout</th>
                            <th>Total Transaksi</th>
                            <th>Kurir</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Timeout</th>
                            <th>Total Transaksi</th>
                            <th>Kurir</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($items as $items)
                            <tr>
                                <td>{{$items->timeout}}</td>
                                <td>{{$items->sub_total}}</td>
                                <td>{{strtoupper($items->kurir->courier)}}</td>
                                <td>{{strtoupper($items->status)}}</td>
                                <td><a class="btn btn-danger text-white">Batal</a><br><a class="btn btn-warning text-white">Upload</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable();
        } );
    </script>
@endsection
