@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">{{ __('Register Discount') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('add.discount.to.product')}}">
                            @csrf
                            <!Persentase>
                            <div class="input-group mb-3">
                                <label for="percent" class="col-sm-2 col-form-label text-sm-right">{{_('Percentage')}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input id="percent" name="percent" type="number" max="100" min="1" class="form-control" placeholder="Discount Percentage" aria-label="percent" aria-describedby="basic-addon1">
                            </div>

                            <!Discount Start>
                            <div class="input-group mb-3">
                                <label for="datestart" class="col-sm-2 col-form-label text-sm-right">{{_('Discount Start')}}</label>
                                <input id="datestart" name="datestart" type="date" class="form-control" placeholder="Discount start" aria-label="datestart" aria-describedby="basic-addon1">
                            </div>

                            <!Discount End>
                            <div class="input-group mb-3">
                                <label for="dateend" class="col-sm-2 col-form-label text-sm-right">{{_('Date End')}}</label>
                                <input id="dateend" name="dateend" type="date" class="form-control" placeholder="Date end" aria-label="dateend" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3">
                                <label for="id" class="col-sm-2 col-form-label text-sm-right">{{_('Products')}}</label>
                                <select name="id" id="id" class="form-control">
                                    @foreach($productitems as $pi)
                                        <option value="{{$pi->id}}">{{$pi->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!Add Product>
                            <div class="form-group row mb-0">
                                <div class="col-sm-4 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Discount to Product') }}
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
