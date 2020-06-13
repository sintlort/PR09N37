@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Courier</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addCategoriesModal" class="btn btn-success" data-toggle="modal">Add New Courier</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Courier Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courier as $kurir)
                    <tr>
                        <td>{{strtoupper($kurir->courier)}}</td>
                        <td>
                            <a href="#editCategoriesModal{{$kurir->id}}" class="btn btn-warning" data-toggle="modal" style="color:white;">Edit</a>
                            <a href="#deleteCategoriesModal{{$kurir->id}}" class="btn btn-danger" data-toggle="modal" style="color:white;">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!----Add Categories--->
    <div class="modal fade" id="addCategoriesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Courier</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('create_courier')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="courier_name" class="col-sm-4 col-form-label text-md-right">Courier Name</label>
                            <div class="col-sm-8">
                                <input id="courier_name" type="text" class="form-control" name="courier_name @error('courier_name') is-invalid @enderror" placeholder="Courier Name" required autocomplete="courier_name" autofocus>
                                @error('courier_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        Courier Name
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>


    @foreach($courier as $kurir)
        <!----Edit Categories--->
        <div class="modal fade" id="editCategoriesModal{{$kurir->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Courier</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('update_courier')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $kurir->id }}"><br/>
                            <div class="form-group row">
                                <label for="courier_name" class="col-sm-4 col-form-label text-sm-right">{{_('Courier Name')}}</label>
                                <div class="col-sm-6">
                                    <input id="courier_name" type="text" class="form-control" required name="courier_name" value="{{strtoupper($kurir->courier)}}">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!----Delete Categories--->
        <div class="modal fade" id="deleteCategoriesModal{{$kurir->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Categories</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you really want to delete {{$kurir->courier}} ?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="/admin/courier/{{$kurir->id}}">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
