function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function openEditModal(type, id, firstName, lastName, phoneNumber, healthNumber, postalCode, country, address, city, specialty, email) {
    if (type === 'patient') {
        document.getElementById('editPatientID').value = id;
        document.getElementById('editFirstName').value = firstName;
        document.getElementById('editLastName').value = lastName;
        document.getElementById('editPhoneNumber').value = phoneNumber;
        document.getElementById('editHealthNumber').value = healthNumber;
        document.getElementById('editPostalCode').value = postalCode;
        document.getElementById('editCountry').value = country;
        document.getElementById('editAddress').value = address;
        document.getElementById('editCity').value = city;
        openModal('editPatientModal');
    } else if (type === 'doctor') {
        document.getElementById('editDoctorID').value = id;
        document.getElementById('editDoctorFirstName').value = firstName;
        document.getElementById('editDoctorLastName').value = lastName;
        document.getElementById('editDoctorPhoneNumber').value = phoneNumber;
        document.getElementById('editDoctorSpecialty').value = specialty;
        document.getElementById('editDoctorEmail').value = email;
        openModal('editDoctorModal');
    }
}

function openAvailabilityModal(doctorID, availability) {
    document.getElementById('availabilityDoctorID').value = doctorID;
    // Parse the availability string and pre-check the relevant checkboxes and select options
    const availabilityArray = availability.split(', ');
    availabilityArray.forEach(function(item) {
        const [day, times] = item.split(': ');
        const [start, end] = times.split('-');
        document.querySelector(`input[value="${day}"]`).checked = true;
        document.querySelector(`select[name="start_time_${day.toLowerCase()}"]`).value = start;
        document.querySelector(`select[name="end_time_${day.toLowerCase()}"]`).value = end;
    });
    openModal('editAvailabilityModal');
}

function openDetailsModal(data) {
    document.getElementById('modalAppointmentID').innerText = data.AppointmentID;
    document.getElementById('modalPatientName').innerText = data.PatientFirstName + ' ' + data.PatientLastName;
    document.getElementById('modalDoctorName').innerText = data.DoctorFirstName + ' ' + data.DoctorLastName;
    document.getElementById('modalAppointmentDate').innerText = data.AppointmentDate;
    document.getElementById('modalDetails').innerText = data.Details;
    document.getElementById('modalIsNewPatient').innerText = data.IsNewPatient ? 'Yes' : 'No';
    document.getElementById('modalPhoneNumber').innerText = data.PhoneNumber;
    document.getElementById('modalHealthNumber').innerText = data.HealthNumber;
    document.getElementById('modalPostalCode').innerText = data.PostalCode;
    document.getElementById('modalCountry').innerText = data.Country;
    document.getElementById('modalAddress').innerText = data.Address;
    document.getElementById('modalCity').innerText = data.City;
    
    openModal('detailsModal');
}

function openEditMedicineModal(id, name, manufacturer, expiryDate, quantity, price) {
    document.getElementById('editMedicineID').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editManufacturer').value = manufacturer;
    document.getElementById('editExpiryDate').value = expiryDate;
    document.getElementById('editQuantity').value = quantity;
    document.getElementById('editPrice').value = price;
    openModal('editMedicineModal');
}

function editBed(bedID, status, bedNumber) {
    document.getElementById('editBedID').value = bedID;
    document.getElementById('editBedNumber').value = bedNumber;
    document.getElementById('editStatus').value = status;
    openModal('editBedModal');
}

function deleteBed(bedID) {
    if (confirm('Are you sure you want to delete this bed?')) {
        window.location.href = 'delete_bed.php?bedID=' + bedID;
    }
}

// Close modals when clicking outside of them
window.onclick = function(event) {
    const modals = document.getElementsByClassName('modal');
    for (let i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = "none";
        }
    }
}

// Function to handle doctor availability update on change
function updateAvailability() {
    var availability = document.getElementById('doctor').selectedOptions[0].getAttribute('data-availability');
    var availableDays = availability.split(', ').map(function(dayTime) {
        return dayTime.split(': ')[0];
    });
    var appointmentDate = document.getElementById('appointmentDate');
    var currentDate = new Date();
    currentDate.setDate(currentDate.getDate() + 1); // Set to tomorrow for demo purposes

    // Reset date input
    appointmentDate.value = '';
    appointmentDate.setAttribute('min', currentDate.toISOString().split('T')[0]);

    var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var disabledDays = dayNames.filter(function(day) {
        return !availableDays.includes(day);
    });

    // Disable unavailable days
    appointmentDate.oninput = function() {
        var selectedDate = new Date(this.value);
        var selectedDay = dayNames[selectedDate.getUTCDay()];
        if (disabledDays.includes(selectedDay)) {
            alert('The selected doctor is not available on this day.');
            this.value = '';
        } else {
            updateTimeSlots();
        }
    };
}

function updateTimeSlots() {
    var appointmentDate = document.getElementById('appointmentDate').value;
    var doctor = document.getElementById('doctor');
    var availability = doctor.selectedOptions[0].getAttribute('data-availability');

    var availableTimes = [];
    if (appointmentDate) {
        var selectedDate = new Date(appointmentDate);
        var dayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][selectedDate.getUTCDay()];
        var availabilityArray = availability.split(', ');

        availabilityArray.forEach(function(item) {
            var [day, times] = item.split(': ');
            if (day === dayName) {
                availableTimes = times.split('-');
            }
        });
    }

    var appointmentTime = document.getElementById('appointmentTime');
    appointmentTime.innerHTML = '';

    if (availableTimes.length) {
        var [start, end] = availableTimes;
        var startHour = parseInt(start.split(':')[0]);
        var endHour = parseInt(end.split(':')[0]);

        for (var i = startHour; i < endHour; i++) {
            var timeOption = document.createElement('option');
            timeOption.value = i + ':00';
            timeOption.text = i + ':00';
            appointmentTime.add(timeOption);

            timeOption = document.createElement('option');
            timeOption.value = i + ':30';
            timeOption.text = i + ':30';
            appointmentTime.add(timeOption);
        }
    }
}

function deleteAppointment(appointmentID) {
    if (confirm('Are you sure you want to delete this appointment?')) {
        window.location.href = 'delete_appointment.php?appointmentID=' + appointmentID;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateAvailability();
});
