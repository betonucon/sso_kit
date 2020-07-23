@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
@media only screen and (min-width: 650px) {
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.9vw;
            font-family: sans-serif;
        }
    }
    @media only screen and (max-width: 649px) {
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            font-family: sans-serif;
        }
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <span  class="btn btn-primary btn-sm" data-toggle="modal" style="margin-bottom:2%" data-target="#modaltambah"   ><i class="fa fa-plus"></i> Tambah</span>
                        <table  id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul</th>
                                    <th width="30%">Isi</th>
                                    <th>Tujuan</th>
                                    <th>Waktu Update</th>
                                    <th>Upload By</th>
                                    <th width="5%"></th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(pengumuman() as $no=>$data)
                                <tr>
                                    <td>{{$no+1}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{!!substr($data->isi,0,200)!!}...... ..</td>
                                    <td>{{cek_unitkerja($data->unit_kerja_id)['name']}}</td>
                                    <td>{{$data->waktu}}</td>
                                    <td>{{$data->nik}}</td>
                                    <td><span class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalfile{{$data->id}}"><i class="fa fa-file-pdf-o"></i></td>
                                    <td>
                                        <span class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaledit{{$data->id}}"><i class="fa fa-pencil"></i></span>
                                        <span class="btn btn-danger btn-sm" onclick="hapus({{$data['id']}})"><i class="fa fa-remove"></i></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>
@foreach(pengumuman() as $no=>$data)
<div class="modal fade" id="modaledit{{$data->id}}" >
    <div class="modal-dialog" style="width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Inews </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi_edit{{$data->id}}"></div>
                <form method="post" id="myedit_simpan_data{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="form-group">
                            <label>Judul Edaran</label>
                            <input type="text"  name="name"  value="{{$data['name']}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tujuan Edaran</label>
                            <select  name="unit_kerja_id"  class="form-control">
                                @foreach(unitkerja() as $unit)
                                    <option value="{{$unit['id']}}" @if($data['unit_kerja_id']==$unit['id']) selected @endif >{{$unit['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategori Penyampaian</label>
                            <select  name="jenis"  class="form-control">
                                <option value="1" @if($data['jenis']==1) selected @endif>Buka Ke File Lampiran</option>
                                <option value="2" @if($data['jenis']==2) selected @endif>Buka Dari Aplikasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea id="textareas{{$data['id']}}" name="isi" class="form-control" style="height: 300px">{!!$data['isi']!!}</textarea>
                        </div>
                        
                        @if(is_null($data['file']) || $data['file']=='')
                            <div class="form-group">
                                <label>Lampiran</label>
                                <input type="file"  name="file"  class="form-control">
                            </div>
                        @else
                            <div class="form-group">
                                <label>Lampiran</label><br>
                                <div style="width:100px;height:100px">
                                    <img style="width:100px;height:100px" src="{{url('icon/'.$data['type'].'.png')}}">
                                </div>
                                <input type="hidden"  name="editicon" value="{{$data['file']}}"  class="form-control">
                                <input type="file"  name="file"  class="form-control">
                            </div>
                        @endif
                        
                    
                </form>
                <div style="width:100%;display:flex;">
                     <span id="edit_simpan_data{{$data->id}}" style="margin-right:2%" onclick="edit_simpan_data({{$data->id}})" class="btn btn-primary pull-left">Simpan</span>
                    <span id="tutup_edit_simpan_data{{$data->id}}" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                    <div style="width:100%;text-align:center" id="proses_loading_edit_simpan_data{{$data->id}}">
                    
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="modalfile{{$data->id}}" >
    <!-- <div class="modal-dialog modal-dialog-centered modal-lg" style="width:100%"> -->
    <div class="modal-dialog modal-lg" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="btn btn-danger btn-sm" aria-hidden="true">×</span></button>
                <h4 class="modal-title">Dokumen </h4>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <div class="form-group">
                        <label>Judul Edaran</label>
                        <input type="text"   value="{{$data['name']}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tujuan Edaran</label>
                        <input type="text"  value="{{cek_unitkerja($data['unit_kerja_id'])['name']}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Isi Edaran</label><br>
                        {!!$data['isi']!!}
                    </div>
                    @if($data['file']!='')
                        <div class="form-group">
                            <label>Lampiran</label><br>
                            <a href="{{url('_file_pengumuman/'.$data['file'])}}" target="_blank">{{$data['file']}}</a>
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="modaltambah" >
    <div class="modal-dialog" style="width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Pengumuman </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
                <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label>Judul Edaran</label>
                            <input type="text"  name="name"  class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tujuan Edaran</label>
                            <select  name="unit_kerja_id"  class="form-control">
                                @foreach(unitkerja() as $unit)
                                    <option value="{{$unit['id']}}">{{$unit['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategori Penyampaian</label>
                            <select  name="jenis"  class="form-control">
                                <option value="1">Buka Ke File Lampiran</option>
                                <option value="2">Buka Dari Aplikasi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea id="textarea" name="isi" class="form-control" style="height: 300px"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Lampiran</label>
                            <input type="file"  name="file"  class="form-control">
                        </div>
                </form>
                <div style="width:100%;display:flex;">
                     <span id="simpan_data" style="margin-right:2%" onclick="simpan_data()" class="btn btn-primary pull-left">Simpan</span>
                    <span id="tutup_simpan_data" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                    <div style="width:100%;text-align:center" id="proses_loading_simpan_data">
                    
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="modalnotif" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align:center">
                <h4 class="modal-title">Sukses Dihapus </h4>
                
                <div style="width:100%;display:flex;text-align:center">
                     <span  style="margin-right:2%" onclick="tutup()" class="btn btn-primary pull-left">OK</span>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('simpan')
<script>

    @foreach(pengumuman() as $no=>$data)
        $(function () {
            $("#textareas{{$data['id']}}").wysihtml5();
        });
    @endforeach

    $(function () {
        $("#textarea").wysihtml5();
    });
    $(function () {
        $('#example1').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        })
    });  
    function tutup(){
        location.reload();
    }
    function hapus(a){
        //$('#modalnotif').modal({backdrop: 'static', keyboard: false});
        $.ajax({
            type: 'GET',
            url: "{{url('/pengumuman/hapus')}}/"+a,
            data: "id="+a,
            success: function(msg){
                location.reload();
            }
        });
    }

    function simpan_data(){
        var form=document.getElementById('mysimpan_data');
        var a="{{$id}}";
            $.ajax({
                type: 'POST',
                url: "{{url('/pengumuman/simpan')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_data').hide();
                    $('#tutup_simpan_data').hide();
                    $('#proses_loading_simpan_data').html('Proses Data ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#simpan_data').show();
                        $('#tutup_simpan_data').show();
                        $('#proses_loading_simpan_data').html('');
                        $('#notifikasi').html(msg);
                    }
                    
                    
                }
            });

    } 

    function edit_simpan_data(a){
        var form=document.getElementById('myedit_simpan_data'+a);
        
            $.ajax({
                type: 'POST',
                url: "{{url('/pengumuman/edit')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#edit_simpan_data'+a).hide();
                    $('#tutup_edit_simpan_data'+a).hide();
                    $('#proses_loading_edit_simpan_data'+a).html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#edit_simpan_data'+a).show();
                        $('#tutup_edit_simpan_data'+a).show();
                        $('#proses_loading_edit_simpan_data'+a).html('');
                        $('#notifikasi_edit'+a).html(msg);
                    }
                    
                    
                }
            });

    } 
</script>
@endpush
