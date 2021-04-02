@extends('template.template')


{{-- Tittle Page Website --}}
@section('tittleWeb', "Home")

{{-- Link Content --}}
@section('linkContent', "Home")


{{-- Content --}}
@section('content')

{{-- {{dd($arr_all_weeks[0]["pemasukan"])}} --}}

<br><br>
<div class="card">
    <div class="card-header border-0">
      <div class="d-flex justify-content-between">
        <h3 class="card-title">Grafik Keuangan Anda Dalam 4 Minggu</h3>
      </div>
    </div>
    <div class="card-body">
      <div class="d-flex">
        <p class="d-flex flex-column">
          <span class="text-bold text-lg">{{"Rp " . number_format($T_pemasukan - $T_pengeluaran,0,',','.')}}</span>
          <span>Total Uang Anda</span>
        </p>
        <p class="ml-auto d-flex flex-column text-right">
          {{-- Jika hijau atau pemasukan lebih besar --}}
          @if ($presentase_selisih > 1)
            <span class="text-success">
              <i class="fas fa-arrow-up"></i> {{$presentase_selisih}}%
            </span>
          @endif
          {{-- Jika merah atau pengeluaran lebih besar --}}
          @if ($presentase_selisih < 1 && $presentase_selisih != 0)
            <span class="text-danger">
              <i class="fas fa-arrow-down"></i> {{$presentase_selisih}}%
            </span>
          @endif
          {{-- Jika bernilai nol maka netral --}}
          @if ($presentase_selisih == 0)
            <span class="text-bold">
              Netral
            </span>
          @endif
          <span class="text-muted">Presentase Total Pemasukan dan Pengeluaran</span>
        </p>
      </div>
      <!-- /.d-flex -->

      <div class="position-relative mb-4">
        <canvas id="sales-chart" height="200"></canvas>
      </div>

      <div class="d-flex flex-row justify-content-end">
        <span class="mr-2">
          <i class="fas fa-square text-primary"></i> Pemasukan
        </span>

        <span>
          <i class="fas fa-square text-gray"></i> Pengeluaran
        </span>
      </div>
    </div>
  </div>

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

    /* global Chart:false */

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: ['Minggu-1', 'Minggu-2', 'Minggu-3', "Minggu-4"],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [ 
            {{$arr_all_weeks[0]['pemasukan']}} , 
            {{$arr_all_weeks[1]['pemasukan']}}, 
            {{$arr_all_weeks[2]['pemasukan']}}, 
            {{$arr_all_weeks[3]['pemasukan']}}
          ]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [ 
            {{$arr_all_weeks[0]['pengeluaran']}} , 
            {{$arr_all_weeks[1]['pengeluaran']}}, 
            {{$arr_all_weeks[2]['pengeluaran']}}, 
            {{$arr_all_weeks[3]['pengeluaran']}}
          ]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            // value pada parameter merujuk pada data grafik, jadi bersifat dinamis
            callback: function (value) {
              if (value >= 1000000) {
                value /= 1000000
                value += ' juta'
              } else if (value >= 1000){
                value /= 1000
                value += ' ribu'
              } else {
                value = 0
              }

              return 'Rp. ' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

});

</script>
@endpush