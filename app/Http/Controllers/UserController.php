<?php

namespace App\Http\Controllers;

use App\Helpers\Apiformatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        try {
            $data = User::all()->toArray();

            return Apiformatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return Apiformatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {   
            $this->validate($request, [
                'username' => 'required|min:4|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required'
            ]);

            $prosesData = User::create([
                'username' => $request->username, 
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role'=> $request->role
            ]);
            
            if ($prosesData) { // Memeriksa apakah $prosesData adalah instance model yang valid
                return Apiformatter::sendResponse(200, 'success', $prosesData);
            } else {
                return Apiformatter::sendResponse(400, 'bad_request', 'Gagal menambahkan data, silahkan coba lagi !');
            }
        } catch (\Exception $err){
            return Apiformatter::sendResponse(400, 'bad_request', $err->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $data = User::where('id', $id)->first();
            return Apiformatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return Apiformatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $getUser = User::find($id);

            if (!$getUser) {
                return ResponseFormatter::sendResponse(404, false, 'Data User Not Found');
            } else {
                $this->validate($request, [
                    'username' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'role' => 'required'
                ]);

                $updateUser = $getUser->update([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                ]);

                if($updateUser) {
                    return ApiFormatter::sendResponse(200, 'Succesfully Update A User Data', $getUser);
                }
            }
        } catch (\Exception $e) {
            return ApiFormatter::sendResponse(400, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $checkproses = User::where('id', $id)->delete();

            if ($checkproses) {
                return
                    Apiformatter::sendResponse(200, 'succes', 'berhasil hapus data User!');
            }
        } catch (\Exception $err) {
            return
                Apiformatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function trash()
    {
        try {
            $data = User::onlyTrashed()->get();

            return
                Apiformatter::sendResponse(200, 'succes', $data);
        } catch (\Exception $err) {
            return
                Apiformatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $checkRestore = User::onlyTrashed()->where('id',$id)->restore();

            if ($checkRestore) {
                $data = User::where('id', $id)->first();
                return Apiformatter::sendResponse(200, 'succes', $data);
            }
        }catch (\Exception $err) {
            return Apiformatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    public function deletePermanent($id)
    {
        try{
            $cekPermanentDelete = User::onlyTrashed()->where('id', $id)->forceDelete();

            if ($cekPermanentDelete) {
                return
                Apiformatter::sendResponse(200, 'success','Berhasil menghapus data secara permanen' );
            }
        } catch (\Exception $err) {
            return
            Apiformatter::sendResponse(400,'bad_request', $err->getMessage());
        }

    }

   

}