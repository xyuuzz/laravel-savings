@extends('template.template')


{{-- Tittle Page Website --}}
@section('tittleWeb', "Tabungan")

{{-- Link Content --}}
@section('linkContent', "Tabungan")


{{-- Content --}}
@section('content')
<br>
{{-- Alert pemberitahun tambah hapus dan update data --}}
<?php $id = 1; ?>


<br><br>

<div class="container-fluid" >
    <!-- Small boxes (Stat box) -->
    <div class="row">
        {{-- Pemasukan --}}
        <div class="col-lg-3 col-6 container">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{"Rp " . number_format($T_pemasukan,0,',','.')}}</h3>
                    <h5>Total Pemasukan</h5>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        {{-- Pengeluaran --}}
        <div class="col-lg-3 col-6 container">
            <!-- small box -->
            <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{"Rp " . number_format($T_pengeluaran,0,',','.')}}</h3>

                <h5>Total Pengeluaran</h5>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            </div>
        </div>
        {{-- Total --}}
        <div class="col-lg-3 col-6 container">
            <!-- small box -->
            <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{"Rp " . number_format($T_pemasukan - $T_pengeluaran,0,',','.')}}</h3>

                <h5>Total Uang</h5>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            </div>
        </div>
    </div>
</div>
{{-- Tombol tambah Data --}}
<a type="button" class="btn btn-primary  m-3 ml-md-3 float-left" href="{{ route('saving.create')}}">Tambah Data</a>
<br>
    @if ( count($Table) )
        
    @endif
    {{-- Bagian Table --}}
    <table id="example1" class="table table-bordered table-striped">
    <thead>
        <th>No</th>
        <th class="center">Edit</th>
        <th>Pemasukan</th>
        <th>Pengeluaran</th>
        <th>Deskripsi</th>
        <th>Tanggal</th>
    </thead>
    <tbody>
        @foreach ($Table as $data)
        <tr>
            <td>{{ $id++ }}</td> {{--- ini adalah nomor table ---}}
            
            <td> {{--- ini adalah button edit dll table ---}}
                <a type="button" class="btn btn-warning m-1" href="{{ route('saving.edit', ['saving' => $data->id]) }}">Edit</a>
                <form action="{{ route('saving.destroy', ['saving' => $data->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Delete" class="btn btn-danger m-1">
                </form>
            </td> 
            <td>
                @if ( $data->pemasukan )
                    {{"Rp " . number_format($data->pemasukan,0,',','.')}}
                    @else
                        -
                @endif
            </td>
            <td>
                @if ( $data->pengeluaran )
                    {{"Rp " . number_format($data->pengeluaran,0,',','.')}}
                    @else
                        -
                    @endif
            </td>
            <td>{{ $data->deskripsi }}</td>
            <td>{{$data->tanggal}}</td>
        </tr>
        @endforeach

    </tbody>
</table>


@endsection

@push('script_table')
<script>
    $(function () {
      $("#example1").DataTable({
         "responsive": true, "lengthChange": false, "autoWidth": false,
      }).buttons().container().appendTo('#example1 .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });

</script>
@endpush