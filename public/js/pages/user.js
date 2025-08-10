import apiClient from "/js/utils/apiClient.js";

const tableBody = document.getElementById("user-table-body");
const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const pageInfo = document.getElementById("page-info");

let page = 1;
let lastPage = 1;
let search = "";

function renderUsers(users) {
    tableBody.innerHTML = "";

    if (!users.length) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada data pengguna.</td>
            </tr>`;
        return;
    }

    users.forEach((user) => {
        const tr = document.createElement("tr");
        tr.className = "text-sm border-b";

        tr.innerHTML = `
             <td class="text-center py-2">
        <img 
            src="${
                user.profile ??
                "https://ui-avatars.com/api/?name=" +
                    encodeURIComponent(user.name) +
                    "&background=random&color=fff"
            }" 
            alt="Profile" 
            class="w-12 h-12 rounded-full shadow block mx-auto"
        />
    </td>
            <td class="py-2 text-center">${user.name}</td>
            <td class="py-2 text-center">${user.email}</td>
            <td class="text-center">
                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full
                    ${
                        user.role === "ADMIN"
                            ? "bg-blue-100 text-blue-800"
                            : user.role === "DOSEN"
                            ? "bg-yellow-100 text-yellow-800"
                            : user.role === "KAPRODI"
                            ? "bg-green-100 text-green-800"
                            : "bg-gray-100 text-gray-700"
                    }">
                    <i class="fas ${
                        user.role === "ADMIN"
                            ? "fa-user-shield"
                            : user.role === "DOSEN"
                            ? "fa-chalkboard-teacher"
                            : user.role === "KAPRODI"
                            ? "fa-user-tie"
                            : "fa-user"
                    }"></i>
                    ${user.role}
                </span>
            </td>
            <td class="text-center">
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                    ${
                        user.email_verified_at
                            ? "bg-green-100 text-green-800"
                            : "bg-gray-100 text-gray-700"
                    }">
                    ${user.email_verified_at ? "Verified" : "Unverified"}
                </span>
            </td>
             <td class="text-center">
            <div class="flex gap-2 justify-center">
                <button class="text-blue-500 hover:text-blue-700 cursor-pointer" title="Detail">
                    <i class="fas fa-eye"></i>
                </button>

                <a href="/users/${user.id}/edit" title="Edit">
                    <button class="text-yellow-500 hover:text-yellow-600 cursor-pointer">
                        <i class="fas fa-edit"></i>
                    </button>
                </a>

                <button onclick="handleDelete('${user.id}', '${
            user.name
        }')" class="text-red-500 hover:text-red-700 cursor-pointer" title="Hapus">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </td>
        `;
        tableBody.appendChild(tr);
    });
}

let userIdToDelete = null;

window.handleDelete = function (userId, userTitle) {
    const modalWrapper = document.getElementById("modal-wrapper");
    const modalForm = document.getElementById("modal-form");
    const modalTitleText = document.getElementById("modal-title");
    const modalMessageText = document.getElementById("modal-message");
    const modalButton = document.getElementById("modal-button");
    userIdToDelete = userId;

    if (!modalWrapper || !modalForm) return;

    modalForm.action = `/users/${userId}`;

    modalTitleText.innerText = "Hapus user";
    modalMessageText.innerText = `Apakah kamu yakin ingin menghapus user ${userTitle}?`;
    modalButton.innerText = "Hapus";

    window.dispatchEvent(new Event("open-modal"));
};

window.confirmDelete = async function () {
    try {
        await apiClient.delete(`/users/${userIdToDelete}`);

        window.dispatchEvent(new Event("close-modal"));

        const row = document
            .querySelector(`button[onclick*="${userIdToDelete}"]`)
            ?.closest("tr");

        if (row) row.remove();

        userIdToDelete = null;
    } catch (error) {
        alert("Terjadi kesalahan saat menghapus.");
    }
};

async function loadUsers() {
    try {
        const res = await apiClient.get("/users", {
            params: { page, search },
        });

        const { data: users, pagination } = res.data;

        renderUsers(users);
        console.log(users);

        pageInfo.textContent = `Page ${pagination.current_page} of ${pagination.last_page}`;
        lastPage = pagination.last_page;

        prevBtn.disabled = pagination.current_page === 1;
        nextBtn.disabled = pagination.current_page === pagination.last_page;

        const url = new URL(window.location);
        url.searchParams.set("page", page);
        window.history.replaceState({}, "", url);
    } catch (error) {
        console.error("Gagal memuat data pengguna:", error);
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-red-500 py-4">Gagal memuat data pengguna.</td>
            </tr>`;
    }
}
prevBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (page > 1) {
        page--;
        loadUsers();
    }
});

nextBtn.addEventListener("click", (e) => {
    e.preventDefault();
    if (page < lastPage) {
        page++;
        loadUsers();
    }
});

document.addEventListener("DOMContentLoaded", () => {
    loadUsers();
});

document.getElementById("search-form").addEventListener("submit", function (e) {
    e.preventDefault();
    search = document.getElementById("search-input").value.trim();
    page = 1;
    loadUsers();
});

document
    .getElementById("toggleImportForm")
    .addEventListener("click", function () {
        const formContainer = document.getElementById("importFormContainer");
        formContainer.classList.toggle("hidden");
    });

document
    .getElementById("importForm")
    .addEventListener("submit", async function (e) {
        e.preventDefault();
        const formData = new FormData();
        const fileInput = document.getElementById("excelFile");
        if (!fileInput.files.length) {
            alert("Harap pilih file Excel terlebih dahulu.");
            return;
        }

        formData.append("file", fileInput.files[0]);
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }

        console.log({ formData, fileInput });
        try {
            const response = await apiClient.post("/import-user", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            });

            const result = response.data;
            if (response.ok) {
                Swal.fire({
                    title: "Sukses!",
                    text: `Mahasiswa Berhasil di tambahkan`,
                    icon: "success",
                    timer: 2500,
                });
            } else {
                document.getElementById("message").textContent =
                    result.message || "Terjadi kesalahan saat import.";
                document
                    .getElementById("message")
                    .classList.add("text-red-600");
            }
        } catch (err) {
            console.log({ err });
            document.getElementById("message").textContent =
                "Gagal mengirim file.";
            document.getElementById("message").classList.add("text-red-600");
        }
    });
