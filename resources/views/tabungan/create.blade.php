@extends('template.template')


{{-- Tittle Page Website --}}
@section('tittleWeb', "Create")


{{-- Header Content --}}

{{-- Link Content --}}
@section('linkContent', "Create")


{{-- Content --}}
@section('content')
<br>
<div class="card card-warning  m-3">
    <div class="card-header">
      <h3 class="card-title"><br></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form action="{{route("saving.store")}}" method="post" class="ml-3 mr-3">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Pemasukan</label>
                    <input type="number" class="form-control col-5" name="pemasukan" value="{{old('pemasukan')}}">
                </div>
                <div class="form-group col-md-6">
                    <label>Pengeluaran</label>
                    <input type="number" class="form-control col-5" name="pengeluaran" value="{{old('pengeluaran')}}">
                </div>
                @error('pemasukan')
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p><i class="icon fas fa-ban"></i> {{$message}}</p>
                    </div>
                @enderror
              </div>

            <div class="form-group" class="row">
                <label>Deskripsi</label>
                <textarea class="form-control col-7" rows="3" placeholder="deskripsi pemasukan uang" name="deskripsi">{{old('deskripsi')}}</textarea>

                @error('deskripsi')
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p><i class="icon fas fa-ban"></i> {{$message}}</p>
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" class="form-control" rows="3" style="width: 400px" name="tanggal" value="{{old('tanggal')}}">

                @error('tanggal')
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <p><i class="icon fas fa-ban"></i> {{$message}}</p>
                    </div>
                @enderror
            </div>
            

            <button type="submit" class="btn btn-success">Tambah</button>
        </form>
    </div>

@endsection
