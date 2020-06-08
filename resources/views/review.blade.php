@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Review Item</h1>
            <p class="mb-4">Ayo review barang yang kamu beli, sehingga barang makin laku !!!</a>.</p>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Review</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th style="width: 40%">Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th style="width: 40%">Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <tr>
                                @foreach($items as $listitems)
                                    <td>{{$listitems->inverseProduct->product_name}}</td>
                                    <td>{{$listitems->inverseProduct->price}}</td>
                                    <td>{{$listitems->qty}}</td>
                                    <td><a href="#" class="btn btn-success text-white" data-toggle="modal" data-target="#reviewModal{{$listitems->inverseProduct->id}}">Review!!</a></td>
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach($items as $listitems2)
            <div class="modal fade" id="reviewModal{{$listitems2->inverseProduct->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{$listitems2->inverseProduct->product_name}}</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('post_review')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$listitems2->inverseProduct->id}}" name="id_product_review" id="id_product_review">
                                <div class="input-group mb-5">
                                    <label for="konten" class="col-sm-3 col-form-label text-sm-right text-primary">Review Kamu</label>
                                    <textarea id="konten" name="konten" placeholder="Review!!" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="input-group mb-5">
                                    <label for="rate" class="col-sm-3 col-form-label text-sm-right">Ratings</label>
                                    <select name="rate" id="rate" class="form-control">
                                        <option value="1">★</option>
                                        <option value="2">★★</option>
                                        <option value="3">★★★</option>
                                        <option value="4">★★★★</option>
                                        <option value="5">★★★★★</option>
                                    </select>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                Review!!
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
                });
            </script>
@endsection
