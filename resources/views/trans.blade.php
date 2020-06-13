@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Transaksi</h1>
            <p class="mb-4">Transaksimu ada di sini!!.....</a>.</p>
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
                            <th>Bukti</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Timeout</th>
                            <th>Total Transaksi</th>
                            <th>Kurir</th>
                            <th>Status</th>
                            <th>Bukti</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($items as $items1)
                        <tr>
                            <td width="15%">{{$items1->timeout}}</td>
                            <td>{{$items1->sub_total}}</td>
                            <td>{{strtoupper($items1->kurir->courier)}}</td>
                            <td>{{strtoupper($items1->status)}}</td>
                            <td>@if($items1->proof_of_payment==null)
                                    <a href="#">Belum ada bukti pembayaran</a>
                                @else
                                    <a href="/proof/{{$items1->proof_of_payment}}">Proof Of Payment</a>
                                @endif</td>
                            <td>@auth('admin')
                                    @if($items1->status=="canceled")
                                        <h5>Status Canceled</h5>
                                    @elseif ($items1->status=="expired")
                                        <h5>Status Expired</h5>
                                        @elseif($items1->status=="unverified" && $items1->proof_of_payment!=null)
                                        <a href="transaction/verif/{{$items1->id}}" class="btn btn-success text-white">Verifikasi</a>
                                        @elseif($items1->status=="verified" && $items1->proof_of_payment!=null)
                                        <a href="transaction/deliv/{{$items1->id}}" class="btn btn-warning text-white">Delivered</a>
                                        @elseif($items1->status=="delivered")
                                        <h5>Barang Dikirim</h5>
                                        @else
                                        <h5>Belum upload Bukti Pembayaran</h5>
                                    @endif
                                @else
                                    @if($items1->status=="expired")
                                        <h5>Transaksi dalam status expired</h5>
                                    @elseif($items1->status=="canceled")
                                        <h5>Transaksi dalam status canceled</h5>
                                    @elseif($items1->proof_of_payment==null)
                                        <a href="/trans/del/{{$items1->id}}" class="btn btn-danger text-white">Batal</a><br><a  class="btn btn-primary btn-warning text-white" href="#" data-toggle="modal" data-target="#updateModal{{$items1->id}}">Upload</a>
                                    @elseif($items1->status=="delivered")
                                        <a href="/trans/review/{{$items1->id}}" class="btn btn-success text-white">Review Barang!</a>
                                    @else
                                            <h5>Sudah Upload bukti pembayaran</h5>
                                    @endif
                                @endauth
                                </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        @foreach($items as $itemss)
            <div class="modal fade" id="updateModal{{$itemss->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('proof_of_payment')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$itemss->id}}" name="id_proof" id="id_proof">
                                <div class="input-group mb-5">
                                    <label for="file" class="col-sm-5 col-form-label text-sm-right text-primary">{{_('Bukti Pembayaran')}}</label>
                                    <input type="file" name="file" id="file" style="margin-top:5px;">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Upload Bukti') }}
                            </button>
                            </form>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

@endsection

@section('script')
    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable();
        } );
    </script>
@endsection
