@extends('layouts.sb-admin')

@section('title', 'Dashboard (SuperAdmin)')

@section('content')
    <div class="container-fluid">



        <!-- Card untuk memilih tahun -->
        <div class="card shadow mb-4" style="border-radius: 15px;">
            <div class="card-header bg-dark text-center" style="font-size: 1.25rem; color: #fff; font-weight: bold;">
                <h1 class="h3 mb-4 text-gray-800">{{ Auth::user()->name }}!</h1>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('dashboard-admin') }}" class="mb-4">
                    <div class="form-group row align-items-center">
                        <!-- Label dan Dropdown Tahun -->
                        <label for="year" class="col-sm-2 col-form-label font-weight-bold text-dark">Tahun:</label>
                        <div class="col-sm-3">
                            <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                                <!-- Menampilkan opsi tahun -->
                                @for ($i = 2020; $i <= 2030; $i++)
                                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Label dan Dropdown Bulan -->
                        <label for="month" class="col-sm-2 col-form-label font-weight-bold text-dark">Bulan:</label>
                        <div class="col-sm-3">
                            <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                                <!-- Menampilkan opsi bulan -->
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $monthInput == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <!-- Include other cards and chart -->
        @include('admin.partials.cards')
        @include('admin.partials.chart')

    </div>
@endsection

@section('script')
    <script>
        // Data dari backend
        const rawData = @json($data);

        // Proses data untuk grafik
        const processChartData = (dataKey) => {
            const labels = [];
            const datasets = [];

            Object.entries(rawData[dataKey]).forEach(([umkmId, umkmData]) => {
                // Ambil semua bulan sebagai label hanya sekali
                if (labels.length === 0) {
                    Object.keys(umkmData.data).forEach((month) => labels.push(month));
                }

                // Proses data fleksibel berdasarkan struktur data
                const dataForChart = labels.map((month) => {
                    const monthData = umkmData.data[month];

                    if (Array.isArray(monthData)) {
                        // Jika format array (seperti monthlySalesData)
                        return monthData.reduce(
                            (total, item) => total + parseInt(item.total_quantity || 0),
                            0
                        );
                    } else if (typeof monthData === 'number' || typeof monthData === 'string') {
                        // Jika format langsung (seperti monthlyNetProfits)
                        return parseFloat(monthData) || 0;
                    }

                    return 0; // Default jika data kosong
                });

                datasets.push({
                    label: umkmData.umkm_name || `UMKM ${umkmId}`,
                    data: dataForChart,
                    backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(
                    Math.random() * 255
                )}, ${Math.floor(Math.random() * 255)}, 0.5)`,
                    borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(
                    Math.random() * 255
                )}, ${Math.floor(Math.random() * 255)}, 1)`,
                    borderWidth: 1,
                });
            });

            return {
                labels,
                datasets,
            };
        };

        const netProfitData = processChartData('monthlyNetProfits');
        const salesData = processChartData('monthlySalesData');

        // Fungsi untuk menggambar chart
        const renderChart = (ctx, data, chartType) => {
            return new Chart(ctx, {
                type: chartType,
                data: {
                    labels: data.labels.map((label) =>
                        new Date(label + '-01').toLocaleString('default', {
                            month: 'long',
                            year: 'numeric',
                        })
                    ), // Ubah bulan ke nama panjang
                    datasets: data.datasets,
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        };

        // Render chart pada event 'DOMContentLoaded'
        document.addEventListener('DOMContentLoaded', () => {
            const chartCanvas = document.getElementById('dynamicChart').getContext('2d');
            let currentChart = renderChart(chartCanvas, netProfitData, 'bar');

            // Handle perubahan chart berdasarkan dropdown
            document.getElementById('chartSelector').addEventListener('change', function() {
                const selectedData = this.value === 'monthlyNetProfits' ? netProfitData : salesData;

                currentChart.destroy();
                currentChart = renderChart(chartCanvas, selectedData, 'bar');
            });
        });
    </script>



@endsection
