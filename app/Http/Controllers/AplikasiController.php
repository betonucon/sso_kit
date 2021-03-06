<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aplikasi;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AplikasiController extends Controller
{
    public function index(){
        return view('aplikasi.index');
    }
    public function hapus($id){
        $data=Aplikasi::where('id',$id)->delete();
        echo'ok';
    }

    public function simpan(request $request){
        if (trim($request->name) == '') {$error[] = '- Nama aplikasi harus diisi';}
        if (trim($request->link) == '') {$error[] = '- Link/Url harus diisi';} 
        if (trim($request->singkatan) == '') {$error[] = '- Singkatan harus diisi';} 
        if (trim($request->icon) == '') {$error[] = '- Upload icon aplikasi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=explode('/',$_FILES['icon']['type']);
            $file_tmp=$_FILES['icon']['tmp_name'];
            $file=explode('.',$_FILES['icon']['name']);
            $filename=md5(date('Ymdhis')).'.'.$file[1];
            $lokasi='_file_upload/';


            if($cek[0]=='image'){
                if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                    $data           = new Aplikasi;
                    $data->name     = $request->name;
                    $data->singkatan     = $request->singkatan;
                    $data->php_versi_id     = $request->php_versi_id;
                    $data->link     = $request->link;
                    $data->icon     = $filename;
                    $data->save();

                    if($data){
                        echo'ok';
                    }
                }else{
                    echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                }
            }else{
                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus gambar</p>';
            }
            
            
        }
    }

    public function edit(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama aplikasi harus diisi';}
        if (trim($request->singkatan) == '') {$error[] = '- Singkatan harus diisi';} 
        if (trim($request->link) == '') {$error[] = '- Link/Url harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
                if($request->icon==''){
                    $data           = Aplikasi::find($id);
                    $data->name     = $request->name;
                    $data->singkatan     = $request->singkatan;
                    $data->php_versi_id     = $request->php_versi_id;
                    $data->link     = $request->link;
                    $data->save();

                    if($data){
                        echo'ok';
                    }
                }else{
                    $cek=explode('/',$_FILES['icon']['type']);
                    $file_tmp=$_FILES['icon']['tmp_name'];
                    $file=explode('.',$_FILES['icon']['name']);
                    $filename=md5(date('Ymdhis')).'.'.$file[1];
                    $lokasi='_file_upload/';
    
    
                    if($cek[0]=='image'){
                        if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                            $data           = Aplikasi::find($id);
                            $data->name     = $request->name;
                            $data->singkatan     = $request->singkatan;
                            $data->php_versi_id     = $request->php_versi_id;
                            $data->link     = $request->link;
                            $data->icon     = $filename;
                            $data->save();
    
                            if($data){
                                echo'ok';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus gambar</p>';
                    }
                }
            
        }
    }
}
