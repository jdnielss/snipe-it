@extends('layouts/default')
{{-- Page title --}}
@section('title') Document Create @parent

@stop

@section('header_right')

    @can('create', \App\Models\Document::class)
        <a href="{{ route('document') }}" accesskey="n" class="btn btn-primary pull-right" style="margin-right: 5px;">Back</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')

<div class="col-md-12">
    <div class="col-md-6">
        <form action="{{ route('document.store') }}" method="POST"> 
            @csrf
            
            <div class="form-group">
                <label class="font-weight-bold">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Masukkan Judul Blog">
            
                <!-- error message untuk title -->
                @error('name')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">

@include ('partials.bootstrap-table')


@stop