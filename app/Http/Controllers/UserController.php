<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Useraplikasi;
use PDF;
use Session;

use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(request $request){
        if($request->role==''){
            $role='all';
        }else{
            $role=decode($request->role);
        }
        return view('user.index',compact('role'));
    }

    public function index_akses(){
        return view('user.index_akses');
    }

    public function hapus($id){
        $data=Aplikasi::where('id',$id)->delete();
        echo'ok';
    }

    public function simpan(request $request){
        if (trim($request->name) == '') {$error[] = '- Nama harus diisi';}
        if (trim($request->nik) == '') {$error[] = '- Email harus diisi';}
        if (trim($request->email) == '') {$error[] = '- Email Harus disisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=User::where('nik',$request->nik)->orWhere('email',$request->email)->count();
            if($cek>0){
                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> NIK atau Email sudah terdaftar</p>';
            }else{
                $data           = new User;
                $data->name     = $request->name;
                $data->email    = $request->email;
                $data->role_id      = $request->role_id;
                $data->nik      = $request->nik;
                $data->password = Hash::make($request->nik);
                $data->save();

                if($data){
                    echo'ok';
                }
               
            }
        }
    }

    public function simpan_akses(request $request,$id,$nik){
        error_reporting(0);
        $count=count($request->aplikasi_id);
        $delete=Useraplikasi::where('nik',$nik)->delete();
        if($count>0){
            for($x=0;$x<$count;$x++){
                $data           = new Useraplikasi;
                $data->nik      = $nik;
                $data->aplikasi_id    = $request->aplikasi_id[$x];
                $data->save();
            }

            echo'ok';
        }else{
            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Pilih Aplikasi</p>';
        }
        
    }
    public function edit(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama  harus diisi';}
        if (trim($request->nik) == '') {$error[] = '- NIK  harus diisi';}
        if (trim($request->email) == '') {$error[] = '- Email harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
               
            $data           = User::find($id);
            $data->name     = $request->name;
            $data->email    = $request->email;
            $data->role_id      = $request->role_id;
            $data->nik      = $request->nik;
            $data->password = Hash::make($request->nik);
            $data->save();

            if($data){
                echo'ok';
            }
                
        }
    }

    public function import_data(request $request)
    {
       error_reporting(0);
        // menangkap file excel
        $type=explode('.',$_FILES['file']['name']);

        if($type[1]=='xls' || $type[1]=='xlsx'){

            $filess = $request->file('file');
            $nama_file = rand().$filess->getClientOriginalName();
            $filess->move('file_excel',$nama_file);
            Excel::import(new UserImport, public_path('/file_excel/'.$nama_file));
            // Session::flash('ok');
            echo'ok';
        }else{
            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format File Harus xls/xlsx</p>';
            
        }
    }
}
