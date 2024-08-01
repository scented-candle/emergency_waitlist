document.addEventListener('DOMContentLoaded', function() {
    // 

    // Load patients data when the page loads
    loadPatients();
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


// Get the modals
var addPatientModal = document.getElementById('addPatientModal');
var checkOutPatientModal = document.getElementById('checkOutPatientModal');
var updateStatusModal = document.getElementById('updateStatusModal');

// Get the buttons that open the modals
var addPatientBtn = document.getElementById('addPatientButton');
var checkOutPatientBtn = document.getElementById('checkOutPatientButton');
var updateStatusBtn = document.getElementById('updateStatusButton')

// Get the <span> elements that close the modals
var addPatientSpan = addPatientModal.getElementsByClassName('close')[0];
var checkOutPatientSpan = checkOutPatientModal.getElementsByClassName('close')[0];
var updateStatusSpan = updateStatusModal.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal
addPatientBtn.onclick = function() {
    addPatientModal.style.display = 'block';
}
checkOutPatientBtn.onclick = function() {
    checkOutPatientModal.style.display = 'block';
}
updateStatusBtn.onclick = function() {
    updateStatusModal.style.display = 'block';
}

// When the user clicks on <span> (x), close the modal
addPatientSpan.onclick = function() {
    addPatientModal.style.display = 'none';
}
checkOutPatientSpan.onclick = function() {
    checkOutPatientModal.style.display = 'none';
}
updateStatusSpan.onclick = function() {
    updateStatusModal.style.display = 'none';
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == addPatientModal) {
        addPatientModal.style.display = 'none';
    }
    if (event.target == checkOutPatientModal) {
        checkOutPatientModal.style.display = 'none';
    }
    if (event.target == updateStatusModal) {
        updateStatusModal.style.display = 'none';
    }
}

// Handle add patient form submission
document.getElementById('addPatientForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way

    const formData = new FormData(this);

    fetch('/docs/php/add_patient.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {

        alert('Patient added successfully');
        addPatientModal.style.display = 'none';
        this.reset();
        loadPatients();

    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred');
    });
});

// Handle check-out patient form submission
document.getElementById('checkOutPatientForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    fetch('/docs/php/delete_patient.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Patient removed successfully');
        } else {
            alert(data.message || 'No patient found with the given ID');
        }
        checkOutPatientModal.style.display = 'none';
        this.reset();
        loadPatients();  
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred');
    });
});

document.getElementById('updateStatusForm').addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/docs/php/update_status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Patient status updated successfully');
            updateStatusModal.style.display = 'none';
            loadPatients(); 
        } else {
            alert('Error: ' + (data.message || 'An unexpected error occurred'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An unexpected error occurred');
    });
});

//Function to fetch patients data and populate the table
function loadPatients() { 
    // Fetch total wait time
    fetch('/docs/php/admin_total_waittime.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalWaitTime').innerText = data.total_wait_time;
        })
        .catch(error => {
            console.error('Error fetching total wait time:', error);
        });

    // Fetch and display patients
    fetch('/docs/php/get_patients.php')
        .then(response => response.json())
        .then(patients => {
            const tbody = document.getElementById('patientsTable').getElementsByTagName('tbody')[0];
            tbody.innerHTML = ''; // Clear existing rows

            patients.forEach(patient => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${patient.first_name}</td>
                    <td>${patient.last_name}</td>
                    <td>${patient.code}</td>
                    <td>${patient.check_in}</td>
                    <td>${patient.severity}</td>
                    <td>${patient.wait_time}</td>
                    <td>${patient.status}</td>
                `;

                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching patient data:', error);
        });
}
