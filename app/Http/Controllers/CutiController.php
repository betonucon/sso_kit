<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuti;
use App\User;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class CutiController extends Controller
{
    public function index(request $request){
        error_reporting(0);
        
        return view('cuti.index');
    }

    public function index_admin(request $request){
        error_reporting(0);
        if($request->bulan==''){
            $bulan=date('m');
            $tahun=date('Y');
        }else{
            $bulan=$request->bulan;
            $tahun=$request->tahun;
        }
        return view('cuti.index_admin',compact('bulan','tahun'));
    }

    public function index_persetujuan(request $request){
        error_reporting(0);
        
        return view('cuti.index_persetujuan');
    }

    public function index_persetujuan_selesai(request $request){
        error_reporting(0);
        
        return view('cuti.index_persetujuan_selesai');
    }

    public function index_acc(request $request){
        error_reporting(0);
        
        return view('cuti.index_selesai');
    }

    public function hapus($id){
        $data=Cuti::where('id',$id)->where('sts',0)->delete();
        echo'ok';
    }

    public function validasi_all(){
        $nik  = array_column(
            User::whereIn('unit_kerja_id', atasan_unitkerja())
            ->get()
            ->toArray(),'nik'
        );

        $data=Cuti::whereIn('nik',$nik)->where('sts',0)->update([
            'sts'=>1,
            'nik_atasan'=>Auth::user()['nik'],
            'tanggal_validasi'=>date('Y-m-d'),
        ]);

        if($data){
            echo'ok';
        }
        
    }

    public function tolak_validasi_all(){
        $nik  = array_column(
            User::whereIn('unit_kerja_id', atasan_unitkerja())
            ->get()
            ->toArray(),'nik'
        );

        $data=Cuti::whereIn('nik',$nik)->where('sts',0)->update([
            'sts'=>2,
            'nik_atasan'=>Auth::user()['nik'],
            'tanggal_validasi'=>date('Y-m-d'),
        ]);

        if($data){
            echo'ok';
        }
        
    }

    public function simpan(request $request){
        error_reporting(0);
        if (trim($request->tanggal_mulai) == '') {$error[] = '- Isi Tanggal Mulai';}
        if (trim($request->tanggal_sampai) == '') {$error[] = '- Isi Tanggal Sampai';}
        if (trim($request->name) == '') {$error[] = '- Alasan Harus diiisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
           if($request->tanggal_mulai>$request->tanggal_sampai){
            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Tanggal sampai salah</p>';
           }else{
                $con=selisih_hari($request->tanggal_mulai,$request->tanggal_sampai);
                    if(sisa_cuti()>=$con){
                        $error=0;
                        for($x=0;$x<=$con;$x++){
                            $cekcuti=Cuti::where('tanggal_cuti',date('Y-m-d', strtotime($request->tanggal_mulai . ' +'.$x.' Weekday')))
                                        ->where('kategori_id',1)->where('nik',Auth::user()['nik'])->count();
                            
                            if($cekcuti>0){

                            }else{
                                    if($request->file==''){
                                        $data               = new Cuti;
                                        $data->tanggal_cuti = date('Y-m-d', strtotime($request->tanggal_mulai . ' +'.$x.' Weekday'));
                                        $data->nik          = Auth::user()['nik'];
                                        $data->tanggal      = date('Y-m-d');
                                        $data->name         = $request->name;
                                        $data->sts_validasi = 0;
                                        $data->sts = 0;
                                        $data->jumlah = 1;
                                        $data->kategori_id = 1;
                                        $data->save();
                                    }else{
                                    
                                        $cek=explode('/',$_FILES['file']['type']);
                                        $file_tmp=$_FILES['file']['tmp_name'];
                                        $file=explode('.',$_FILES['file']['name']);
                                        $filename=md5(date('Ymdhis')).'.'.$cek[1];
                                        $lokasi='_file_cuti/';
                        
                        
                                        if($cek[0]=='image'){
                                            if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                                                $data               = new Cuti;
                                                $data->tanggal_cuti = date('Y-m-d', strtotime($request->tanggal_mulai . ' +'.$x.' Weekday'));
                                                $data->nik          = Auth::user()['nik'];
                                                $data->tanggal      = date('Y-m-d');
                                                $data->name         = $request->name;
                                                $data->file         = $filename;
                                                $data->sts_validasi = 0;
                                                $data->jumlah = 1;
                                                $data->kategori_id = 1;
                                                $data->sts = 0;
                                                $data->save();
                        
                                            }

                                        }else{
                                            $error+=1;
                                        }



                                    }
                            }

                                
                        }

                        if($error>0){
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus gambar</p>';
                        }else{
                            echo'ok';
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Sisa Cuti anda kurang dari '.$con.' Hari</p>';
                    }
                
           }
            
        }
    }

    public function validasi(request $request,$id){
        if (trim($request->sts) == '') {$error[] = '- Pilih Kategori Validasi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data               = Cuti::find($id);
            $data->sts          = $request->sts;
            $data->nik_atasan   = Auth::user()['nik'];
            $data->tanggal_validasi = date('Y-m-d');
            $data->save();

            if($data){
                echo'ok';
            }
        }

    }
    
    public function edit(request $request,$id){
        if (trim($request->tanggal_cuti) == '') {$error[] = '- Isi Tanggal Cuti';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
                if($request->file==''){
                    if($request->tanggal_cuti==$request->tanggal_sebelumnya){
                        $data               = Cuti::where('id',$id)->where('sts',0)->first();
                        $data->name         = $request->name;
                        $data->save();
    
                        if($data){
                            echo'ok';
                        }
                    }else{
                        $cektanggal=Cuti::where('nik',Auth::user()['nik'])->where('tanggal_cuti',$request->tanggal_cuti)->count();
                        if($cektanggal>0){
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Tanggal cuti tidak bisa digunakan</p>';
                        }else{
                            $data               = Cuti::where('id',$id)->where('sts',0)->first();
                            $data->name         = $request->name;
                            $data->tanggal_cuti = $request->tanggal_cuti;
                            $data->save();
        
                            if($data){
                                echo'ok';
                            }
                        }
                    }
                    
                }else{
                    $cek=explode('/',$_FILES['icon']['type']);
                    $file_tmp=$_FILES['icon']['tmp_name'];
                    $file=explode('.',$_FILES['icon']['name']);
                    $filename=md5(date('Ymdhis')).'.'.$file[1];
                    $lokasi='_file_upload/';
    
    
                    if($cek[0]=='image'){
                        if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                            $data           = Cuti::find($id);
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
