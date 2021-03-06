
@extends('layouts.adminmain')

@section('stylesheets')

  {!! Html::style('css/select2.min.css') !!}
  <style type="text/css">
    .select2-container {
        width: 100% !important;
        padding: 0;
    }
    .select2-results { 
      color: #FFF;
      background-color: #003961;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected]{
      color: #FFF;
      background-color: #F39C12;
    }
    .select2-container--default .select2-results__option[aria-selected=true]{
      color: #003961;
      background-color: #F39C12;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      color: #F39C12;
      background-color: #003961; 
    }
  </style>

@endsection

@section('content')
<section class="section">
  
  <div class="section-header">
    <h1>Perusahaan</h1>
  </div>

  @if ($message = Session::get('success'))
      <div class="card">
          <div class="card-body">
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
          </div>
      </div>
  @endif

  <div class="section-body">
    <div class="col-12 col-md-12 col-lg-12">
      <div class="card">
        <div class="card-header">
          <form method="GET" class="form-inline">
            <div class="form-group">
              <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request()->get('search') }}">
            </div>
            &nbsp;
            <div class="form-group">
              <button type="submit" class="btn btn-light"><i class="fas fa-search"></i></button>
            </div>
          </form>
          &nbsp;
          <a href="{{ route('perusahaan.index') }}" class="pull-right btn btn-outline-info">All Data</a>
        </div>
        <div class="card-header">
          <button id="btn_add" name="btn_add" type="button" data-toggle="modal" data-target="#addData" class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i> Tambah Perusahaan
          </button>
          &nbsp;
          <a class="btn btn-success" href="export_perusahaan"><i class="fa fa-print"></i> Export Data</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered ">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col"><center>Logo</center></th>
                  <th scope="col">Nama Perusahaan</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Email</th>
                  <th scope="col">Telepon</th>
                  <th scope="col"><center>Action</center></th>
                </tr>
              </thead>
              <tbody>
                 @forelse($data as $perusahaan)
                <tr>
                  <td width="5%">{{ ++$i }}</td>
                  <td><img width="120px" src="{{ url('/images/perusahaan/'.$perusahaan->perusahaan_logo) }}"></td>
                  <td>{{ $perusahaan->perusahaan_nama }}</td>
                  <td>{{ $perusahaan->perusahaan_alamat }}</td>
                  <td>{{ $perusahaan->perusahaan_email }}</td>
                  <td>{{ $perusahaan->perusahaan_telepon }}</td>

                  <td width="15%" align="center">
                    <div class="btn-group">
                      <a class="btn btn-sm btn-warning edit_modal color" href="{{ route('perusahaan.edit',$perusahaan->perusahaan_id) }}"><i class="fas fa-pen"></i></a>
                      <button class="btn btn-sm btn-info view_modal color" data-toggle="modal" data-target="#detailData{{$perusahaan->perusahaan_id}}"><i class="fas fa-eye"></i></button>
                      <a style="background-color: #c0c0c0; border-color: #c0c0c0;" class="btn btn-sm btn-secondary color open_modal" href="{{ route('perusahaan.show', $perusahaan->perusahaan_id) }}"><i class="fas fa-list"></i></a>
                      <button class="btn btn-sm btn-danger view_modal color" data-toggle="modal" data-target="#deleteData{{$perusahaan->perusahaan_id}}"><i class="fas fa-trash"></i></button>
                    </div> 
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7"><center>Data kosong</center></td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer text-right">
          <nav class="d-inline-block">
            {!! $data->appends(request()->except('page'))->render() !!}
          </nav>
        </div>
      </div>
    </div>  
  </div>
</section>

<!-- Modal ADD -->
  <div class="modal fade" id="addData" role="dialog" aria-labelledby="addData" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content"> 
        <form action="{{ route('perusahaan.store') }}" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="DataLabel"><i class="far fa-plus-square"></i>&nbsp; Tambah Data Perusahaan</h5>
          </div>
          <hr>
          <div class="modal-body">
            {{csrf_field()}}
            <div class="form-group">
              <label for="inputNamaPerusahaan" style="font-weight: bold;">
                Nama Perusahaan<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_nama" type="text" class="form-control" id="inputNamaPerusahaan" placeholder="Masukkan Nama Perusahaan" required="" style="font-weight: bold;">

              <label for="inputAlamatPerusahaan" style="font-weight: bold;">
                Alamat Perusahaan<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_alamat" type="text" class="form-control" id="inputAlamatPerusahaan" placeholder="Masukkan Alamat Perusahaan" required="" style="font-weight: bold;">

              <label for="inputEmailPerusahaan" style="font-weight: bold;">
                Email Perusahaan<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_email" type="text" class="form-control" id="inputEmailPerusahaan" placeholder="Masukkan Email Perusahaan" required="" style="font-weight: bold;">

              <label for="inputTeleponPerusahaan" style="font-weight: bold;">
                Telepon Perusahaan<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_telepon" type="text" class="form-control" id="inputTeleponPerusahaan" placeholder="Masukkan Telepon Perusahaan" required="" style="font-weight: bold;">

              <label for="inputJurusan" style="font-weight: bold;">
                Jurusan<i style="color: red;">*</i>
              </label>
              <select class="form-control select2-multi-add" name="jurusan[]" multiple="multiple">
                @foreach($jurusanData as $jurusan)
                  <option value="{{$jurusan->jurusan_id}}" class="form-control">{{$jurusan->jurusan_nama}}</option>
                @endforeach
              </select>

              <label for="perusahaan_logo" style="font-weight: bold;">
                Logo Perusahaan<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_logo" type="file" class="form-control" required="" style="font-weight: bold;">

              <label for="perusahaan_gambar1" style="font-weight: bold;">
                Gambar Perusahaan (1)<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_gambar1" type="file" class="form-control" required="" style="font-weight: bold;">

              <label for="perusahaan_gambar2" style="font-weight: bold;">
                Gambar Perusahaan (2)<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_gambar2" type="file" class="form-control" required="" style="font-weight: bold;">

              <label for="perusahaan_gambar3" style="font-weight: bold;">
                Gambar Perusahaan (3)<i style="color: red;">*</i>
              </label>
              <input name="perusahaan_gambar3" type="file" class="form-control" required="" style="font-weight: bold;">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Tambahkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- End of Modal Add -->

<!-- Modal DELETE -->
 @foreach($data as $perusahaan)
    <div class="modal fade" id="deleteData{{$perusahaan->perusahaan_id}}" role="dialog" aria-labelledby="deleteData" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content"> 
          <form action="{{route('perusahaan.destroy', $perusahaan->perusahaan_id)}}" method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="DataLabel"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> &nbsp; Konfirmasi Hapus</h5>
            </div>
            <hr>
            <div class="modal-body">
              <div class="form-group">
                <h5>
                  <br>
                    Yakin Ingin Menghapus <b>{{$perusahaan->perusahaan_nama}} - {{$perusahaan->perusahaan_alamat}}</b> ? 
                </h5>
              </div>
            </div>
            <div class="modal-footer">
              @csrf
              @method('DELETE')
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
<!-- End of Modal Delete-->

<!-- Modal DETAIL DATA -->
 @foreach($data as $perusahaan)
    <div class="modal fade" id="detailData{{$perusahaan->perusahaan_id}}" role="dialog" aria-labelledby="deleteData" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"> 
            <div class="modal-header">
              <h5 class="modal-title" id="DataLabel"><i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Detail Data - {{$perusahaan->perusahaan_nama}}</h5>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label style="font-weight: bold; font-size: 11pt;">
                    <i style="color: red;">*</i> Jurusan :
                  </label>
                  <div class="tags" style="margin-left: 10px;"> 
                    @foreach($perusahaan->jurusan as $jrsn)
                      <span style="background-color: #003961; margin-top: 5px;" class="badge badge-info">
                        {{ $jrsn->jurusan_nama}}
                      </span>
                    @endforeach
                  </div>
                  <br>
                  <label style="font-weight: bold; font-size: 11pt;">
                    <i style="color: red;">*</i> Gambar :
                  </label>
                  <div class="card-group">
                    <div class="card">
                      <img src="{{ url('/images/perusahaan/'.$perusahaan->perusahaan_gambar1) }}" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">{{$perusahaan->perusahaan_gambar1}}</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="{{ url('/images/perusahaan/'.$perusahaan->perusahaan_gambar2) }}" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">{{$perusahaan->perusahaan_gambar2}}</p>
                      </div>
                    </div>
                    <div class="card">
                      <img src="{{ url('/images/perusahaan/'.$perusahaan->perusahaan_gambar3) }}" class="card-img-top" alt="...">
                      <div class="card-body">
                        <p class="card-text">{{$perusahaan->perusahaan_gambar3}}</p>
                      </div>
                    </div>
                  </div> 
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
      </div>
    </div>
  @endforeach
<!-- End of Modal Detail Data-->

@endsection

@section('scripts')

  {!! Html::script('js/select2.min.js') !!}

  <script type="text/javascript">
    $(document).ready(function() {
      $('.select2-multi-add').select2();
    });
  </script>

@endsection