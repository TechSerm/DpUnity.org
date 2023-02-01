@extends('store.layout.layout')

@section('content')
    <style>
        .category {
            background-color: #fff;
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin-right: 10px;
            padding: 2px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        .category img {
            border-radius: 5px;
            height: 150px;
        }

        .category .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 5px 0px 3px 0px;
            padding-top: 5px;
            color: black;
            height: 50px;
            /* background: red; */
            overflow: hidden;
            line-height: 15px;
        }

        .categories a:focus{
            outline: none;
        }

        .categories a:hover{
            outline: none;
        }
    </style>
    <div class="row categories">
        @foreach ($categories as $category)
            <div class="col-md-2 col-sm-6 col-lg-2 col-6">
                <a href="{{ route('store.categories.show', $category) }}">
                    <div class="card category" style="height: 210px">
                        <img src="{{ $category->image }}" alt="">
                        <div class="title">{{ $category->name }} ({{ $category->products()->where(['status' => 'publish'])->count() }})</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@stop
