document.addEventListener('DOMContentLoaded', function() {
    fetch('get_patients.php')
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById('patientsTable');
            data.forEach(patient => {
                const row = table.insertRow();
                row.insertCell(0).innerText = patient.first_name;
                row.insertCell(1).innerText = patient.last_name;
                row.insertCell(2).innerText = patient.code;
                row.insertCell(3).innerText = patient.severity;
                row.insertCell(4).innerText = patient.wait_time;
                row.insertCell(5).innerText = patient.status;
                row.insertCell(6).innerHTML = '<button onclick="updateStatus(\'' + patient.code + '\')">Update Status</button>';
            });
        });
});

function updateStatus(patientCode) {
    const newStatus = prompt('Enter new status for patient with code ' + patientCode + ':');
    if (newStatus) {
        fetch('.../php/update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ code: patientCode, status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully!');
                location.reload(); // Reload the page to see the updated status
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating status.');
        });
    }
}

