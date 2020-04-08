@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 5px; margin: auto;">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">{{ __('Register Product') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('add.product')}}">
                            @csrf
                            <!Product Name>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Product Name')}}</label>
                                <input id="product_name" name="product_name" type="text" class="form-control" placeholder="Product Name" aria-label="product_name" aria-describedby="basic-addon1">
                            </div>

                            <!Product Prices>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Prices')}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input id="product_price" name="product_price" type="number" min="1000" class="form-control" placeholder="Product price" aria-label="product_price" aria-describedby="basic-addon1">
                            </div>

                            <!Product Description>
                            <div class="input-group mb-3">
                                <label for="product_description" class="col-sm-2 col-form-label text-sm-right">{{_('Description')}}</label>
                                <textarea id="product_description" name="product_description" placeholder="Product Description" class="form-control" aria-label="With textarea"></textarea>
                            </div>

                            <!Product Stock>
                            <div class="input-group mb-3">
                                <label for="product_stock" class="col-sm-2 col-form-label text-sm-right">{{_('Stock')}}</label>
                                <input id="product_stock" name="product_stock" type="number" class="form-control" placeholder="Product stock" aria-label="product_stock" aria-describedby="basic-addon1">
                            </div>

                            <!Product Weight>
                            <div class="input-group mb-3">
                                <label for="product_weight" class="col-sm-2 col-form-label text-sm-right">{{_('Weight')}}</label>
                                <input id="product_weight" name="product_weight" type="number" class="form-control" placeholder="Product weight" aria-label="product_weight" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>

                            <!Add Product>
                            <div class="form-group row mb-0">
                                <div class="col-sm-4 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register Category') }}
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
