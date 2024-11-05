<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDipositeRequest;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{

    public function index()
    {
        return view('transaction.index');
    }

    public function diposite()
    {
        $transactions = Transaction::diposite()->get();
        return view('transaction.diposite', compact('transactions'));
    }

    public function dipositeData(Request $request)
    {
        $userQuery = Transaction::diposite()->orderBy('id', 'desc');

        return DataTables::of($userQuery)
            ->filter(function ($query) use ($request) {})
            ->addColumn('photo', function ($model) {
                if($model->member) {
                    return "<img src='" . $model->member->image->src() . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
                }
            })
            ->addColumn('member_id', function ($model) {
                if($model->member) {
                    return $model->member->organization_id;
                }
            })
            ->addColumn('mobile', function ($model) {
                if($model->member) {
                    return $model->member->mobile;
                }
                return $model->mobile;
            })
            ->addColumn('diposite_by', function ($model) {
                return $model->user->name;
            })
            ->editColumn('name', function ($model) {
                if($model->member) {
                    return $model->member->name . " (".$model->member->id.")";
                }
                return $model->name;
            })
            
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('j M Y, g:i A') . " (" . $model->created_at->diffForHumans() . ")";
            })
            
            ->addColumn('action', function ($model) {
                $content = "<button data-url='" . route('admin.transaction.delete', ['transaction' => $model->uuid]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadTransactionDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";
                return $content;
            })

            ->make(true);
    }

    public function dipositeCreate()
    {
        $members = Member::approved()->get();
        return view('transaction.diposite_create', compact('members'));
    }

    public function dipositeStore(StoreDipositeRequest $request)
    {
        Transaction::create([
            'type' => 'diposite',
            'amount' => $request->amount,
            'member_id' => $request->member_id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'note' => $request->note,
        ]);

        return response()->json([
            'message' => 'Successfully diposite'
        ]);
    }

    public function withdraw()
    {
        $transaction = Transaction::withdraw()->get();
        return view('transaction.withdraw', compact('transaction'));
    }

    public function withdrawCreate()
    {
        return view('transaction.withdraw_create');
    }

    public function withdrawStore(Request $request)
    {
        Transaction::create([
            'type' => 'withdraw',
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return response()->json([
            'message' => 'Successfully withdraw'
        ]);
    }

    public function delete($transactionUuid)
    {
        $transaction = Transaction::where(['uuid' => $transactionUuid])->firstOrFail();
        if($transaction) {
            $transaction->delete();
        }
        return response()->json([
            'message' => "Successfully delete transaction"
        ]);
    }
}
