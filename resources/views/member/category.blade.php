@extends('store.layout.layout')
@section('title', 'সদস্য গণের তালিকা' . ' - ' . theme()->title())
@section('content')
    <style>
        .member-card {
            height: 350px;
        }

        .total {
            margin-top: -0px !important;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }


        .card-title {
            margin-top: 10px;
            font-size: 1.2rem;
            color: #333;
        }

        .total {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }
    </style>


    <div class="row">

        <div class="col-md-12 col-sm-12">
            <div class="card mb-4 shadow-sm">
                <h5 class="card-header">সদস্য</h5>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold text-dark">ফাউন্ডেশন, পরিচালনা ও রক্ষণাবেক্ষণ সদস্য</h5>
                    <h5 class="card-title total text-muted total"><i class="fa fa-users"></i> সর্বমোট সদস্য সংখ্যা:
                        {{ bnConvert()->number($totalSoddosho) }} জন</h5>
                    <a href="{{ route('members.category', ['category' => 'soddosho']) }}" class="btn btn-success btn-lg"> <i
                            class="fa fa-eye"></i> সদস্যদের তালিকা দেখুন</a>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="card mb-4 shadow-sm">
                <h5 class="card-header">সহযোদ্ধা</h5>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold text-dark">সহযোদ্ধা মূলত দেশে অবস্থানরত যুবসমাজ নিয়ে গঠিত হবে।
                        এরা মূলত
                        ভলান্টিয়ারের দায়িত্ব পালন করবে</h5>
                    <h5 class="card-title total text-muted total"><i class="fa fa-users"></i> সর্বমোট সহযোদ্ধাদের সংখ্যা:
                        {{ bnConvert()->number($totalShohojoddha) }} জন</h5>
                        <a href="{{ route('members.category', ['category' => 'shohojoddha']) }}"
                            class="btn btn-info"><i
                            class="fa fa-eye"></i> সহযোদ্ধাদের তালিকা দেখুন</a>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="card mb-4 shadow-sm">
                <h5 class="card-header">দাতা সদস্য</h5>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold text-dark">বাৎসরিক অথবা আজীবন মেয়াদে তারা ফাউন্ডেশনে দাতা সদস্য
                        হবে</h5>
                    <h5 class="card-title total text-muted total"><i class="fa fa-users"></i> সর্বমোট দাতা সদস্য সংখ্যা:
                        {{ bnConvert()->number($totalDataSoddosho) }} জন</h5>
                    <a href="{{ route('members.category', ['category' => 'data_soddosho']) }}" class="btn btn-secondary"> <i
                            class="fa fa-eye"></i> দাতা সদস্যদের তালিকা দেখুন</a>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="card mb-4 shadow-sm">
                <h5 class="card-header">শুভাকাঙ্ক্ষী</h5>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold text-dark">শুভাকাঙ্ক্ষী মূলত বর্তমান ও সাবেক প্রবাসীদের কে নিয়ে
                        গঠিত হবে। এলাকার কিছু সিনিয়র ব্যক্তিদের রাখা যেতে পারে</h5>
                    <h5 class="card-title total text-muted total"><i class="fa fa-users"></i> সর্বমোট শুভাকাঙ্ক্ষী সংখ্যা:
                        {{ bnConvert()->number($totalShuvokankkhi) }} জন</h5>
                    <a href="{{ route('members.category', ['category' => 'shuvokankkhi']) }}" class="btn btn-primary"> <i
                            class="fa fa-eye"></i> শুভাকাঙ্ক্ষীদের তালিকা দেখুন</a>
                </div>
            </div>
        </div>

        
    </div>

@stop
