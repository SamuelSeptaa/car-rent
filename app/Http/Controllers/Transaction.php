<?php

namespace App\Http\Controllers;

use App\Models\rent;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Transaction extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('view transaksi-rental')) {
            abort(403);
        }
        $this->data['title']        = "Laravel Car Rent | Transaction Rental List";
        $this->data['statuses']     = get_enum_values("rents", "status");


        if (auth()->user()->hasRole('Admin')) {
            $this->data['script']       = "admin.transactions.script.index";
            return $this->renderTo('admin.transactions.index');
        }
        if (auth()->user()->hasRole('Member')) {
            $this->data['script']       = "member.transactions.script.index";
            return $this->renderTo('member.transactions.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('view transaksi-rental')) {
            return $this->responseJSONFailedPermission('view transaksi-rental');
        }
        if (auth()->user()->hasRole('Admin')) {
            return $this->show_admin_transactions($request);
        }
        if (auth()->user()->hasRole('Member')) {
            return $this->show_member_transactions($request);
        }
    }
    private function show_admin_transactions($request)
    {
        $query              = rent::select('rents.*', 'cars.plat_number', "users.name")
            ->join('cars', 'cars.id', '=', 'rents.car_id')
            ->join('users', 'users.id', '=', 'rents.user_id');

        return DataTables::of($query)
            // ->addColumn('action', function ($query) {
            //     if ($query->status === "ACTIVE")
            //         return '<div class="btn-group" role="group">
            //             <a href="' . route('return-transaksi-rental', ['id' => $query->id]) . '" type="button" class="btn btn-primary">Kembalikan</a>
            //         </div>';
            // })
            ->editColumn('status', function ($query) {
                $badge_class = "";
                switch ($query->status) {
                    case 'ACTIVE':
                        $badge_class = "badge-info";
                        break;
                    case 'RETURNED':
                        $badge_class = "badge-success";
                        break;
                }
                return '<span class="badge ' . $badge_class . '">' . $query->status . '</span>';
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['cars.plat_number', 'rents.id'],
                    $request->search
                );
                $this->YajraFilterValue(
                    $request->filterValue,
                    $query,
                    "rents.status"
                );
            })
            ->editColumn('created_at', function ($query) {
                return parseTanggal($query->created_at);
            })
            ->editColumn('rent_start_date', function ($query) {
                return parseTanggal($query->rent_start_date, true);
            })
            ->editColumn('rent_end_date', function ($query) {
                return parseTanggal($query->rent_end_date, true);
            })
            ->editColumn('rent_end_date', function ($query) {
                return parseTanggal($query->rent_end_date, true);
            })
            ->editColumn('total_rent_fee', function ($query) {
                return currencyIDR($query->total_rent_fee);
            })
            ->editColumn('date_of_return', function ($query) {
                if ($query->date_of_return !== null)
                    return parseTanggal($query->date_of_return, true);
            })
            ->editColumn('late_fee', function ($query) {
                return currencyIDR($query->late_fee);
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    private function show_member_transactions($request)
    {
        $query              = rent::select('rents.*', 'cars.plat_number')
            ->join('cars', 'cars.id', '=', 'rents.car_id')
            ->where("rents.user_id", auth()->user()->id);

        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                if ($query->status === "ACTIVE")
                    return '<div class="btn-group" role="group">
                        <a href="' . route('return-transaksi-rental', ['id' => $query->id]) . '" type="button" class="btn btn-primary">Kembalikan</a>
                    </div>';
            })
            ->editColumn('status', function ($query) {
                $badge_class = "";
                switch ($query->status) {
                    case 'ACTIVE':
                        $badge_class = "badge-info";
                        break;
                    case 'RETURNED':
                        $badge_class = "badge-success";
                        break;
                }

                return '<span class="badge ' . $badge_class . '">' . $query->status . '</span>';
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['cars.plat_number', 'rents.id'],
                    $request->search
                );
                $this->YajraFilterValue(
                    $request->filterValue,
                    $query,
                    "rents.status"
                );
            })
            ->editColumn('created_at', function ($query) {
                return parseTanggal($query->created_at);
            })
            ->editColumn('rent_start_date', function ($query) {
                return parseTanggal($query->rent_start_date, true);
            })
            ->editColumn('rent_end_date', function ($query) {
                return parseTanggal($query->rent_end_date, true);
            })
            ->editColumn('total_rent_fee', function ($query) {
                return currencyIDR($query->total_rent_fee);
            })
            ->editColumn('date_of_return', function ($query) {
                if ($query->date_of_return !== null)
                    return parseTanggal($query->date_of_return, true);
            })
            ->editColumn('late_fee', function ($query) {
                return currencyIDR($query->late_fee);
            })
            ->rawColumns(['action', 'status'])
            ->removeColumn(['cars.id'])
            ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function return($id)
    {
        if (!auth()->user()->hasPermissionTo('return transaksi-rental')) {
            abort(403);
        }
        $detail                     = rent::select("cars.plat_number", "rents.*")
            ->where('user_id', auth()->user()->id)
            ->join('cars', 'cars.id', '=', 'rents.car_id')
            ->where('rents.id', $id)
            ->where('status', 'ACTIVE')
            ->firstOrFail();


        $this->data['detail']       = $detail;
        $this->data['script']       = "member.transactions.script.return";
        return $this->renderTo('member.transactions.return');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function do_return(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('return transaksi-rental')) {
            abort(403);
        }

        $detail                     = rent::select("cars.plat_number", "cars.rental_rate", "rents.*")
            ->where('user_id', auth()->user()->id)
            ->join('cars', 'cars.id', '=', 'rents.car_id')
            ->where('rents.id', $id)
            ->firstOrFail();

        if ($detail->status !== "ACTIVE")
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Transaksi rental ini sudah dikembalikan'
            ], 406);

        DB::beginTransaction();
        try {
            $late_fee = 0;

            $days = 0;

            if ($detail->rent_end_date < date('Y-m-d')) {
                $date_rent_end = new DateTime($detail->rent_end_date);
                $date_return = new DateTime(date('Y-m-d'));
                $interval = $date_return->diff($date_rent_end);
                $days = $interval->days;
            }


            if ($days > 1)
                $late_fee = ($detail->rental_rate + 150000) * $days;

            rent::where('rents.id', $id)
                ->update([
                    'status'            => 'RETURNED',
                    'date_of_return'    => date('Y-m-d'),
                    'late_fee'          => $late_fee,
                ]);

            DB::commit();

            return response()->json([
                'status'    => 'Success',
                'message'   => "Kendaraan $detail->plat_number berhasil dikembalikan",
            ], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Transaction Failed : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
