const startDateInput = document.getElementById('start_time');
const endDateInput = document.getElementById('end_time');

endDateInput.disabled = true;

function formatDate(date) {
    return date.toISOString().split('T')[0];
}

startDateInput.addEventListener('change', () => {
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (startDate) {
        endDateInput.disabled = false;

        const minEndDate = new Date(startDate);
        minEndDate.setDate(startDate.getDate() + 1);
        endDateInput.min = formatDate(minEndDate);

        if (endDate && endDate <= startDate) {
            endDateInput.value = formatDate(minEndDate);
        }
    } else {
        endDateInput.disabled = true;
        endDateInput.value = '';
    }
});

endDateInput.addEventListener('change', () => {
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);

    if (endDate && endDate <= startDate) {
        const minEndDate = new Date(startDate);
        minEndDate.setDate(startDate.getDate() + 1);
        endDateInput.value = formatDate(minEndDate);
    }
});