@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-xl-9 col-lg-7 h-100 shadow border-left-danger">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white    ">
                    <h6 class="m-0 font-weight-bold text-primary">Checkout</h6>
                </div>
                <div class="card-body py-3 align-items-center">
                    <form action="{{route('buyitem')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>Alamat<span>*</span>
                                    </label>
                                    <textarea id="address" name="address" class="form-control" required placeholder="Alamat Lengkap pengiriman"></textarea>
                               </div>
                                <div class="form-group ">
                                    <label>Provinsi Tujuan<span>*</span>
                                    </label>
                                    <select name="provinsi_id" id="provinsi_id" required class="form-control border-danger">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($prov as $p)
                                            <option value="{{$p['province_id']}}">{{$p['province']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label>Kota Tujuan<span>*</span>
                                    </label>
                                    <select name="kota_id" id="kota_id" required class="form-control border-danger">
                                        <option value="">Pilih Kota</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        <div class="card col-xl-9 col-lg-7 h-100 shadow py-2 border-left-primary" style="margin-top: 1%">
            <div class="py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                <h6 class="m-0 font-weight-bold text-primary">{{$products->product_name}}</h6>
            </div>
                <div class="media" style="margin-top: 1%">
                    <img src="/product_images/{{$prodimage->image_name}}" style="width:20%">
                    <div class="media-body" style="margin-left: 1%">
                        <p class="text-left">Stock : {{$products->stock}}</p>
                        <p name="{{$products->weight}}" id="weight" class="text-left">Weight : {{$products->weight}}</p>
                        <p class="text-left">Price : {{$products->price}}</p>
                    </div>
                </div>
                <div class="form-group ">
                    <label>Ekspedisi<span>*</span>
                    </label>
                    <select name="kurir" id="kurir" required class="form-control border-primary">
                        <option value="">Pilih Ekspedisi</option>
                        @foreach($kurir as $k)
                            <option value="{{$k->courier}}">{{strtoupper($k->courier)}}</option>
                        @endforeach
                    </select>
                </div>
            <div class="form-group ">
                <label>Layanan<span>*</span>
                </label>
                <select name="layanan" id="layanan" required class="form-control border-primary">
                    <option value="">Pilih Layanan</option>
                </select>
            </div>
        </div>
        <div class="card col-xl-9 col-lg-7 h-100 shadow py-3 border-left-warning" style="margin-top: 1%">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                <h6 class="m-0 font-weight-bold text-primary">Ringkasan</h6>
            </div>
            <div class="card-body py-3 align-items-center">
                <div class="col-xl-12 py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                    <div class="row">
                        <h5>Total Belanja Rp. </h5>
                        <div class="h5" id="belanja">{{$products->price}}</div>
                        <input type="hidden" name="product_id" value="{{$products->id}}">
                        <input type="hidden" name="qty" value="{{$qty}}">
                    </div>
                </div>
                <div class="col-xl-12 py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom">
                    <div class="row">
                        <h5>Ongkos Kirim Rp.</h5>
                        <div class="h5" id="ongkos"></div>
                        <input type="hidden" id="ongkosin" name="ongkosin" value="">
                    </div>
                </div>
                <div class="col-xl-12 py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom border-white">
                    <div class="row">
                        <h5>Total Rp.</h5>
                        <div class="h5" id="total"></div>
                        <input type="hidden" id="totalin" name="totalin" value="">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Proses Order</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
            <script>
                $(document).ready(function(){
                    $('select[name="provinsi_id"]').on('change', function(){
                        let provinceid = $(this).val();
                        if(provinceid){
                            jQuery.ajax({
                                url:"/kota/"+provinceid,
                                type:'GET',
                                dataType:'json',
                                success:function(data){
                                    $('select[name="kota_id"]').empty();
                                    $.each(data, function(key, value){
                                        $('select[name="kota_id"]').append('<option value="'+ value.city_id +'" namakota="'+ value.type +' ' +value.city_name+ '">' + value.type + ' ' + value.city_name + '</option>');
                                    });
                                }
                            });
                        }else {
                            $('select[name="kota_id"]').empty();
                        }
                    });

                    $('select[name="kurir"]').on('change', function(){
                        let origin = 114;
                        let destination = $("select[name=kota_id]").val();
                        let courier = $("select[name=kurir]").val();
                        let weight =  $('#weight').attr('name');
                        if(courier){
                            jQuery.ajax({
                                url:"/cost="+origin+"&destination="+destination+"&weight="+weight+"&courier="+courier,
                                type:'GET',
                                dataType:'json',
                                success:function(data){
                                    $('select[name="layanan"]').empty();
                                    $.each(data, function(key, value){
                                        $.each(value.costs, function(key1, value1){
                                            $.each(value1.cost, function(key2, value2){
                                                $('select[name="layanan"]').append('<option value="'+ value2.value +'">' + value1.service + '-' + value1.description + '-' +value2.value+ '</option>');
                                            });
                                        });
                                    });
                                }
                            });
                        } else {
                            $('select[name="layanan"]').empty();
                        }
                    });

                    $('select[name="layanan"]').on('change', function(){
                        let courier = parseInt($("select[name=layanan]").val());
                        var money = parseInt($("#belanja").text());
                        var total = money+courier;
                        $('#totalin').val(total);
                        $('#ongkosin').val(courier);
                        $('#ongkos').html(courier);
                        $('#total').html(total);
                    });
                });
            </script>
@endsection
