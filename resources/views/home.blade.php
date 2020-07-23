@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>


@media only screen and (min-width: 650px) {
        #inews{
            height: 510px;
            border: 1px dotted #fff;
            padding:0px 2px 0px 0px;
            overflow-y: scroll; /* Add the ability to scroll */
        }
        #inews::-webkit-scrollbar {
            display: none;
        }

        #inews {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.9vw;
            font-family: sans-serif;
        }
        #item{
            padding: 5px 0px 0px 0px;
            font-size: 0.8vw;
        }
        .apl{
            
            border: solid 1px #e2dbdb;
            width:130px;
            height:100px;
            text-align:center;
            display:grid;
            float:left;
            padding-top:1% ;
            margin:1%;
        }
        .modal-lg {
            width: 90%;
        }
        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            width:100%;
            height:500px;;
            margin: auto;
        }
        .icon-apl{
            width:60px;
            height:60px;
        }
        .lab{
            font-size:0.8vw;
        }
    }
    @media only screen and (max-width: 649px) {
        #inews{
            height: 510px;
            border: 1px dotted #fff;
            padding:0px 2px 0px 0px;
            overflow-y: scroll; /* Add the ability to scroll */
        }
        #inews::-webkit-scrollbar {
            display: none;
        }
        .modal-lg {
            width: 95%;
        }
        #inews {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            font-family: sans-serif;
        }
        #item{
            padding: 5px 0px 0px 0px;
            font-size: 3vw;
        }
        .apl{
            
            border: solid 1px #e2dbdb;
            width:85px;
            height:100px;
            padding-top:2%;
            margin-bottom:5%;
            text-align:center;
            display:grid;
            float:left;
            margin:2%;
        }
        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            width:100%;
            height:400px;;
            margin: auto;
        }
        .icon-apl{
            width:50px;
            height:50px;
        }
        .lab{
            font-weight:bold;
            font-size:3vw;
        }
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div style="margin-bottom:0px" class="box box-primary color-palette-box">
                <div class="box-header" style="background: #6d6db5;color: #fff;">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> PT Krakatau Information Technology</h3>
                </div>
                <div class="box-body" style="padding: 10px;">

                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @foreach(inews_home() as $no=>$data)
                                <li data-target="#myCarousel" data-slide-to="{{$no+1}}" class="@if($no==0)active @endif"></li>
                            @endforeach
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            
                            @foreach(inews_home() as $no=>$data)
                                <div class="item @if($no==0)active @endif">
                                    <img src="{{url('_file_inews/'.$data['background'])}}" alt="Chania" width="460" height="345">
                                    <div class="carousel-caption" style="background:#151510b3">
                                    <a href="#" style="color:#fff" data-toggle="modal" data-target="#modalfile{{$data->id}}"><h3>{{$data['name']}}</h3></a>
                                    <p>Posting {{$data['waktu']}}.</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Nex</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div style="margin-bottom:0px" class="box box-primary color-palette-box">
                <div class="box-header" style="background: #6d6db5;color: #fff;">
                    <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Inews</h3>
                </div>
                <div class="box-body" id="inews">
                
                    <ul class="products-list product-list-in-box">
                        @foreach(inews_home() as $no=>$data)
                            <li class="item" id="item">
                                <div class="product-img" data-toggle="modal" data-target="#modalfile{{$data->id}}">
                                    <img src="{{url('icon/download.png')}}" alt="Product Image">
                                </div>
                                <div class="product-info">
                                    <a href="#" data-toggle="modal" data-target="#modalfile{{$data->id}}" class="product-title">{{$data['name']}}
                                    <span class="product-description">
                                        <i class="fa fa-calendar-o"></i> {{waktu($data['waktu'])}}
                                    </span>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>



                </div>
            </div>
        </div>
    
    </div>
</section>


<section class="content">
    <div style="margin-bottom:0px" class="box box-primary color-palette-box">
        <div class="box-header" style="background: #6d6db5;color: #fff;">
            <h3 class="box-title"><i class="fa fa-tasks"></i> Aplikasi Web PT Krakatau Information Technology</h3>
        </div>
        <div class="box-body">
            <div class="row">
                
                @foreach(detail_user_aplikasi(Auth::user()['nik']) as $apl)
                    
                        <div class="apl" onclick="buka('{{cek_aplikasi($apl['aplikasi_id'])['link']}}',{{cek_aplikasi($apl['aplikasi_id'])['php_versi_id']}})">
                       
                            
                            <div class="lab">
                            <img src="{{url('_file_upload/'.cek_aplikasi($apl['aplikasi_id'])['icon'])}}" class="icon-apl"><br>
                            </div>
                            <div class="lab">{{cek_aplikasi($apl['aplikasi_id'])['singkatan']}}</div>
                            
                        </div>
                    
                @endforeach
                
            </div>
          
        </div>
        <!-- /.box-body -->
      </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div style="margin-bottom:0px" class="box box-primary color-palette-box">
                <div class="box-header" style="background: #6d6db5;color: #fff;">
                    <h3 class="box-title"><i class="fa fa-bullhorn"></i> Edaran</h3>
                </div>
                <div class="box-body" id="inews">
                    <ul class="products-list product-list-in-box">
                        @foreach(pengumuman_home() as $no=>$data)
                            <li class="item" id="item">
                                <div class="product-img" data-toggle="modal" data-target="#modalfilepengumuman{{$data->id}}">
                                    <img src="{{url('icon/pengumuman.png')}}" alt="Product Image">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalfilepengumuman{{$data->id}}" class="product-title">{{$data['name']}}
                                    <span class="product-description">
                                        <i class="fa fa-calendar-o"></i> {{waktu($data['waktu'])}}
                                    </span>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                        
                    </ul>
                   
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div style="margin-bottom:0px" class="box box-primary color-palette-box">
                <div class="box-header" style="background: #6d6db5;color: #fff;">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Berita Duka</h3>
                </div>
                <div class="box-body">
                sdasd
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div style="margin-bottom:0px" class="box box-primary color-palette-box">
                <div class="box-header" style="background: #6d6db5;color: #fff;">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Selamat Ulang Tahun</h3>
                </div>
                <div class="box-body">
                sdasd
                </div>
            </div>
        </div>
    
    </div>
</section>



    @foreach(inews_home() as $no=>$datanews)


        <div class="modal fade" id="modalfile{{$datanews->id}}" >
            <!-- <div class="modal-dialog modal-dialog-centered modal-lg" style="width:100%"> -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="btn btn-danger btn-sm" aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Dokumen </h4>
                    </div>
                    <div class="modal-body">
                            
                            <object id="object-pdf" class="object-pdf" data="{{url('_file_inews/'.$datanews->file)}}" type="application/pdf" width="100%" height="100%">
                                <p><i>Browser</i> yang Anda gunakan sepertinya tidak mendukung untuk menampilkan PDF secara langsung.</p><p>Jangan khawatir, Anda dapat mengunduh berita ini dengan melakukan <a href="{{url('_file_inews/'.$datanews->file)}}" download>klik disini.</a></p>
                            </object>
                    </div>
                    
                </div>
            </div>
        </div>
    @endforeach
    @foreach(pengumuman_home() as $no=>$data)


        <div class="modal fade" id="modalfilepengumuman{{$data->id}}" >
            <!-- <div class="modal-dialog modal-dialog-centered modal-lg" style="width:100%"> -->
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span class="btn btn-danger btn-sm" aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Edaran  </h4>
                    </div>
                    <div class="modal-body" style="background:#fff">
                        
                        
                        @if($data['jenis']==1)
                            
                            
                            <object id="object-pdf" class="object-pdf" data="{{url('_file_pengumuman/'.$data->file)}}" type="application/pdf" width="100%" height="100%">
                                <p><i>Browser</i> yang Anda gunakan sepertinya tidak mendukung untuk menampilkan PDF secara langsung.</p><p>Jangan khawatir, Anda dapat mengunduh berita ini dengan melakukan <a href="{{url('_file_pengumuman/'.$data->file)}}" download>klik disini.</a></p>
                            </object>
                        @endif

                        @if($data['jenis']==2)
                            <div class="form-group">
                                <label>Judul Edaran</label>: {{$data['name']}}
                                
                            </div>
                            <div class="form-group">
                                <label>Tujuan Edaran</label>: {{cek_unitkerja($data['unit_kerja_id'])['name']}}
                                
                            </div>
                            <div class="form-group">
                                <label>Isi Edaran</label><br>
                                <div style="width:100%;padding:10px;border:solid 1px #e0d3d3">
                                {!!$data['isi']!!}
                                </div>
                            </div>
                            @if($data['file']!='')

                            @else

                            @endif
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('simpan')
<script>
    function buka(link,php){
        if(php==1){
            window.location.assign(link+"?id={{base64_encode(Auth::user()['nik'])}}");
        }else{
            window.location.assign(link+"/a/{{base64_encode(Auth::user()['nik'])}}");
        }
        
    }
</script>
@endpush
