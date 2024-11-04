@extends('store.layout.layout')
@section('title', theme()->title() . ' - ' . theme()->slogan())
@section('content')



    <div class="card">
        <div class="card-header">
            <h3>জমার তালিকা</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">মোবাইল নাম্বার</th>
                        <th scope="col">পরিমাণ</th>
                        <th scope="col">সময়</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                    <tr>
                        <td>
                            {{ $transaction->mobileNumberMask() }}
                        </td>
                        <td>
                            {{ $transaction->amount }}
                        </td>
                        <td>
                            {{ $transaction->created_at }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            
        </div>
    </div>



@stop
