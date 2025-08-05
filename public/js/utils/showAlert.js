export function showAlert(title, message, type = "error") {
    Swal.fire({
        icon: type,
        title: title,
        text: message,
    });
}
