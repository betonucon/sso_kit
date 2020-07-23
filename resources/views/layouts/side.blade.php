<ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <li>
          <a href="{{url('/home')}}" style="font-weight: 500;">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>
        
        @if(Auth::user()['role_id']==1)
        
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Master Karyawan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/user')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Semua Unit</a></li>
                @foreach(role() as $un)
                  <li><a href="{{url('/user?role='.encode($un['id']))}}">&nbsp;&nbsp; <i class="fa fa-user"></i> {{$un['name']}}</a></li>
                @endforeach
              </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Profil</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/pengaturan?active=datadiri')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Data Diri</a></li>
                <li><a href="{{url('/pengaturan?active=slipgaji')}}">&nbsp;&nbsp; <i class="fa fa-money"></i> Slip Gaji</a></li>
                <li><a href="{{url('/pengaturan?active=kartu')}}">&nbsp;&nbsp; <i class="fa fa-address-card"></i> Kartu Nama</a></li>
              </ul>
          </li>
          <li>
            <a href="{{url('/inews')}}" style="font-weight: 500;">
              <i class="fa fa-newspaper-o"></i> <span>I-news</span>
            </a>
          </li>
          <li>
            <a href="{{url('/pengumuman')}}" style="font-weight: 500;">
              <i class="fa fa-paper-plane-o"></i> <span>Edaran</span>
            </a>
          </li>
          
        @endif   

        
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Cuti</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/cuti')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Pengajuan Cuti</a></li>
                <li><a href="{{url('/cuti/acc')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Pengajuan Acc</a></li>
              </ul>
          </li>

          @if(Auth::user()['role_id']==1)
            <li class="treeview">
                  <a href="#" style="background:#f9fafc;font-weight: 500;">
                    <i class="fa fa-folder"></i>
                    <span>Daftar Cuti</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="background:#f3f6fb">
                    <li><a href="{{url('cuti/admin')}}">&nbsp;&nbsp; <i class="fa fa-user"></i>Disetujui</a></li>
                    <li><a href="{{url('cuti/admin')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Ditolak</a></li>
                  </ul>
              </li>
          @else
            @if(cek_atasan_unitkerja()>0)
              <li class="treeview">
                  <a href="#" style="background:#f9fafc;font-weight: 500;">
                    <i class="fa fa-folder"></i>
                    <span>Persetujuan Cuti</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu" style="background:#f3f6fb">
                    <li><a href="{{url('cuti/persetujuan')}}">&nbsp;&nbsp; <i class="fa fa-user"></i>Persetujuan Cuti</a></li>
                    <li><a href="{{url('cuti/riwayat_cuti')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Pengajuan Acc</a></li>
                  </ul>
              </li>
            @endif
          @endif

        

       
        <!-- <li>
          <a href="{{url('/admin/news/')}}">
            <i class="fa fa-th"></i> <span>Rekapitulasi</span>
          </a>
        </li> -->
        <?php
          $kodebar=Auth::user()['nik'].'-'.Auth::user()['name'];
        ?>
        <li class="header" style="background: #ffffff;padding: 10%;"><center>{!!barcoderider($kodebar,3,3)!!} <br>{{Auth::user()['nik']}}<br>{{Auth::user()['name']}}</center></li>
      </ul>