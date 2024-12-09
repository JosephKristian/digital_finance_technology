@extends('layouts.sb-admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">

        {{-- // Menampilkan modal jika session umkm_approve bernilai false --}}
        @if (session('umkm_approve') == 1)
            <h1 class="h3 mb-4 text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-muted">Kami senang Anda bergabung dengan kami. Jelajahi dashboard Anda dan kelola data Anda dengan
                efisien.</p>

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
        const chartData = {
            sales: {
                label: 'Total Penjualan',
                data: [1200, 1500, 1800, 2000, 2400, 3000, 2500, 2700, 2900, 3200, 3500, 4000],
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
            },
            revenue: {
                label: 'Total Penerimaan',
                data: [2000, 2300, 2500, 3000, 3500, 4000, 3800, 3700, 4200, 4500, 4800, 5000],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
            },
            expenses: {
                label: 'Total Pengeluaran',
                data: [800, 900, 1000, 1200, 1400, 1600, 1500, 1600, 1700, 1800, 1900, 2000],
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
            },
            profit: {
                label: 'Keuntungan',
                data: [1200, 1400, 1500, 1800, 2100, 2400, 2300, 2100, 2500, 2700, 2900, 3000],
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
            },
        };

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

        // Render grafik pertama kali (default: Total Penjualan)
        renderChart('sales');
    </script>
@endsection
