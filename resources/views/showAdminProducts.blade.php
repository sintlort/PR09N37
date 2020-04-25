@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card-columns">
                @foreach($allproducts as $prod)
                    <div class="card">
                        <img class="card-img-top" src="https://i.pinimg.com/originals/fb/1c/c9/fb1cc9560c5aa9c043f003cbdda4430e.png" alt="Card image cap" style="max-width: 150px">
                        <div class="card-body">
                            <h5 class="card-title">{{$prod->product_name}}</h5>
                            <p class="card-text">Rp. {{$prod->price}}</p>
                            <a class="btn btn-primary btn-warning" href="#" data-toggle="modal" data-target="#updateModal{{$prod->id}}">Update</a>
                            <a class="btn btn-primary btn-danger" href="#" data-toggle="modal" data-target="#deleteModal{{$prod->id}}">Delete</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Delete Modal-->
    @foreach($allproducts as $prod)
        <div class="modal fade" id="deleteModal{{$prod->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are You Sure??</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Delete" If u really want to delete this items!!</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="/admin/products/delete/{{$prod->id}}">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Update Modal-->
    @foreach($allproducts as $prod)
        <div class="modal fade" id="updateModal{{$prod->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Products</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('update.products')}}">
                            @csrf
                            <!Product Id Hidden>
                            <input type="hidden" id="product_id" name="product_id" value="{{$prod->id}}">
                            <!Product Name>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Product Name')}}</label>
                                <input id="product_name" name="product_name" type="text" class="form-control" placeholder="Product Name" aria-label="product_name" aria-describedby="basic-addon1" value="{{$prod->product_name}}">
                            </div>

                            <!Product Prices>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Prices')}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input id="product_price" name="product_price" type="number" min="1000" class="form-control" placeholder="Product price" aria-label="product_price" aria-describedby="basic-addon1" value="{{$prod->price}}">
                            </div>

                            <!Product Description>
                            <div class="input-group mb-3">
                                <label for="product_description" class="col-sm-2 col-form-label text-sm-right">{{_('Desc.')}}</label>
                                <textarea id="product_description" name="product_description" placeholder="Product Description" class="form-control" aria-label="With textarea">{{$prod->description}}</textarea>
                            </div>

                            <!Product Stock>
                            <div class="input-group mb-3">
                                <label for="product_stock" class="col-sm-2 col-form-label text-sm-right">{{_('Stock')}}</label>
                                <input id="product_stock" name="product_stock" type="number" class="form-control" placeholder="Product stock" aria-label="product_stock" aria-describedby="basic-addon1" value="{{$prod->stock}}">
                            </div>

                            <!Product Weight>
                            <div class="input-group mb-3">
                                <label for="product_weight" class="col-sm-2 col-form-label text-sm-right">{{_('Weight')}}</label>
                                <input id="product_weight" name="product_weight" type="number" class="form-control" placeholder="Product weight" aria-label="product_weight" aria-describedby="basic-addon1" value="{{$prod->weight}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <label for="categories" class="col-sm-2 col-form-label text-sm-right">{{_('Cate.')}}</label>
                                <select name="categories" id="categories" class="form-control">
                                    @foreach ($listcat as $lc)
                                        <option value="{{ $lc->id }}">{{ $lc->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!Add Product>
                            <div class="form-group row mb-0">
                                <div class="col-sm-4 offset-sm-4">
                                    <button type="submit" class="btn btn-warning">
                                        {{ __('Update Products') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
