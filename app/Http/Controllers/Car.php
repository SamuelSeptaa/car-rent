<?php

namespace App\Http\Controllers;

use App\Models\car as ModelsCar;
use App\Models\rent;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Car extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('view kendaraan')) {
            abort(403);
        }
        if (auth()->user()->hasRole('Admin')) {
            $this->data['title']        = "Laravel Car Rent | Kendaraan";
            $this->data['script']       = "admin.kendaraan.script.index";
            return $this->renderTo('admin.kendaraan.index');
        }
        if (auth()->user()->hasRole('Member')) {
            $this->data['title']        = "Laravel Car Rent | Kendaraan Tersedia";
            $this->data['script']       = "member.kendaraan.script.index";
            return $this->renderTo('member.kendaraan.index');
        }
    }

    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create kendaraan')) {
            abort(403);
        }
        $this->data['title']        = "Laravel Car Rent | Create Kendaraan";
        $this->data['script']       = "admin.kendaraan.script.create";
        return $this->renderTo('admin.kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create kendaraan')) {
            return $this->responseJSONFailedPermission('create kendaraan');
        }

        $request->validate([
            'plat_number'           => ['required', 'min:5', 'max:255', 'alpha_num', 'unique:cars,plat_number'],
            'merk'                  => ['required', 'min:5', 'max:255'],
            'model'                 => ['required', 'min:5', 'max:255'],
            'color'                 => ['required', 'min:5', 'max:255'],
            'rental_rate'           => ['required', 'numeric', 'min:50000'],
        ]);
        DB::beginTransaction();
        try {
            ModelsCar::create([
                'plat_number'   => $request->plat_number,
                'merk'          => $request->merk,
                'model'         => $request->model,
                'color'         => $request->color,
                'rental_rate'   => $request->rental_rate,
            ]);
            DB::commit();

            return response()->json([
                'status'    => 'Success',
                'message'   => 'New Car created',
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
     * Display the specified resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('view kendaraan')) {
            return $this->responseJSONFailedPermission('view kendaraan');
        }

        if (auth()->user()->hasRole('Admin')) {
            return $this->show_car_admin($request);
        }
        if (auth()->user()->hasRole('Member')) {
            return $this->show_car_member($request);
        }
    }

    private function show_car_member($request)
    {
        $query = ModelsCar::select("*");

        if ($request->date_from != "") {
            $date1 = $request->date_from;
            $date2 = $request->date_to;

            $query->whereDoesntHave('rents', function ($q) use ($date1, $date2) {
                $q->where('rent_start_date', '<=', $date2)
                    ->where('rent_end_date', '>=', $date1);
            });
        }


        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '<div class="btn-group" role="group">
                    <a href="' . route('rent-kendaraan', ['id' => $query->id]) . '" type="button" class="btn btn-primary">Rental</a>
                </div>';
            })
            ->editColumn('rental_rate', function ($query) {
                return currencyIDR($query->rental_rate);
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['merk', 'model'],
                    $request->search
                );
            })
            ->editColumn('updated_at', function ($query) {
                return parseTanggal($query->updated_at);
            })
            ->rawColumns(['action'])
            ->removeColumn(['id'])
            ->make(true);
    }
    private function show_car_admin($request)
    {
        $query      = ModelsCar::select("*");
        return DataTables::of($query)
            ->addColumn('action', function ($query) {
                return '<div class="btn-group" role="group">
                    <a href="' . route('detail-kendaraan', ['id' => $query->id]) . '" type="button" class="btn btn-primary">Detail</a>
                </div>';
            })
            ->editColumn('rental_rate', function ($query) {
                return currencyIDR($query->rental_rate);
            })
            ->filter(function ($query) use ($request) {
                $this->YajraColumnSearch(
                    $query,
                    ['merk', 'model'],
                    $request->search
                );
            })
            ->editColumn('updated_at', function ($query) {
                return parseTanggal($query->updated_at);
            })
            ->rawColumns(['action'])
            ->removeColumn(['id'])
            ->make(true);
    }

    public function detail($id)
    {
        if (!auth()->user()->hasPermissionTo('detail kendaraan')) {
            abort(403);
        }
        $detail                     = ModelsCar::findOrFail($id);

        $this->data['title']        = "Laravel Car Rent | Detail Car  $detail->plat_number";
        $this->data['detail']       = $detail;
        $this->data['script']       = "admin.kendaraan.script.detail";
        return $this->renderTo('admin.kendaraan.detail');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('update kendaraan')) {
            return $this->responseJSONFailedPermission('update kendaraan');
        }
        $request->validate([
            'plat_number'           => ['required', 'min:5', 'max:255', 'alpha_num', 'unique:cars,plat_number,' . $id],
            'merk'                  => ['required', 'min:5', 'max:255'],
            'model'                 => ['required', 'min:5', 'max:255'],
            'color'                 => ['required', 'min:5', 'max:255'],
            'rental_rate'           => ['required', 'numeric', 'min:50000'],
        ]);

        $detail                     = ModelsCar::findOrFail($id);
        DB::beginTransaction();
        try {
            ModelsCar::where('id', $id)->update([
                'plat_number'   => $request->plat_number,
                'merk'          => $request->merk,
                'model'         => $request->model,
                'color'         => $request->color,
                'rental_rate'   => $request->rental_rate,
            ]);
            DB::commit();

            return response()->json([
                'status'    => 'Success',
                'message'   => "Car $detail->plat_number updated",
            ], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Transaction Failed : ' . $e->getMessage()
            ], 500);
        }
    }

    public function rent($id)
    {
        if (!auth()->user()->hasPermissionTo('rent kendaraan')) {
            abort(403);
        }
        $detail                     = ModelsCar::findOrFail($id);

        $this->data['title']        = "Laravel Car Rent | Rent Car  $detail->plat_number";
        $this->data['detail']       = $detail;
        $this->data['script']       = "member.kendaraan.script.rent";
        return $this->renderTo('member.kendaraan.rent');
    }

    public function create_rent(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('rent kendaraan')) {
            return $this->responseJSONFailedPermission('rent kendaraan');
        }


        $detail                     = ModelsCar::findOrFail($id);



        $request->validate([
            'date_rental'           => ['required']
        ]);


        $date1 = $request->date_from;
        $date2 = $request->date_to;
        $query = ModelsCar::select("*")
            ->where('id', $id)
            ->whereDoesntHave('rents', function ($q) use ($date1, $date2) {
                $q->where('rent_start_date', '<=', $date2)
                    ->where('rent_end_date', '>=', $date1);
            });

        $result = $query->get();
        if ($result->isEmpty())
            return response()->json([
                'status'    => 'Failed',
                'message'   => 'Kendaraan tidak tersedia pada tanggal yang dipilih!'
            ], 406);




        DB::beginTransaction();
        try {

            $date1 = new DateTime($request->date_from);
            $date2 = new DateTime($request->date_to);
            $interval = $date1->diff($date2);
            $days = $interval->days + 1;

            $total_fee = $detail->rental_rate * $days;

            rent::create([
                'car_id'            => $id,
                'user_id'           => auth()->user()->id,
                'rent_start_date'   => $request->date_from,
                'rent_end_date'     => $request->date_to,
                'total_rent_fee'    => $total_fee,
            ]);

            DB::commit();

            return response()->json([
                'status'    => 'Success',
                'message'   => "Kendaraan $detail->plat_number berhasil dirental",
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
