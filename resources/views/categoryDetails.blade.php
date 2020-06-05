@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Categories</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addCategoriesModal" class="btn btn-success" data-toggle="modal">Add New Category</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Categories Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td>{{$cat->category_name}}</td>
                    <td>
                        <a href="#editCategoriesModal{{$cat->id}}" class="btn btn-warning" data-toggle="modal" style="color:white;">Edit</a>
                        <a href="#deleteCategoriesModal{{$cat->id}}" class="btn btn-danger" data-toggle="modal" style="color:white;">Delete</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Categories</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('register.category')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label text-md-right">{{ __('Category Name') }}</label>
                            <div class="col-sm-8">
                                <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" required autocomplete="category_name" autofocus>
                                @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register Category') }}
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>


@foreach($categories as $catg)
    <!----Edit Categories--->
    <div class="modal fade" id="editCategoriesModal{{$catg->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Categories</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('edit.category')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $catg->id }}"><br/>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-4 col-form-label text-sm-right">{{_('Category Name')}}</label>
                            <div class="col-sm-6">
                                <input id="category_name" type="text" name="category_name" value="{{ $catg->category_name }}">
                            </div>
                        </div>
                </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!----Delete Categories--->
    <div class="modal fade" id="deleteCategoriesModal{{$catg->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Categories</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you really want to delete {{$catg->category_name}} ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="/admin/category/delete/{{$catg->id}}">Delete</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
