@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Discounts</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addCategoriesModal" class="btn btn-success" data-toggle="modal">Add New Discounts</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Persentase</th>
                    <th>Barang</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($disc as $discounts)
                    <tr>
                        <td>{{$discounts->percentage}}%</td>
                        <td>{{$discounts->relasiDiskonProduct->product_name}}</td>
                        <td>{{$discounts->start}}</td>
                        <td>{{$discounts->end}}</td>
                        <td>
                            <a href="#editDiscount{{$discounts->id}}" class="btn btn-warning" data-toggle="modal" style="color:white;">Edit</a>
                            <a href="#deleteDiscount{{$discounts->id}}" class="btn btn-danger" data-toggle="modal" style="color:white;">Delete</a>
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
                    <form method="POST" action="{{route('add.discount.to.product')}}">
                        @csrf
                        <!Persentase>
                        <div class="input-group mb-3">
                            <label for="percent" class="col-sm-3 col-form-label text-sm-right">{{_('Percentage')}}</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">%</span>
                            </div>
                            <input id="percent" name="percent" type="number" max="100" min="1" class="form-control" placeholder="Discount Percentage" aria-label="percent" aria-describedby="basic-addon1" >
                        </div>

                        <!Discount Start>
                        <div class="input-group mb-3">
                            <label for="datestart" class="col-sm-3 col-form-label text-sm-right">{{_('Discount Start')}}</label>
                            <input id="datestart" name="datestart" type="date" class="form-control" placeholder="Discount start" aria-label="datestart" aria-describedby="basic-addon1">
                        </div>

                        <!Discount End>
                        <div class="input-group mb-3">
                            <label for="dateend" class="col-sm-3 col-form-label text-sm-right">{{_('Date End')}}</label>
                            <input id="dateend" name="dateend" type="date" class="form-control" placeholder="Date end" aria-label="dateend" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <label for="id" class="col-sm-3 col-form-label text-sm-right">{{_('Products')}}</label>
                            <select name="id" id="id" class="form-control">
                                    <option value="">------Produk-----</option>
                                @foreach($productitems as $pi)
                                    <option value="{{$pi->id}}">{{$pi->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register Discount') }}
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>


    @foreach($disc as $discounts)
        <!----Edit Categories--->
        <div class="modal fade" id="editDiscount{{$discounts->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Discount</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('update_discount')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $discounts->id }}"><br/>
                            <div class="input-group mb-3">
                                <label for="percent" class="col-sm-3 col-form-label text-sm-right">{{_('Percentage')}}</label>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">%</span>
                                </div>
                                <input id="percent" name="percent" type="number" max="100" min="1" class="form-control" placeholder="Discount Percentage" aria-label="percent" aria-describedby="basic-addon1" value="{{$discounts->percentage}}">
                            </div>
                            <!Discount Start>
                            <div class="input-group mb-3">
                                <label for="datestart" class="col-sm-3 col-form-label text-sm-right">{{_('Discount Start')}}</label>
                                <input id="datestart" name="datestart" type="date" class="form-control" placeholder="Discount start" aria-label="datestart" aria-describedby="basic-addon1" value="{{$discounts->start}}">
                            </div>

                            <!Discount End>
                            <div class="input-group mb-3">
                                <label for="dateend" class="col-sm-3 col-form-label text-sm-right">{{_('Date End')}}</label>
                                <input id="dateend" name="dateend" type="date" class="form-control" placeholder="Date end" aria-label="dateend" aria-describedby="basic-addon1" value="{{$discounts->end}}">
                            </div>

                            <div class="input-group mb-3">
                                <label for="id" class="col-sm-3 col-form-label text-sm-right">{{_('Products')}}</label>
                                <select name="id_product" id="id_product" class="form-control">
                                    <option value="">------Produk-----</option>
                                    @foreach($productitems as $pi)
                                        <option value="{{$pi->id}}">{{$pi->product_name}}</option>
                                    @endforeach
                                </select>
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
        <div class="modal fade" id="deleteDiscount{{$discounts->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Discounts</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you really want to delete this ?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="/admin/discount/del/{{$discounts->id}}">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
