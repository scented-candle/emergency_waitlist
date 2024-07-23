document.addEventListener('DOMContentLoaded', function() {
    fetch('../php/get_patients.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#patientsTable tbody');
            data.forEach(patient => {
                const row = tableBody.insertRow();
                row.insertCell(0).innerText = patient.first_name;
                row.insertCell(1).innerText = patient.last_name;
                row.insertCell(2).innerText = patient.code;
                row.insertCell(3).innerText = patient.check_in;
                row.insertCell(4).innerText = patient.severity;
                row.insertCell(5).innerText = patient.wait_time;
                row.insertCell(6).innerText = patient.status;
                const actionsCell = row.insertCell(7);
                const updateButton = document.createElement('button');
                updateButton.innerText = 'Update Status';
                updateButton.onclick = function() {
                    updateStatus(patient.code);
                };
                const deleteButton = document.createElement('button');
                deleteButton.innerText = 'Delete';
                deleteButton.classList.add('delete');
                deleteButton.onclick = function() {
                    deletePatient(patient.code);
                };
                actionsCell.appendChild(updateButton);
                actionsCell.appendChild(deleteButton);
            });
        });
});

function updateStatus(patientCode) {
    const newStatus = prompt('Enter new status for patient with code ' + patientCode + ':');
    if (newStatus) {
        fetch('../php/update_status.php', {
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
                location.reload(); 
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

function deletePatient(patientCode) {
    if (confirm('Are you sure you want to delete the patient with code ' + patientCode + '?')) {
        fetch('../php/delete_patient.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ code: patientCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Patient deleted successfully!');
                location.reload(); // Reload the page to see the updated patient list
            } else {
                console.error('Error deleting patient:', data.message);
                alert('Failed to delete patient.');
            }
        })
        .catch(error => {
            console.error('Error deleting patient:', error);
            alert('An error occurred while deleting patient.');
        });
    }
}
