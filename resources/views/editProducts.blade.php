@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">{{ __('Update Product') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('update.products')}}">
                            @csrf
                            <!Product Id Hidden>
                            <input type="hidden" id="product_id" name="product_id" value="{{$editproducts->id}}">
                            <!Product Name>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Product Name')}}</label>
                                <input id="product_name" name="product_name" type="text" class="form-control" placeholder="Product Name" aria-label="product_name" aria-describedby="basic-addon1" value="{{$editproducts->product_name}}">
                            </div>

                            <!Product Prices>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Prices')}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input id="product_price" name="product_price" type="number" min="1000" class="form-control" placeholder="Product price" aria-label="product_price" aria-describedby="basic-addon1" value="{{$editproducts->price}}">
                            </div>

                            <!Product Description>
                            <div class="input-group mb-3">
                                <label for="product_description" class="col-sm-2 col-form-label text-sm-right">{{_('Description')}}</label>
                                <textarea id="product_description" name="product_description" placeholder="Product Description" class="form-control" aria-label="With textarea">{{$editproducts->description}}</textarea>
                            </div>

                            <!Product Stock>
                            <div class="input-group mb-3">
                                <label for="product_stock" class="col-sm-2 col-form-label text-sm-right">{{_('Stock')}}</label>
                                <input id="product_stock" name="product_stock" type="number" class="form-control" placeholder="Product stock" aria-label="product_stock" aria-describedby="basic-addon1" value="{{$editproducts->stock}}">
                            </div>

                            <!Product Weight>
                            <div class="input-group mb-3">
                                <label for="product_weight" class="col-sm-2 col-form-label text-sm-right">{{_('Weight')}}</label>
                                <input id="product_weight" name="product_weight" type="number" class="form-control" placeholder="Product weight" aria-label="product_weight" aria-describedby="basic-addon1" value="{{$editproducts->weight}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <label for="categories" class="col-sm-2 col-form-label text-sm-right">{{_('Categories')}}</label>
                                <select name="categories" id="categories" class="form-control">
                                    @foreach ($listcat as $lc)
                                        <option value="{{ $lc->id }}">{{ $lc->category_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <!Add Product>
                            <div class="form-group row mb-0">
                                <div class="col-sm-4 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Products') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
