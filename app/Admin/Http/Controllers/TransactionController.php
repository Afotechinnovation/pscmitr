<?php

namespace App\Admin\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $this->authorize('viewAny', Transaction::class);

        if (request()->ajax()) {
            $transaction = Transaction::query()->with('user','package');

            return DataTables::of($transaction)
                ->filter(function ($transaction) {
                    if (request()->filled('filter.search')) {
                        $transaction->where(function ($transaction) {
                            $transaction->where('price', 'like', '%'. request('filter.search') . '%');
                            $transaction->orWhere('net_total', 'like', '%'. request('filter.search') . '%');
                            $transaction->orWhere('gst_amount', 'like', '%'. request('filter.search') . '%');
                            $transaction->orWhereHas('user', function( $user )  {
                                $user->where('mobile', 'like', '%'. request('filter.search') . '%');
                            });
                            $transaction->orWhereHas('package', function( $package)  {
                                    $package->where('name', 'like', '%'. request('filter.search') . '%');
                                });
                        });
                    }
                    if (request()->filled('filter.date')) {
                        $transaction->where(function ($transaction) {
                            $transaction->whereDate('created_at', Carbon::parse(request('filter.date')))
                                        ->orWhereDate('package_expiry_date', Carbon::parse(request('filter.date')));
                        });
                    }

                })

                ->editColumn('user_id', function ($transaction) {
                    return $transaction->user->mobile;
                })
                ->editColumn('package_id', function ($transaction) {
                    return $transaction->package->name;
                })
                ->editColumn('gst_percentage', function ($transaction) {
                    return $transaction->gst_percentage."%";
                })
                ->editColumn('package_expiry_date', function ($transaction) {
                    return Carbon::parse($transaction->package_expiry_date)->format('Y M d');
                })
                ->editColumn('created_at', function ($transaction) {
                    return Carbon::parse($transaction->created_at)->format('d M Y');
                })

                ->make(true);
        }

        $table = $builder->columns([
            ['data' => 'package_id', 'name' => 'package_id', 'title' => 'Package'],
            ['data' => 'user_id', 'name' => 'user_id', 'title' => 'Mobile'],
            ['data' => 'price', 'name' => 'price', 'title' => 'Price'],
            ['data' => 'gst_percentage', 'name' => 'gst_percentage', 'title' => 'GST Percentage'],
            ['data' => 'gst_amount', 'name' => 'gst_amount', 'title' => 'GST Amount'],
            ['data' => 'net_total', 'name' => 'net_total', 'title' => 'Total'],
            ['data' => 'package_expiry_date', 'name' => 'package_expiry_date', 'title' => 'Expiry Date'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Purchase Date'],

        ])->parameters([
            'lengthChange' => false,
            'searching' => false
        ]);

        return view('admin::pages.transactions.index', compact('table'));
    }
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();

        return response()->json(true, 200);
    }

}
