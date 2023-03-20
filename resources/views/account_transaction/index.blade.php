@extends('layouts.app')
@section('content_header')
    <h1>একাউন্ট ড্যাশবোর্ড</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <x-adminlte-small-box title="{{ bnConvert()->number($totalBalance) }} টাকা" text="সর্বমোট একাউন্টে আছে"
                        icon="fa fa-credit-card" theme="info" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <x-adminlte-small-box title="{{ bnConvert()->number($totalDiposite) }} টাকা" text="সর্বমোট জমা হয়েছে"
                        icon="fa fa-credit-card " theme="success" />
                </div>
                <div class="col-md-4 col-sm-4">
                    <x-adminlte-small-box title="{{ bnConvert()->number($totalWithdraw) }} টাকা" text="সর্বমোট তোলা হয়েছে "
                        icon="fa fa-credit-card " theme="danger" />
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><b>Recent Transactions</b></div>
        <div class="card-body">
            @if (auth()->user()->isAdmin())
            <div class="row mb-3">
                <div class="col-md-3 offset-md-9">
                    <div style="text-align: right">
                        <button data-toggle='modal' data-modal-title="জমা করুন"
                            data-url="{{ route('account_transaction.diposite') }}" type="submit"
                            class="btn btn-success mr-1"><i class="fa fa-plus" aria-hidden="true"></i>
                            জমা করুন</button>
                        <button data-toggle='modal' data-modal-title="তুলুন"
                            data-url="{{ route('account_transaction.withdraw') }}" type="submit"
                            class="btn btn-danger mr-1"><i class="fa fa-minus" aria-hidden="true"></i>
                            তুলুন</button>
                    </div>
                </div>
            </div>
            @endif
            <table class="table table-bordered" style="text-align: center">
                <tr>
                    <td>#</td>
                    <td>Type</td>
                    <td>Title</td>
                    <td>Amount</td>
                    <td>Note</td>
                    <td>Added By</td>
                    <td>Created At</td>
                </tr>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td><span
                                class="badge {{ $transaction->type == 'diposite' ? 'badge-success' : 'badge-danger' }}">{{ $transaction->type }}</span>
                        </td>
                        <td>{{ $transaction->title }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->note }}</td>
                        <td>{{ $transaction->user_id }}</td>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        function dipositeAmount(form) {
            
        }
    </script>
@endpush
