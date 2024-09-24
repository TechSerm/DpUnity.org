@extends('store.layout.layout')
@section('title', 'সদস্য গণের তালিকা' . ' - ' . theme()->title())
@section('content')
    <style>
        .member-card {
            height: 350px;
        }
    </style>

    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card mb-2">
                <h5 class="card-header">শুভাকাঙ্ক্ষী</h5>
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;">শুভাকাঙ্ক্ষী মূলত বর্তমান ও সাবেক প্রবাসীদের কে নিয়ে গঠিত হবে। এলাকার কিছু সিনিয়র ব্যক্তিদের রাখা যেতে পারে</span>
                    <br/>
                    <a href="{{ route('members.category', ['category' => 'shuvokankkhi']) }}" class="btn btn-primary mt-3">শুভাকাঙ্ক্ষীদের তালিকা দেখুন</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="card mb-2">
                <h5 class="card-header">সহযোদ্ধা</h5>
                <div class="card-body">
                    <span class="card-title" style="font-size: 18px;">সহযোদ্ধা মূলত দেশে অবস্থানরত যুবসমাজ নিয়ে গঠিত হবে। এরা মূলত
                        ভলান্টিয়ারের দায়িত্ব পালন করবে</span><br/>
                    <a href="{{ route('members.category', ['category' => 'shohojoddha']) }}" class="btn btn-info mt-3">সহযোদ্ধাদের তালিকা দেখুন</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <h5 class="card-header">সদস্য</h5>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <a href="{{ route('members.category', ['category' => 'soddosho']) }}" class="btn btn-success">সদস্যদের তালিকা দেখুন</a>
                </div>
            </div>
        
        </div>
    </div>
    

    

    
@stop
