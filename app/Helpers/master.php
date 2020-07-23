<?php

function aplikasi(){
    $data=App\Aplikasi::orderBy('name','Asc')->get();

    return $data;
}

function status_izin($id){
    $data=App\Statusizin::where('id',$id)->first();

    return $data;
}

function cek_atasan_unitkerja(){
    
    $data  = App\Unitkerja::where('nik_atasan', Auth::user()['nik'])->count();
     return $data;
}

function atasan_unitkerja(){
    // $data  = array_column(
    //     App\Unitkerja::select('kode_unit')->where('sts', 1)->groupBy('kode_unit')
    //     ->get()
    //     ->toArray(),'kode_unit'
    //  );
    $data  = array_column(
        App\Unitkerja::where('nik_atasan', Auth::user()['nik'])
        ->get()
        ->toArray(),'id'
     );
     return $data;
}

function cuti_karyawan_persetujuan(){
    $nik  = array_column(
        App\User::whereIn('unit_kerja_id', atasan_unitkerja())
        ->get()
        ->toArray(),'nik'
    );

    $data=App\Cuti::whereIn('nik',$nik)->where('sts',0)->where('kategori_id',1)->orderBy('tanggal_cuti','Desc')->get();

    return $data;
}

function cuti_karyawan_persetujuan_selesai(){
    $nik  = array_column(
        App\User::whereIn('unit_kerja_id', atasan_unitkerja())
        ->get()
        ->toArray(),'nik'
    );

    $data=App\Cuti::whereIn('nik',$nik)->where('kategori_id',1)->whereIn('sts',[1,2])->orderBy('tanggal_cuti','Desc')->get();

    return $data;
}

function cuti_admin($bulan,$tahun){
    $arr  = array_column(
        App\Cuti::select('nik')->where('kategori_id',1)->whereMonth('tanggal_cuti',$bulan)->whereYear('tanggal_cuti',$tahun)
        ->groupBy('nik')
        ->get()
        ->toArray(),'nik'
     );
     

    $data=App\User::whereIn('nik',$arr)->get();
    return $data;
}

function cuti_admin_detail($nik,$bulan,$tahun){
    $data=App\Cuti::where('sts',1)->where('kategori_id',1)->where('nik',$nik)->whereMonth('tanggal_cuti',$bulan)->whereYear('tanggal_cuti',$tahun)->count();

    return $data;
}
function get_cuti_admin_detail($nik,$bulan,$tahun){
    $data=App\Cuti::where('sts',1)->where('kategori_id',1)->where('nik',$nik)->whereMonth('tanggal_cuti',$bulan)->whereYear('tanggal_cuti',$tahun)->get();

    return $data;
}

function kategori_validasi(){
    $data='<option value="1">Setujui</option><option value="2">Tolak</option>';

    return $data;
}

function total_cuti_karyawan_persetujuan(){
    $nik  = array_column(
        App\User::whereIn('unit_kerja_id', atasan_unitkerja())
        ->get()
        ->toArray(),'nik'
    );

    $data=App\Cuti::whereIn('nik',$nik)->where('sts',0)->where('kategori_id',1)->orderBy('tanggal_cuti','Desc')->count();

    return $data;
}

function cuti_karyawan(){
    $data=App\Cuti::where('nik',Auth::user()['nik'])->where('sts',0)->where('kategori_id',1)->orderBy('tanggal_cuti','Desc')->get();

    return $data;
}

function cuti_karyawan_acc(){
    $data=App\Cuti::where('nik',Auth::user()['nik'])->whereIn('sts',[1,2,3])->where('kategori_id',1)->orderBy('tanggal_cuti','Desc')->get();

    return $data;
}

function sisa_cuti(){
    $masuk=App\Cuti::where('nik',Auth::user()['nik'])->whereIn('sts',[2,3])->where('kategori_id',1)->sum('jumlah');
    $keluar=App\Cuti::where('nik',Auth::user()['nik'])->whereIn('sts',[1,0])->where('kategori_id',1)->sum('jumlah');
    $data=$masuk-$keluar;

    return $data;
}

function sisa_cuti_bulanan($nik,$bulan,$tahun){
    $masuk=App\Cuti::where('nik',$nik)->whereIn('sts',[2,3])->where('kategori_id',1)->sum('jumlah');
    $keluar=App\Cuti::where('nik',$nik)->whereIn('sts',[1,0])->where('kategori_id',1)->whereMonth('tanggal_cuti',$bulan)->whereYear('tanggal_cuti',$tahun)->sum('jumlah');
    $data=$masuk-$keluar;

    return $data;
}

function waktu($id){
    $data=date('d-m-Y H:i:s',strtotime($id));

    return $data;
}

function cek_aplikasi($id){
    $data=App\Aplikasi::where('id',$id)->first();

    return $data;
}

function php_versi(){
    $data=App\Phpversi::all();

    return $data;
}

function inews_home(){
    $data=App\Inews::orderBy('id','Desc')->paginate(20);
    return $data;
}
function inews(){
    $data=App\Inews::orderBy('id','Desc')->get();

    return $data;
}

function cek_inews($id){
    $data=App\Inews::where('id',$id)->first();

    return $data;
}

function pengumuman_home(){
    $data=App\Pengumuman::orderBy('id','Desc')->paginate(20);

    return $data;
}

function pengumuman(){
    $data=App\Pengumuman::orderBy('id','Desc')->get();

    return $data;
}

function cek_pengumuman($id){
    $data=App\Pengumuman::where('id',$id)->first();

    return $data;
}

function unitkerja(){
    $data=App\Unitkerja::orderBy('id','Asc')->get();

    return $data;
}

function cek_unitkerja($id){
    $data=App\Unitkerja::where('id',$id)->first();

    return $data;
}

function cek_php($id){
    $data=App\Phpversi::where('id',$id)->first();

    return $data['name'];
}

function detail_user_aplikasi($nik){
    $data=App\Useraplikasi::where('nik',$nik)->get();

    return $data;
}

function cek_user_aplikasi($id,$nik){
    $data=App\Useraplikasi::where('aplikasi_id',$id)->where('nik',$nik)->count();

    return $data;
}

function cek_user($nik){
    $data=App\User::where('nik',$nik)->first();

    return $data;
}

function role(){
    $data=App\Role::all();

    return $data;
}

function user(){
    $data=App\User::all();

    return $data;
}

function user_data($role){
    if($role=='all'){
        $data=App\User::all();

    }else{
        $data=App\User::where('role_id',$role)->get();

    }
    
    return $data;
}



?>