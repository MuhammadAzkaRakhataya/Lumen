<?php

namespace App\Http\Controllers;

use App\Models\StuffStock;
use Illuminate\Http\Request;

class StuffStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $getStuffStock = StuffStock::with('stuff')->get();

            return ResponseFormatter::sendResponse(200, true, 'Succesfully Get All Stuff Stock Data', $getStuffStock);
        } catch (\Exception $e) {
            return ResponseFormatter::sendResponse(400, false, $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\StuffStock  $stuffStock
     * @return \Illuminate\Http\Response
     */
    public function show(StuffStock $stuffStock)
    {
        try {
            $data = Stuff::with('stuff')->where('id', $id)->first();

            if (is_null($data)) {
                return ApiFormatter::sendResponse(400, 'bad request', 'Data not found!');
             } else {
                return Apiformatter::sendResponse(200, 'succes', $data);
             }
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StuffStock  $stuffStock
     * @return \Illuminate\Http\Response
     */
    public function edit(StuffStock $stuffStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StuffStock  $stuffStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StuffStock $stuffStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StuffStock  $stuffStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(StuffStock $stuffStock)
    {
        try {
            $checkProses = StuffStock::where('id',   $id)->delete();

            return ApiFormatter::sendResponse(200, 'success', 'Data stuff berhasil dihapus!');
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }


    public function trash()
    {
        try {
            $data = StuffStock::onlyTrashed()->get();

            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
             return ApiFormatter::sendResponse(400, 'bad request', 'Gagal mengubah data!');
        }
    }


    public function restore($id)
    {
        try {
            $checkProses = StuffStock::onlyTrashed()->where('id', $id)->restore();

            if ($checkProses) {
                $data = Stuff::find($id);
                return ApiFormatter::sendResponse(200, 'success', $data);
            } else {
                return ApiFormatter::sendResponse(400, 'bad request', 'Gagal mengembalikan data!');
            }   
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function deletePermanent($id)
    {
        try {
            $checkProses = StuffStock::onlyTrashed()->where('id', $id)->forceDelete();

            return ApiFormatter::sendResponse(200, 'success', 'Berhasil menghapus data permanent stuff!');
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }


    public function addStock(Request $request, $id)
    {
        try {

            $getStuffStock = StuffStock::find($id);

            if (!$getStuffStock) {
                return ApiFormatter::sendResponse(404, false, 'Data Stuff Stock Not Found');
            } else {
                $this->validate($request,[
                    'total_available' => 'required',
                    'total_defec' => 'required',
                ]);

                $addStock = $getStuffStock->update([
                    'total_available' => $getStuffStock['total_available'] + $request->total_available,
                    'total_defec' => $getStuffStock['total_defec'] + $request->total_defec,
                ]);

                if ($addStock) {
                    $getStuffStockAdded = StuffStock::where('id', $id)->with('stuff')->first();

                    return ApiFormatter::sendResponse(200, true, 'Successfully Add A Stock Of Stuff Stock Data', $getStuffStockAdded);
                }
            }
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(500, false, $err->getMessage());
    }
}



public function subStock(Request $request, $id)
{
    try {
         $getStuffStock = StuffStock::find($id);

         if (!$getStuffStock) {
            return ApiFormatter::sendResponse(400, false, 'Data Stuff Stock Not Found');
         } else {
            $this->validate($request, [
                'total_available' => 'required',
                'total_defac' => 'required',
            ]);

            $isStockAvailable = $getStuffStock->update['total_available'] - $request->total_available;
            $isStockDefac = $getStuffStock->update['total_defac'] - $request->total_defac;

            if ($isStockAvailable < 0 || $isStockDefac < 0) {
                return ApiFormatter::sendResponse(400, true, 'Substraction Stock Cant Less Than A Stock Stored');
            } else {
                $subStock = $getStuffStock->update([
                    'total_available' => $isStockAvailable,
                    'total_defac' => $isStockDefac,
                ]);

                if ($subStock) {
                    $getStockSub = StuffStock::where('id', $id)->with('stuff')->first();

                    return ApiFormatter::sendResponse(200, true, 'Succesfully Sub A Stock Of StuFf Stock Data', $getStockSub);
                }
            }
         }
    }catch(\Exception $err){
        return ApiFormatter::sendResponse(400, $err->getMessage());
    }
}

}   