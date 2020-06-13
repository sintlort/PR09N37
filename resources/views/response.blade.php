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
                                <th style="width: 30%">Nama Barang</th>
                                <th>User</th>
                                <th>Rate</th>
                                <th>Konten</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th style="width: 30%">Nama Barang</th>
                                <th>User</th>
                                <th>Rate</th>
                                <th>Konten</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($rev as $review)
                            <tr>
                                    <td>{{$review->product_rev->product_name}}</td>
                                    <td>{{$review->user_rev->name}}</td>
                                    <td>{{$review->rate}}</td>
                                    <td>{{$review->content}}</td>
                                    <td><a href="#" class="btn btn-success text-white" data-toggle="modal" data-target="#reviewModal{{$review->id}}">Response!!</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach($rev as $review2)
            <div class="modal fade" id="reviewModal{{$review2->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Response to {{$review2->user_rev->name}}</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('respond_to_reviews')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{$review2->id}}" name="id_review" id="id_review">
                                <div class="input-group mb-5">
                                    <label for="respon" class="col-sm-3 col-form-label text-sm-right text-primary">Admin, tolong responnya!!</label>
                                    <textarea id="respon" name="respon" placeholder="Respond!!" class="form-control" required aria-label="With textarea"></textarea>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                Respond Admin!!
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
