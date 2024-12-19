@extends('layouts.sb-admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        {{-- // Menampilkan modal jika session umkm_approve bernilai false --}}
        @if (session('umkm_approve') == 1)
            <h1 class="h3 mb-4 text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>

            @include('umkm.partials.cards')
            @include('umkm.partials.chart')

    </div>
    @endif

    @include('umkm.partials.verification_pages')


@endsection

<script src="{{ asset('js/verification.js') }}"></script>
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dummy untuk semua grafik
        // Data yang dikirim dari backend
        const dataFromBackend = @json($data);

        // Transformasikan data ke dalam format yang dibutuhkan Chart.js
        const chartData = {
            sales: {
                label: 'Total Penjualan',
                data: Object.values(dataFromBackend).map(item => item.sales), // Ambil nilai penjualan
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
            },
            revenue: {
                label: 'Total Penerimaan',
                data: Object.values(dataFromBackend).map(item => item.revenue), // Ambil nilai penerimaan
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
            },
            expenses: {
                label: 'Total Pengeluaran',
                data: Object.values(dataFromBackend).map(item => item.expenses), // Ambil nilai pengeluaran
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
            },
            profit: {
                label: 'Keuntungan',
                data: Object.values(dataFromBackend).map(item => item.profit), // Ambil nilai keuntungan
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
            },
        };

        // Debugging untuk memastikan data sudah sesuai
        console.log(chartData);

        // Inisialisasi Chart.js
        const ctx = document.getElementById('dynamicChart').getContext('2d');
        let currentChart = null;

        // Fungsi untuk menggambar grafik
        function renderChart(type) {
            // Hapus grafik sebelumnya jika ada
            if (currentChart) {
                currentChart.destroy();
            }

            // Buat grafik baru
            currentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                        'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: chartData[type].label,
                        data: chartData[type].data,
                        backgroundColor: chartData[type].backgroundColor,
                        borderColor: chartData[type].borderColor,
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan',
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah (Rp)',
                            },
                            ticks: {
                                // Callback untuk memformat nilai dalam format mata uang
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                },
                                stepSize: null, // Akan dihitung otomatis
                            },
                            afterDataLimits: (axis) => {
                                // Tentukan nilai tertinggi dari data
                                const maxData = Math.max(...chartData[type].data);

                                // Atur langkah skala (stepSize) secara dinamis
                                axis.ticks.stepSize = Math.ceil(maxData / 10 / 1000) *
                                    1000; // Contoh: jika max 45.000 -> stepSize = 5.000

                                // Usulkan nilai maksimum sedikit di atas nilai tertinggi data
                                axis.suggestedMax = Math.ceil(maxData / axis.ticks.stepSize) * axis.ticks
                                    .stepSize;
                            }
                        }
                    }
                }

            });
        }

        // Event listener untuk dropdown
        document.getElementById('chartSelector').addEventListener('change', function() {
            renderChart(this.value);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Render grafik pertama kali
            renderChart('sales');
        });
    </script>
@endsection
