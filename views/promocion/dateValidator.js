const startDateInput = document.getElementById('startDate');
const endDateInput = document.getElementById('endDate');

startDateInput.addEventListener('change', () => {
  const startDate = new Date(startDateInput.value);
  if (startDate) { 
    endDateInput.disabled = false; 
    const minEndDate = new Date(startDate);
    minEndDate.setDate(startDate.getDate() + 1); 
    endDateInput.min = minEndDate.toISOString().split('T')[0]; 
  } else {
    endDateInput.disabled = true; 
    endDateInput.value = ''; 
  }
});