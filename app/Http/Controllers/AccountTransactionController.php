<?php

namespace App\Http\Controllers;

use App\Http\Requests\DipositeRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\AccountTransaction;
use App\Services\Account\DipositeService;
use App\Services\Account\WithdrawService;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
{
    private $dipositeService;
    private $withdrawService;

    public function __construct(DipositeService $dipositeService, WithdrawService $withdrawService)
    {
        $this->dipositeService = $dipositeService;
        $this->withdrawService = $withdrawService;
    }

    public function index()
    {
        // $this->dipositeService->create("manual", 10);
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

    public function dipositeStore(DipositeRequest $request)
    {
        $this->dipositeService->create("manual", $request->amount, $request->note);
        return response()->json([
            'message' => 'অভিনন্দন টাকা জমা হয়েছে!'
        ]);
    }

    public function withdrawCreate(){
        $accountTransaction = new AccountTransaction();
        return view('account_transaction.withdraw',[
            'accountBalance' => $accountTransaction->totalBalance()
        ]);
    }

    public function withdrawStore(WithdrawRequest $request)
    {
        $transactions = $this->withdrawService->create("manual", $request->amount, $request->note);
        
        if(!$transactions){
            return response()->json([
                'message' => 'একাউন্টে পর্যাপ্ত পরিমান টাকা নেই'
            ], 419);
        }

        return response()->json([
            'message' => 'অভিনন্দন টাকা জমা হয়েছে!'
        ]);
    }
}
