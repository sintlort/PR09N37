@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">{{ __('Register Category') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('register.category')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="category_name" class="col-sm-2 col-form-label text-md-right">{{ __('Category Name') }}</label>
                                <div class="col-sm-6">
                                    <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" required autocomplete="category_name" autofocus>
                                    @error('category_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
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
