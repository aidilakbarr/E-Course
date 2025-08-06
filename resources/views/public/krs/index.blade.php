@extends('layouts.app')
@section('title', 'Add Course')

@section('content')

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div class="flex space-x-4">
                <button id="tab-pilih"
                    class="tab-btn text-blue-600 hover:text-blue-600 font-semibold border-b-2 border-blue-600">Pilih
                    Kelas</button>
                <button id="tab-terpilih" class="tab-btn text-gray-500 hover:text-blue-600">KRS Tersimpan</button>
            </div>
            <div id="sks-count" class="text-sm text-gray-600">Total SKS: 0</div>
        </div>

        <!-- Tabel Pilih Kelas -->
        <div id="panel-pilih">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-right">Aksi</th>
                        <th class="px-4 py-3">Nama Kelas</th>
                        <th class="px-4 py-3">Jadwal</th>
                        <th class="px-4 py-3">SKS</th>
                        <th class="px-4 py-3">Semester</th>
                    </tr>
                </thead>
                <tbody id="daftar-matkul">
                    <!-- Diisi via JS -->
                </tbody>
            </table>
            <div class="flex justify-between items-center mt-4 text-sm text-gray-700">
                <div id="info-selected">0 kelas dipilih, 0 SKS dari 24 SKS</div>
                <div>
                    <button onclick="simpanDraft()"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                        Simpan Draft
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabel KRS Tersimpan -->
        <div id="panel-terpilih" class="hidden">
            <table class="w-full text-sm text-left text-gray-600 border">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2">Nama Kelas</th>
                        <th class="px-4 py-2">Jadwal</th>
                        <th class="px-4 py-2">SKS</th>
                        <th class="px-4 py-2">Semester</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="krs-table-body">
                    <!-- Diisi via JS -->
                </tbody>
            </table>
            <div class="flex justify-between items-center mt-4 text-sm text-gray-700">
                <div id="info-selected">0 kelas dipilih, 0 SKS dari 24 SKS</div>
                <div>
                    <button onclick="simpanKRS()"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                        Simpan KRS
                    </button>
                </div>
            </div>
        </div>
        <!-- Info bar -->

    </div>



    <script type="module">
        import apiClient from '/js/utils/apiClient.js';
        const maxSKS = 24;
        const tabPilih = document.getElementById("tab-pilih");
        const tabTerpilih = document.getElementById("tab-terpilih");
        const panelPilih = document.getElementById("panel-pilih");
        const panelTerpilih = document.getElementById("panel-terpilih");
        const sksCount = document.getElementById("sks-count");
        const tableBody = document.getElementById("daftar-matkul");
        const infoBar = document.getElementById("info-selected");
        const checkAllBox = document.getElementById("check-all");
        let dataMatkul = [];
        let selectedMatkul = [];
        let krsTersimpan = [];

        tabPilih.onclick = () => {
            tabPilih.classList.add("text-blue-600", "border-blue-600", "border-b-2", "font-semibold");
            tabTerpilih.classList.remove("text-blue-600", "border-blue-600", "border-b-2", "font-semibold");
            tabTerpilih.classList.add("text-gray-500");
            panelPilih.classList.remove("hidden");
            panelTerpilih.classList.add("hidden");
        };

        tabTerpilih.onclick = () => {
            tabTerpilih.classList.add("text-blue-600", "border-blue-600", "border-b-2", "font-semibold");
            tabPilih.classList.remove("text-blue-600", "border-blue-600", "border-b-2", "font-semibold");
            tabPilih.classList.add("text-gray-500");
            panelPilih.classList.add("hidden");
            panelTerpilih.classList.remove("hidden");
        };

        function renderTable() {
            tableBody.innerHTML = "";

            dataMatkul.forEach((matkul) => {
                const row = document.createElement("tr");
                row.className = "border-b";

                const isChecked = selectedMatkul.includes(matkul.id);

                row.innerHTML = `
        <td class="px-3 py-2">
          <input type="checkbox" data-id="${matkul.id}" class="row-checkbox" ${isChecked ? "checked" : ""}/>
        </td>
        <td class="px-4 py-2">${matkul.nama}</td>
        <td class="px-4 py-2">${matkul.jadwal}</td>
        <td class="px-4 py-2">${matkul.sks}</td>
        <td class="px-4 py-2">${matkul.semester}</td>
      `;

                tableBody.appendChild(row);
            });

            updateInfoBar();
            addCheckboxListeners();

        }



        async function loadData() {
            try {
                const res = await apiClient.get('/krs/tersedia');
                const krs_tersimpan = await apiClient.get('/krs/terpilih');
                const rawData = res.data.data;
                const krsTersimpan = krs_tersimpan.data.data;
                const idsTersimpan = krsTersimpan.map(item => item.id);


                dataMatkul = rawData.
                filter(item => !idsTersimpan.includes(item.id)).
                map(item => ({
                    id: item.id,
                    nama: item.nama,
                    jadwal: `${item.hari}, ${item.jam_mulai.slice(0, 5)} - ${item.jam_selesai.slice(0, 5)}`,
                    sks: item.sks,
                    semester: item.semester
                }));

                renderTable();
            } catch (err) {
                alert('Gagal memuat data KRS.');
                console.error(err);
            }
        }


        function addCheckboxListeners() {
            const checkboxes = document.querySelectorAll(".row-checkbox");
            checkboxes.forEach((cb) => {
                cb.addEventListener("change", () => {
                    const id = parseInt(cb.dataset.id);
                    if (cb.checked) {
                        if (!selectedMatkul.includes(id)) selectedMatkul.push(id);
                    } else {
                        selectedMatkul = selectedMatkul.filter((i) => i !== id);
                    }
                    updateInfoBar();
                });
            });

        }

        function updateInfoBar() {
            const totalSKS = selectedMatkul.reduce((acc, id) => {
                const matkul = dataMatkul.find((m) => m.id === id);
                return acc + (matkul?.sks || 0);
            }, 0);
            infoBar.textContent = `${selectedMatkul.length} kelas dipilih, ${totalSKS} SKS dari ${maxSKS} SKS`;
        }

        async function renderTersimpan() {
            const krsBody = document.getElementById("krs-table-body");
            krsBody.innerHTML = "";
            const res = await apiClient.get('/krs/terpilih');
            const data = res.data.data
            console.log({
                res
            })
            data.forEach((item) => {
                const row = document.createElement("tr");
                row.className = "border-b";
                row.innerHTML = `
        <td class="px-3 py-2">
          <input type="checkbox"  />
        </td>
        <td class="px-4 py-2">${item.nama}</td>
        <td class="px-4 py-2">${item.jam_mulai} - ${item.jam_selesai}</td>
        <td class="px-4 py-2">${item.sks}</td>
        <td class="px-4 py-2">${item.semester}</td>
        <td class="px-4 py-2"> <button onclick="handleDelete('${item.id}', '${item.nama}')" class="text-red-500 hover:text-red-600" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                    </button></td>
      `;
                krsBody.appendChild(row);
            });
        };

        let matakuliahIdToDelete = null;


        window.handleDelete = function(matakuliahId, matakuliahName) {
            const modalWrapper = document.getElementById("modal-wrapper");
            const modalForm = document.getElementById("modal-form");
            const modalTitleText = document.getElementById("modal-title");
            const modalMessageText = document.getElementById("modal-message");
            const modalButton = document.getElementById("modal-button");

            matakuliahIdToDelete = matakuliahId;

            modalForm.action = `/lectures/${matakuliahId}`;
            modalTitleText.innerText = "Hapus matakuliah";
            modalMessageText.innerText = `Yakin ingin menghapus matakuliah "${matakuliahName}"?`;
            modalButton.innerText = "Hapus";

            window.dispatchEvent(new Event("open-modal"));
        };

        window.confirmDelete = async function() {
            try {
                await apiClient.delete(`/matakuliah/${matakuliahIdToDelete}`);

                window.dispatchEvent(new Event("close-modal"));

                const row = document
                    .querySelector(`button[onclick*="${matakuliahIdToDelete}"]`)
                    ?.closest("tr");
                if (row) row.remove();

                matakuliahIdToDelete = null;
            } catch (error) {
                alert("Terjadi kesalahan saat menghapus dosen.");
            }
        };


        window.simpanDraft = async function simpanDraft() {
            if (selectedMatkul.length === 0) {
                alert("Silakan pilih minimal 1 mata kuliah.");
                return;
            }

            const totalSKS = selectedMatkul.reduce((acc, id) => {
                const matkul = dataMatkul.find((m) => m.id === id);
                return acc + (matkul?.sks || 0);
            }, 0);

            if (totalSKS > maxSKS) {
                alert(`Total SKS melebihi batas maksimal (${maxSKS}).`);
                return;
            }

            const selectedData = dataMatkul.filter((m) => selectedMatkul.includes(m.id));
            console.log("Data matakuliah tersimpan:", selectedData);
            matakuliahTersimpan.push(selectedData);
            const selectedMatakuliahIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                .map(checkbox => checkbox.dataset.id);

            console.log({
                selectedMatakuliahIds
            });

            await apiClient.post('/krs/store', {
                matakuliah_ids: selectedMatakuliahIds
            })
        }

        function hapusKRS(nama) {
            krsTersimpan = krsTersimpan.filter(m => m.nama !== nama);
            renderTable();
        }

        renderTable();
        loadData()
        renderTersimpan();
    </script>


@endsection
