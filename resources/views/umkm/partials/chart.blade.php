<div class="mt-4">
    <div class="form-group">
        <label for="chartSelector">Pilih Grafik</label>
        <select id="chartSelector" class="form-control">
            <option value="sales">Total Penjualan</option>
            <option value="revenue">Total Penerimaan</option>
            <option value="expenses">Total Pengeluaran</option>
            <option value="profit">Keuntungan</option>
        </select>
    </div>

    <!-- Canvas untuk grafik -->
    <canvas id="dynamicChart" style="width: 100%; max-height: 500px;"></canvas>

</div>
