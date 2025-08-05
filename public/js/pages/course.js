import apiClient from "/js/utils/apiClient.js";

const tableBody = document.getElementById("course-table-body");

function createCourseRow(course, isAdmin) {
    return `
    
        <tr class="bg-white border-b border-gray-200 text-sm text-gray-900">
            <td class="px-4 py-2 whitespace-nowrap">
                <img src="${
                    !course.thumbnail ||
                    course.thumbnail ===
                        "http://localhost:8000/storage/default.jpg"
                        ? `/images/default-profile.png`
                        : `${course.thumbnail}`
                }" alt="Course Thumbnail"
                    class="w-32 h-32 object-cover rounded-md" />
            </td>
            <td class="px-4 py-2 text-center whitespace-nowrap font-medium">
                ${course.title}
            </td>
            ${
                isAdmin
                    ? `
                    <td class="px-4 py-2 whitespace-nowrap">
                        ${course.instructor?.name ?? "-"}
                    </td>
            <td class="px-4 py-2 whitespace-normal max-w-[250px]">
                ${course.description ?? "-"}
            </td>`
                    : ""
            }
            <td class="px-4 py-2 text-center whitespace-nowrap">
                <a href="/courses/${course.id}/lessons"
                    class="text-indigo-600 hover:underline">Lihat Lessons</a>
            </td>
            <td class="px-4 py-2 text-center whitespace-nowrap">
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                    ${
                        course.status === "AKTIF"
                            ? "bg-green-200 text-green-800"
                            : "bg-red-200 text-red-800"
                    }">
                    ${course.status}
                </span>
            </td>
            <td class="gap-4 items-center py-2">
                <a href="/courses/${course.id}/edit">
                    <button class="bg-yellow-400 hover:bg-yellow-500 font-semibold mb-2 py-2 rounded-lg shadow-lg hover:shadow-xl flex items-center justify-center px-6 text-white cursor-pointer">
                        <i class="fas fa-edit mr-3"></i> Edit Course
                    </button>
                </a>
                <button onclick="handleDelete('${course.id}', '${
        course.title
    }')"
                    class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i> Hapus Course
                </button>
            </td>
        </tr>
    `;
}

let courseIdToDelete = null;

window.handleDelete = function (courseId, courseTitle) {
    const modalWrapper = document.getElementById("modal-wrapper");
    const modalForm = document.getElementById("modal-form");
    const modalTitleText = document.getElementById("modal-title");
    const modalMessageText = document.getElementById("modal-message");
    const modalButton = document.getElementById("modal-button");
    courseIdToDelete = courseId;

    if (!modalWrapper || !modalForm) return;

    modalForm.action = `/courses/${courseId}`;

    modalTitleText.innerText = "Hapus Course";
    modalMessageText.innerText = `Apakah kamu yakin ingin menghapus course ${courseTitle}?`;
    modalButton.innerText = "Hapus";

    window.dispatchEvent(new Event("open-modal"));
};

window.confirmDelete = async function () {
    try {
        await apiClient.delete(`/courses/${courseIdToDelete}`);

        window.dispatchEvent(new Event("close-modal"));

        const row = document
            .querySelector(`button[onclick*="${courseIdToDelete}"]`)
            ?.closest("tr");

        if (row) row.remove();

        courseIdToDelete = null;
    } catch (error) {
        alert("Terjadi kesalahan saat menghapus.");
    }
};

let lastPage = 1;
const urlParams = new URLSearchParams(window.location.search);
let page = parseInt(urlParams.get("page")) || 1;
let search = urlParams.get("search") || "";

async function loadCourses() {
    try {
        const response = await apiClient.get(`/courses`, {
            params: {
                page,
                search,
            },
        });

        const paginated = response.data.pagination;
        const courses = response.data.data;
        const isAdmin = response.data.user?.role === "ADMIN";
        console.log({ courses, paginated, isAdmin });

        tableBody.innerHTML = courses.length
            ? courses.map((course) => createCourseRow(course, isAdmin)).join("")
            : `<tr><td colspan="8" class="px-5 py-5 text-center text-sm">Tidak ada data</td></tr>`;

        lastPage = paginated.last_page;
        document.getElementById(
            "page-info"
        ).textContent = `Page ${paginated.current_page} of ${paginated.last_page}`;
        document.getElementById("prev-btn").disabled =
            paginated.prev_page_url === null;
        document.getElementById("next-btn").disabled =
            paginated.next_page_url === null;

        const newUrl = new URL(window.location);
        newUrl.searchParams.set("page", page);
        if (search) {
            newUrl.searchParams.set("search", search);
        } else {
            newUrl.searchParams.delete("search");
        }
        window.history.replaceState({}, "", newUrl);
    } catch (error) {
        tableBody.innerHTML = `<tr><td colspan="8" class="px-5 py-5 text-center text-sm text-red-500">${error.response.data.message}</td></tr>`;
    }
}

document.getElementById("prev-btn").addEventListener("click", (e) => {
    e.preventDefault();
    if (page > 1) {
        page--;
        loadCourses();
    }
});

document.getElementById("next-btn").addEventListener("click", (e) => {
    e.preventDefault();
    if (page < lastPage) {
        page++;
        loadCourses();
    }
});

document.getElementById("search-form").addEventListener("submit", (e) => {
    e.preventDefault();
    search = document.getElementById("search-input").value.trim();
    page = 1;
    loadCourses();
});

const roleSelect = document.getElementById("roleFilter");
const statusSelect = document.getElementById("statusFilter");
const instructorSelect = document.getElementById("instructorFilter");

function appendOptions(selectElement, items, valueKey = null, labelKey = null) {
    items.forEach((item) => {
        const option = document.createElement("option");
        option.value = valueKey ? item[valueKey] : item;
        option.textContent = labelKey ? item[labelKey] : item;
        selectElement.appendChild(option);
    });
}

async function loadEnumsFromAPI() {
    try {
        const filters = await apiClient.get("/filters");
        const instructors = await apiClient.get("/instructors");

        appendOptions(
            instructorSelect,
            instructors.data.data.instructor,
            "id",
            "name"
        );
        appendOptions(roleSelect, filters.data.roles);
        appendOptions(statusSelect, filters.data.statuses);
    } catch (err) {
        console.error("Gagal memuat enum:", err);
    }
}

document.getElementById("applyFilter").addEventListener("click", async () => {
    const role = roleSelect.value;
    const status = statusSelect.value;
    const instructor = instructorSelect.value;

    const params = new URLSearchParams();
    if (role) params.append("role", role);
    if (status) params.append("status", status);
    if (instructor) params.append("instructor_id", instructor);

    try {
        const res = await apiClient.get(
            `/courses/filtering?${params.toString()}`
        );

        console.log({ res });
        const courses = res.data.data;
        const isAdmin = true;

        tableBody.innerHTML =
            Array.isArray(courses) && courses.length
                ? courses
                      .map((course) => createCourseRow(course, isAdmin))
                      .join("")
                : `<tr><td colspan="8" class="px-5 py-5 text-center text-sm">Tidak ada data</td></tr>`;

        const newUrl = new URL(window.location);
        newUrl.searchParams.set("page", 1);
        if (role) newUrl.searchParams.set("role", role);
        else newUrl.searchParams.delete("role");

        if (status) newUrl.searchParams.set("status", status);
        else newUrl.searchParams.delete("status");

        if (instructor) newUrl.searchParams.set("instructor_id", instructor);
        else newUrl.searchParams.delete("instructor_id");

        newUrl.searchParams.delete("search");

        window.history.replaceState({}, "", newUrl);
    } catch (error) {
        console.error("Gagal ambil data filter:", error);
        tableBody.innerHTML = `<tr><td colspan="8" class="px-5 py-5 text-center text-sm text-red-500">Gagal memuat data course (filter)</td></tr>`;
    }
});

document.addEventListener("DOMContentLoaded", async () => {
    await loadEnumsFromAPI();
    loadCourses();
});
