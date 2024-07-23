document.addEventListener('DOMContentLoaded', function() {
    fetch('get_patient_info.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('welcomeMessage').innerText = 'Welcome ' + data.first_name + ' ' + data.last_name;
            document.getElementById('waitTime').innerText = data.wait_time;
        });
});