function showToast(type) {
    const successToast = document.getElementById('toast-success');
    const errorToast = document.getElementById('toast-error');

    // Hide both toasts first
    successToast.classList.remove('show');
    successToast.classList.add('hidden');
    errorToast.classList.remove('show');
    errorToast.classList.add('hidden');

    // Show the selected toast
    if (type === 'success') {
        successToast.classList.remove('hidden');
        successToast.classList.add('show');
    } else if (type === 'error') {
        errorToast.classList.remove('hidden');
        errorToast.classList.add('show');
    }

    // Hide the toast after 3 seconds
    setTimeout(() => {
        if (type === 'success') {
            successToast.classList.remove('show');
            successToast.classList.add('hidden');
        } else if (type === 'error') {
            errorToast.classList.remove('show');
            errorToast.classList.add('hidden');
        }
    }, 3000);
}

// Example usage:
// Show success toast
showToast('success');

// Show error toast after 4 seconds
setTimeout(() => {
    showToast('error');
}, 4000);