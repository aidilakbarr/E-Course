import apiClient from "/js/utils/apiClient.js";

const tableBody = document.getElementById("matakuliah-table-body");
const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const pageInfo = document.getElementById("page-info");

let page = 1;
let lastPage = 1;
let search = "";

function rendermatakuliahs(matakuliahs) {
    tableBody.innerHTML = "";

    if (!matakuliahs?.length) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data dosen.</td>
            </tr>`;
        return;
    }

    matakuliahs.forEach((matakuliah) => {
        const tr = document.createElement("tr");
        tr.className = "text-sm border-b";

        tr.innerHTML = `
            <td class="py-2 text-center">${matakuliah.kode}</td>
            <td class="py-2 text-center">${matakuliah.nama}</td>
            <td class="py-2 text-center">${matakuliah.dosen?.user?.name}</td>
            <td class="py-2 text-center">${matakuliah.semester}</td>
            <td class="py-2 text-center">${matakuliah.kelas}</td>
            <td class="py-2 text-center">${matakuliah.ruangan}</td>
            <td class="py-2 text-center">${matakuliah.kapasitas}</td>
            <td class="text-center">
                <div class="flex justify-center gap-2">
                    <a href="/matakuliah/${matakuliah.id}/edit" title="Edit">
                        <button class="text-yellow-500 hover:text-yellow-600">
                            <i class="fas fa-edit"></i>
                        </button>
                    </a>
                    <button onclick="handleDelete('${matakuliah.id}', '${matakuliah.nama}')" class="text-red-500 hover:text-red-600" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        `;
        tableBody.appendChild(tr);
    });
}

let matakuliahIdToDelete = null;

window.handleDelete = function (matakuliahId, matakuliahName) {
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

window.confirmDelete = async function () {
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

async function loadmatakuliahs() {
    try {
        const res = await apiClient.get("/matakuliah", {
            params: { page, search },
        });

        console.log({ res });

        const pagination = res.data.data;
        const matakuliahs = pagination.data;

        rendermatakuliahs(matakuliahs);
        pageInfo.textContent = `Page ${pagination.current_page} of ${pagination.last_page}`;
        lastPage = pagination.last_page;

        prevBtn.disabled = pagination.current_page === 1;
        nextBtn.disabled = pagination.current_page === pagination.last_page;

        const url = new URL(window.location);
        url.searchParams.set("page", page);
        window.history.replaceState({}, "", url);
    } catch (error) {
        console.error("Gagal memuat data dosen:", error);
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-red-500 py-4">Gagal memuat data dosen.</td>
            </tr>`;
    }
}

prevBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (page > 1) {
        page--;
        loadmatakuliahs();
    }
});

nextBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (page < lastPage) {
        page++;
        loadmatakuliahs();
    }
});

document.addEventListener("DOMContentLoaded", () => {
    loadmatakuliahs();
});

// document.getElementById("search").addEventListener("submit", function (e) {
//     e.preventDefault();
//     search = document.getElementById("search-input").value.trim();
//     page = 1;
//     loadmatakuliahs();
// });
