@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">{{ __('Register Product') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('add.product')}}" enctype="multipart/form-data">
                            @csrf
                            <!Product Image>
                            <div class="input-group mb-3">
                                <label for="file" class="col-sm-2 col-form-label text-sm-right">{{_('Product Image')}}</label>
                                <input type="file" name="file[]" id="file" style="margin-top:5px;" multiple required>
                            </div>
                            <!Product Name>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Product Name')}}</label>
                                <input id="product_name" name="product_name" type="text" class="form-control" required placeholder="Product Name" aria-label="product_name" aria-describedby="basic-addon1">
                            </div>

                            <!Product Prices>
                            <div class="input-group mb-3">
                                <label for="product_name" class="col-sm-2 col-form-label text-sm-right">{{_('Prices')}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input id="product_price" name="product_price" required type="number" class="form-control" placeholder="Product price" aria-label="product_price" aria-describedby="basic-addon1">
                            </div>

                            <!Product Description>
                            <div class="input-group mb-3">
                                <label for="product_description" class="col-sm-2 col-form-label text-sm-right">{{_('Description')}}</label>
                                <textarea id="product_description" name="product_description" required placeholder="Product Description" class="form-control" aria-label="With textarea"></textarea>
                            </div>

                            <!Product Stock>
                            <div class="input-group mb-3">
                                <label for="product_stock" class="col-sm-2 col-form-label text-sm-right">{{_('Stock')}}</label>
                                <input id="product_stock" name="product_stock" type="number" required class="form-control" placeholder="Product stock" aria-label="product_stock" aria-describedby="basic-addon1">
                            </div>

                            <!Product Weight>
                            <div class="input-group mb-3">
                                <label for="product_weight" class="col-sm-2 col-form-label text-sm-right">{{_('Weight')}}</label>
                                <input id="product_weight" name="product_weight" type="number" required class="form-control" placeholder="Product weight" aria-label="product_weight" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <label for="categories" class="col-sm-2 col-form-label text-sm-right ">{{_('Categories')}}</label>
                                <select name="categories[]" id="categories" required class="form-control js-example-basic-multiple" multiple="multiple">
                                    @foreach ($listcat as $lc)
                                        <option value="{{ $lc->id }}">{{ $lc->category_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <!Add Product>
                            <div class="form-group row mb-0">
                                <div class="col-sm-4 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Products') }}
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

@section('script')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
