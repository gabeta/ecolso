import Swal from "sweetalert2"

export const toast = async function (icon, title) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true
    })

    await Toast.fire({
        icon,
        title
    })
}
