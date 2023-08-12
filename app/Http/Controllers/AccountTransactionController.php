<?php

namespace App\Http\Controllers;

use App\Http\Requests\DipositeRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\AccountTransaction;
use App\Services\Account\DepositService;
use App\Services\Account\WithdrawService;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
{
    public function index()
    {
        $this->authorize('account.index');

        $transactions = AccountTransaction::orderBy('id', 'desc')->paginate(20);
        $accountTransaction = new AccountTransaction();

        return view('account_transaction.index', [
            'transactions' => $transactions,
            'totalBalance' => $accountTransaction->totalBalance(),
            'totalDiposite' => $accountTransaction->totalDiposite(),
            'totalWithdraw' => $accountTransaction->totalWithdraw(),
        ]);
    }

    public function dipositeCreate()
    {
        return view('account_transaction.diposite');
    }

    public function dipositeStore(DipositeRequest $request, DepositService $depositService)
    {
        $depositService->manualDeposit($request->amount, $request->note);

        return response()->json([
            'message' => __('info_message.deposit_success')
        ]);
    }

    public function withdrawCreate()
    {
        $accountTransaction = new AccountTransaction();

        return view('account_transaction.withdraw', [
            'accountBalance' => $accountTransaction->totalBalance()
        ]);
    }

    public function withdrawStore(WithdrawRequest $request, WithdrawService $withdrawService)
    {
        $transactions = $withdrawService->withdraw("manual", $request->amount, $request->note);

        if (!$transactions) {
            return response()->json([
                'message' => 'একাউন্টে পর্যাপ্ত পরিমান টাকা নেই'
            ], 419);
        }

        return response()->json([
            'message' => 'অভিনন্দন টাকা জমা হয়েছে!'
        ]);
    }
}
