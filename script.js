document.addEventListener("DOMContentLoaded", function () {
    fetchUsers();
});

function fetchUsers() {
    fetch("fetch_and_update_users.php")
        .then(response => response.json())
        .then(data => {
            const userTable = document.getElementById("userData");
            userTable.innerHTML = ""; // Clear existing rows

            data.forEach(user => {
                const row = document.createElement("tr");
                row.dataset.id = user.id; // Set user ID for later reference
                row.innerHTML = `
                    <td><input type="text" name="username" value="${user.username}" disabled></td>
                    <td><input type="text" name="full_email" value="${user.full_email}" disabled></td>
                    <td><input type="text" name="user_role" value="${user.user_role}" disabled></td>
                    <td><input type="text" name="no_tel" value="${user.no_tel}" disabled></td>
                    <td>
                        <button class="edit-button" onclick="enableEditing(this)">Edit</button>
                        <button class="save-button" onclick="saveChanges(${user.id})" disabled>Save</button>
                    </td>
                `;
                userTable.appendChild(row);
            });
        })
        .catch(error => showPopup("Error fetching user data."));
}

function enableEditing(button) {
    const row = button.closest("tr");
    row.querySelectorAll("input").forEach(input => input.disabled = false);
    row.querySelector(".save-button").disabled = false;
}

function saveChanges(userId) {
    const row = document.querySelector(`tr[data-id="${userId}"]`);
    const username = row.querySelector("input[name='username']").value;
    const full_email = row.querySelector("input[name='full_email']").value;
    const user_role = row.querySelector("input[name='user_role']").value;
    const no_tel = row.querySelector("input[name='no_tel']").value;

    console.log("Saving changes for user:", { userId, username, full_email, user_role, no_tel }); // Debugging

    fetch("fetch_and_update_users.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: userId, username, full_email, user_role, no_tel })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showPopup("User details updated successfully.");
            fetchUsers(); // Refresh the user data
        } else {
            showPopup("Failed to update user details.");
        }
    })
    .catch(error => showPopup("Error updating user data."));
}

function showPopup(message) {
    const popup = document.createElement("div");
    popup.className = "popup";
    popup.innerText = message;
    document.body.appendChild(popup);

    setTimeout(() => {
        popup.remove();
    }, 3000); // Remove popup after 3 seconds
}

function viewFormDetails(formId) {
    console.log('Form ID:', formId);  // Check if formId is correctly passed

    fetch(`fetch_form_details.php?id=${formId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const formDetails = document.getElementById('formDetails');
                formDetails.textContent = JSON.stringify(data.form, null, 2);
                showPopup("viewPopup");
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error fetching form details:', error));
}
// Function to fetch form data and display it
function fetchFormData() {
    fetch('fetch_and_display_forms.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const formTable = document.getElementById('formTable');
                formTable.innerHTML = '';

                data.forms.forEach(form => {
                    const row = document.createElement('tr');
                    const statusClass = getStatusClass(form.status);
                    row.innerHTML = `
                        <td>${form.id}</td>
                        <td>${form.perkakasan}</td>
                        <td>${form.other_answer}</td>
                        <td>${form.username}</td>
                        <td>${form.jenis_permintaan}</td>
                        <td>${form.keutamaan}</td>
                        <td>${form.tarikh_diperlukan}</td>
                        <td>${form.hari}</td>
                        <td>${form.keterangan_permohonan}</td>
                        <td>${form.created_at}</td>
                        <td>
                            <select class="status-dropdown" onchange="updateStatus(${form.id}, this.value)">
                                <option value="Pending" ${form.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="In Progress" ${form.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                <option value="Completed" ${form.status === 'Completed' ? 'selected' : ''}>Completed</option>
                            </select>
                        </td>
                        <td>
                            <button class="update-button ${statusClass}" onclick="updateFormStatus(${form.id})">Update</button>
                        </td>
                    `;
                    formTable.appendChild(row);
                });
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error fetching form data:', error));
}

// Function to get the class based on status
function getStatusClass(status) {
    if (status === 'Pending') return 'status-pending';
    if (status === 'In Progress') return 'status-in-progress';
    if (status === 'Completed') return 'status-completed';
    return '';
}

// Function to update the status of a form
function updateStatus(formId, newStatus) {
    console.log("Sending data:", { id: formId, status: newStatus }); // Log the data to inspect

    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: formId,
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status updated successfully');
        } else {
            alert('Failed to update status');
        }
    })
    .catch(error => console.error('Error updating status:', error));
}

// Function to trigger the status update from the update button click
function updateFormStatus(formId) {
    const statusDropdown = document.querySelector(`#formTable tr:nth-child(${formId}) .status-dropdown`);
    const status = statusDropdown.value;
    updateStatus(formId, status); // Send the update request with the form ID and new status
}

// Fetch form data when the page loads
window.onload = fetchFormData;

fetch('update_status.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        id: formId,         // formId: The ID of the form
        status: newStatus   // newStatus: The updated status value
    })
})

// Fetch user data and populate the table
function fetchUsers() {
    fetch('fetch_and_update_users.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tableBody = document.getElementById('usersTableBody');
                tableBody.innerHTML = '';
                data.users.forEach((user, index) => {
                    // Automatically assign the sequential ID based on the index
                    tableBody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td> <!-- Sequential ID -->
                            <td contenteditable="true" onblur="updateUserField(${user.id}, 'username', this.textContent)">${user.username}</td>
                            <td contenteditable="true" onblur="updateUserField(${user.id}, 'email', this.textContent)">${user.full_email}</td>
                            <td contenteditable="true" onblur="updateUserField(${user.id}, 'user_role', this.textContent)">${user.user_role}</td>
                            <td contenteditable="true" onblur="updateUserField(${user.id}, 'no_tel', this.textContent)">${user.no_tel}</td>
                            <td class="button-container">
                                <button class="edit-btn" onclick="saveUserChanges(${user.id})">Save</button>
                                <button class="delete-btn" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                alert(data.message || 'Failed to fetch users.');
            }
        });
}

function saveUserChanges(userId) {
    // Find the row corresponding to the userId
    const row = document.querySelector(`tr td:first-child`).parentElement;
    const updatedData = {
        id: userId,
        username: row.cells[1].textContent.trim(),
        email: row.cells[2].textContent.trim(),
        user_role: row.cells[3].textContent.trim(),
        no_tel: row.cells[4].textContent.trim(),
    };

    fetch('fetch_and_update_users.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(updatedData),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User updated successfully.');
                fetchUsers(); // Refresh the table to reflect changes
            } else {
                alert(data.message || 'Failed to update user.');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to save user changes
function saveUserChanges(userId) {
    const row = document.getElementById('user-' + userId);
    const username = row.querySelector('.username').innerText;
    const fullEmail = row.querySelector('.full-email').innerText;
    const userRole = row.querySelector('.user-role').innerText;
    const noTel = row.querySelector('.no-tel').innerText;

    fetch('update_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: userId,
            username: username,
            full_email: fullEmail,
            user_role: userRole,
            no_tel: noTel
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User data saved successfully!');
        } else {
            alert('Failed to save user data.');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Function to delete a user
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch('delete_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('User deleted successfully!');
                document.getElementById('user-' + userId).remove();
            } else {
                alert('Failed to delete user.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

fetch('update_user.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        id: 1,
        username: "newusername",
        full_email: "newemail@example.com",
        user_role: "admin",
        no_tel: "123456789"
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.log('Error:', error));

// Function to update user data
function saveUserChanges(userId) {
    const row = document.querySelector(`tr td:first-child`).parentElement;
    const updatedData = {
        id: userId,
        username: row.cells[1].textContent,
        email: row.cells[2].textContent,
        user_role: row.cells[3].textContent,
        no_tel: row.cells[4].textContent,
    };

    // Ensure POST method is used
    fetch('fetch_and_update_users.php', {
        method: 'POST', // This should be POST
        headers: { 
            'Content-Type': 'application/json' 
        },
        body: JSON.stringify(updatedData) // Sending data as JSON
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('User updated successfully.');
            fetchUsers(); // Refresh table
        } else {
            alert(data.message || 'Failed to update user.');
        }
    })
    .catch(error => console.error('Error:', error));
}
document.getElementById('addUserForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get form data
    const username = document.getElementById('newUsername').value;
    const email = document.getElementById('newEmail').value;
    const role = document.getElementById('newRole').value;
    const status = document.getElementById('newStatus').value;

    // Send data via AJAX
    $.ajax({
        url: 'add_user.php',
        type: 'POST',
        data: {
            username: username,
            email: email,
            role: role,
            status: status
        },
        success: function(response) {
            alert(response);
            closeModal('addUserModal');
            // Optionally, refresh the user table here
        }
    });
});

document.getElementById('editUserForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get form data
    const username = document.getElementById('editUsername').value;
    const role = document.getElementById('editRole').value;
    const status = document.getElementById('editStatus').value;

    // Send data via AJAX to update user
    $.ajax({
        url: 'edit_user.php',
        type: 'POST',
        data: {
            username: username,
            role: role,
            status: status
        },
        success: function(response) {
            alert(response);
            closeModal('editUserModal');
            // Optionally, refresh the user table here
        }
    });
});

function deleteUser() {
    const username = document.getElementById('editUsername').value;

    // Send delete request via AJAX
    $.ajax({
        url: 'delete_user.php',
        type: 'POST',
        data: { username: username },
        success: function(response) {
            alert(response);
            closeModal('deleteConfirmationModal');
            // Optionally, refresh the user table here
        }
    });
}

// AJAX to add a new user
$('#addUserForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: 'add_user.php',
        type: 'POST',
        data: {
            username: $('#newUsername').val(),
            email: $('#newEmail').val(),
            role: $('#newRole').val(),
            status: $('#newStatus').val()
        },
        success: function(response) {
            alert(response);
            location.reload(); // Optionally reload the page or update the table
        }
    });
});

// AJAX to edit user information
$('#editUserForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: 'edit_user.php',
        type: 'POST',
        data: {
            username: $('#editUsername').val(),
            role: $('#editRole').val(),
            status: $('#editStatus').val()
        },
        success: function(response) {
            alert(response);
            location.reload(); // Optionally reload the page or update the table
        }
    });
});

// AJAX to delete a user
function deleteUser(username) {
    $.ajax({
        url: 'delete_user.php',
        type: 'POST',
        data: { username: username },
        success: function(response) {
            alert(response);
            location.reload(); // Optionally reload the page or update the table
        }
    });
}

function validateCheckboxes() {
    var checked = document.querySelectorAll('input[name="jenis-permintaan[]"]:checked').length;
    if (checked == 0) {
        alert("Please select at least one 'Jenis Permintaan'.");
        return false;
    }
    return true;
}

function validateForm() {
    var program = document.getElementById('program').value;
    if (program === "") {
        alert("Please fill in the 'Program' field.");
        return false;
    }
    // Add similar checks for other fields as needed
    return true;
}

var checkboxes = document.getElementsByName("perkakasan[]");
for (var i = 0; i < checkboxes.length; i++) {
    if (!checkboxes[i].checked) {
        // Do something
    }
}

fetch('fetch_forms.php')
    .then(response => response.json())
    .then(data => {
        console.log(data); // Display forms in console
        // Dynamically populate table or UI
    })
    .catch(error => console.error('Error fetching forms:', error));

    document.addEventListener('DOMContentLoaded', function () {
        // Fetch the form data from fetch_forms.php
        fetch('fetch_forms.php')
            .then(response => response.json())
            .then(data => {
                // Find the table body where rows will be inserted
                const tableBody = document.getElementById('form1-table-body');
                tableBody.innerHTML = ''; // Clear any existing rows
    
                // Check if data was returned
                if (Array.isArray(data) && data.length > 0) {
                    // Loop through the data and create rows
                    data.forEach(form => {
                        const row = `
                            <tr>
                                <td>${form.id}</td>
                                <td>${form.username}</td>
                                <td>${form.form_type}</td>
                                <td>${form.tarikh_diperlukan}</td>
                                <td>${form.keutamaan}</td>
                                <td>${form.created_at}</td>
                            </tr>
                        `;
                        // Append the row to the table body
                        tableBody.innerHTML += row;
                    });
                } else {
                    // If no data is found, display a message
                    tableBody.innerHTML = '<tr><td colspan="6">No forms found.</td></tr>';
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    });
    
    document.addEventListener("DOMContentLoaded", function() {
        // Fetch form data when the page loads
        fetch('fetch_form_data.php')
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                console.log(data); // Log the data to check if it's correct
    
                const tableBody = document.querySelector('#formsTable tbody');
                tableBody.innerHTML = ''; // Clear any existing content in the table
    
                if (data.length > 0) {
                    // Loop through the forms and create rows
                    data.forEach(form => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${form.id}</td>
                            <td>${form.username}</td>
                            <td>${form.form_type}</td>
                            <td>${form.tarikh_diperlukan}</td>
                            <td>${form.keutamaan}</td>
                            <td>${form.created_at}</td>
                            <td>${form.status}</td>
                        `;
                        tableBody.appendChild(row); // Add the row to the table
                    });
                } else {
                    // If no data is available, display a message
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="7">No forms available.</td>';
                    tableBody.appendChild(row);
                }
            })
            .catch(error => {
                console.error('Error fetching form data:', error);
            });
    });
    
    fetch('manage_forms.php', {
        method: 'POST',  // Ensure the method is POST
        body: new FormData(form),  // Or your data payload
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => console.error('Error:', error));

    document.getElementById('loadFormsButton').addEventListener('click', function () {
        const formType = document.getElementById('formTypeSelect').value;
        
        if (!formType) {
            alert('Please select a form type!');
            return; // Prevent the AJAX request from being sent if no form type is selected
        }
    
        fetchForms(formType);
    });

    // Validate before submitting via JavaScript
document.querySelector('form').addEventListener('submit', function(e) {
    var isValid = true;

    // Your validation logic goes here

    if (!isValid) {
        e.preventDefault();  // Prevent form submission if invalid
    }
});

fetch('fetch_forms.php')
    .then(response => response.json())
    .then(data => {
        console.log('Response Data:', data); // Log the response to see the error or success
        const formsContainer = document.getElementById('formsContainer');
        formsContainer.innerHTML = '';

        if (data.error) {
            formsContainer.innerHTML = `<p class="error-message">${data.error}</p>`;
        } else {
            const table = document.createElement('table');
            table.classList.add('form-table');
            let headerRow = '<tr><th>Form ID</th><th>Perkakasan</th><th>Jenis Permintaan</th><th>Keutamaan</th><th>Date Required</th><th>Description</th><th>Created At</th></tr>';
            table.innerHTML = headerRow;

            data.forEach(form => {
                let row = `<tr>
                    <td>${form.id}</td>
                    <td>${form.perkakasan || 'N/A'}</td>
                    <td>${form.jenis_permintaan || 'N/A'}</td>
                    <td>${form.keutamaan || 'N/A'}</td>
                    <td>${form.tarikh_diperlukan || 'N/A'}</td>
                    <td>${form.keterangan_permohonan || 'N/A'}</td>
                    <td>${form.created_at}</td>
                </tr>`;
                table.innerHTML += row;
            });

            formsContainer.appendChild(table);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const formsContainer = document.getElementById('formsContainer');
        formsContainer.innerHTML = `<p class="error-message">An error occurred: ${error.message}</p>`;
    });

    document.addEventListener("DOMContentLoaded", () => {
        fetch('manage_forms.php') // Fetch data from your backend
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('formData');
                tbody.innerHTML = ''; // Clear existing rows
    
                data.forms.sort((a, b) => a.id - b.id); // Sort forms by ID (ascending order)
    
                data.forms.forEach((form, index) => {
                    const row = document.createElement('tr');
    
                    row.innerHTML = `
                        <td>${index + 1}</td> <!-- Sequential numbering -->
                        <td>${form.username}</td>
                        <td>${form.form_type}</td>
                        <td>${form.tarikh_diperlukan}</td>
                        <td>${form.keutamaan}</td>
                        <td>
                            <select class="status-select" data-id="${form.id}">
                                <option value="Pending" ${form.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="In Progress" ${form.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                <option value="Completed" ${form.status === 'Completed' ? 'selected' : ''}>Completed</option>
                            </select>
                        </td>
                        <td><button class="update-status" data-id="${form.id}">Update</button></td>
                    `;
    
                    tbody.appendChild(row);
                });
    
                attachUpdateListeners();
            })
            .catch(() => {
                openPopup("Error", "Failed to load form data.");
            });
    });
    
    // Attach update status listeners
    function attachUpdateListeners() {
        document.querySelectorAll('.update-status').forEach(button => {
            button.addEventListener('click', event => {
                const id = event.target.getAttribute('data-id');
                const status = document.querySelector(`.status-select[data-id="${id}"]`).value;
    
                fetch('update_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id, status })
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            openPopup("Success", result.message);
                        } else {
                            openPopup("Error", result.message);
                        }
                    })
                    .catch(() => {
                        openPopup("Error", "Failed to update status.");
                    });
            });
        });
    }

    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: formId, // ID of the form you're updating
            status: newStatus // The new status you want to set
        })
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));

    const formData = {
        id: 123, // The ID of the form
        status: "Completed" // The new status
    };
    
    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Ensure Content-Type is set to application/json
        },
        body: JSON.stringify(formData) // Send the data as a JSON string
    })
    .then(response => response.json())
    .then(data => console.log(data)) // Log the response from the server
    .catch(error => console.error('Error:', error));

    const formType = 'borang_ict1'; // Replace with your desired form type
fetch(`fetch_forms.php?form_type=${formType}`)
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));

    // Fetch the users from manage_users.php
fetch('manage_users.php')
.then(response => response.json())
.then(data => {
    if (data.success) {
        let users = data.users;
        let usersList = document.getElementById('usersList');
        usersList.innerHTML = ''; // Clear existing data

        // Loop through users and populate the table
        users.forEach(user => {
            let row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.full_name}</td>
                <td>${user.email}</td>
                <td>${user.user_role}</td>
                <td>${user.no_tel}</td>
                <td>
                    <button onclick="editUser(${user.id})">Edit</button>
                    <button onclick="deleteUser(${user.id})">Delete</button>
                </td>
            `;
            usersList.appendChild(row);
        });
    } else {
        alert('Error fetching users.');
    }
})
.catch(error => {
    console.error('Error:', error);
});
fetch('register.php', {
    method: 'POST',
    body: new FormData(formElement)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        window.location.href = data.redirect_url;
    } else {
        alert(data.message);
    }
});

document.querySelector('form').addEventListener('submit', function (e) {
    const fields = document.querySelectorAll('[required]');
    let allValid = true;

    fields.forEach(field => {
        if (!field.value.trim()) {
            allValid = false;
            field.style.borderColor = 'red';
        } else {
            field.style.borderColor = '';
        }
    });

    if (!allValid) {
        e.preventDefault();
        alert('Please fill in all required fields.');
    }
});

fetch('update_status.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        id: formId,            // ID of the form
        status: newStatus,     // New status (e.g., 'Pending', 'In Progress', etc.)
        form_type: 'FORM 1'    // Form type (e.g., FORM 1, FORM 2, or FORM 3)
    })
})
.then(response => response.json())
.then(data => {
    console.log(data.message);
})
.catch(error => {
    console.error('Error:', error);
});

document.addEventListener("DOMContentLoaded", () => {
    // Set initial form type (form1)
    loadFormData('form1');

    // Add event listener to form selector
    document.getElementById('formSelector').addEventListener('change', (event) => {
        const formType = event.target.value;
        loadFormData(formType); // Fetch data for selected form type
    });
});

function loadFormData(formType) {
    fetch(`manage_forms.php?form_type=${formType}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('formData');
            tbody.innerHTML = ''; // Clear previous data
            if (data.success && data.forms.length > 0) {
                data.forms.forEach((form, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td> <!-- Dynamically generated index -->
                        <td>${form.username}</td>
                        <td>${form.form_type}</td>
                        <td>${form.tarikh_diperlukan}</td>
                        <td>${form.keutamaan}</td>
                        <td>
                            <select class="status-select" data-id="${form.id}">
                                <option value="Pending" ${form.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="In Progress" ${form.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                <option value="Completed" ${form.status === 'Completed' ? 'selected' : ''}>Completed</option>
                            </select>
                        </td>
                        <td><button class="action-btn update-status" data-id="${form.id}">Update</button></td>
                    `;
                    tbody.appendChild(row);
                });
                addUpdateListeners();
            } else {
                tbody.innerHTML = '<tr><td colspan="7">No forms found.</td></tr>';
            }
        })
        .catch(() => {
            alert('Failed to load data!');
        });
}

fetch('update_status.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'  // Ensure the request's content-type is set to application/json
    },
    body: JSON.stringify({
        id: 123,  // Replace with the actual ID
        status: 'In Progress',  // Replace with the actual status
        form_type: 'FORM 1'  // Replace with the actual form type (FORM 1, FORM 2, etc.)
    })
})
.then(response => response.json())
.then(data => console.log('Success:', data))
.catch((error) => console.error('Error:', error));

fetch('update_status.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        id: 1, // Example ID
        status: 'In Progress',
        form_type: 'FORM 1', // Example Form Type
    }),
})
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data);
        if (data.success) {
            alert('Status updated successfully.');
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => console.error('Fetch Error:', error));

    fetch('update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: 1, // Replace with the actual ID
            status: 'In Progress', // Replace with the actual status
            form_type: 'FORM 1', // Replace with the actual form type
        }),
    })
        .then(response => response.json())
        .then(data => console.log('Response:', data))
        .catch(error => console.error('Error:', error));

        function updateStatus(id, status, formType) {
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: id,
                    status: status,
                    form_type: formType,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log('Success:', data.message);
                        alert('Status updated successfully!');
                    } else {
                        console.error('Error:', data.message);
                        alert('Failed to update status: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Fetch Error:', error);
                    alert('An error occurred while updating status.');
                });
        }
        
        // Example usage:
        // updateStatus(1, 'In Progress', 'FORM 1');
        fetch('update_form.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: 1,
                status: 'Completed'
            })
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    
        fetch(`delete_user.php?username=${username}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the user row from the table
                event.target.closest('tr').remove();
                alert('User deleted successfully.');
            } else {
                alert(data.message || 'Failed to delete user.');
            }
        })
        .catch(() => {
            alert('Failed to delete user.');
        });

        function loadUserData() {
            fetch('manage_users.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const tbody = document.getElementById('userData');
                    tbody.innerHTML = '';
                    if (data.success && data.users.length > 0) {
                        data.users.forEach((user, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${user.username}</td>
                                <td>${user.full_email}</td>
                                <td>${user.no_tel}</td>
                                <td>${user.user_role}</td>
                                <td><button class="action-btn delete-user" data-id="${user.id}">Delete</button></td>
                            `;
                            tbody.appendChild(row);
                        });
                        addDeleteListeners(); // Attach delete button listeners
                    } else {
                        tbody.innerHTML = '<tr><td colspan="6">No users found.</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching user data:', error); // Log detailed error
                    alert('Failed to load user data!'); // Show error to the user
                });
        }
        function addUpdateListeners() {
            document.querySelectorAll('.update-status').forEach(button => {
                button.addEventListener('click', event => {
                    const id = event.target.getAttribute('data-id');
                    const status = document.querySelector(`.status-select[data-id="${id}"]`).value;
                    fetch('update_script.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id, status }),
                    })
                    .then(response => response.json())
                    .then(result => {
                        console.log(result);  // Log result to debug
                        if (result.success) {
                            showPopup('Success', result.message);
                        } else {
                            showPopup('Error', result.message);
                        }
                    })
                    .catch(() => {
                        showPopup('Error', 'Unable to update status.');
                    });
                });
            });
        }
        function addUpdateListeners() {
            document.querySelectorAll('.update-status').forEach(button => {
                button.addEventListener('click', event => {
                    const id = event.target.getAttribute('data-id');
                    const status = document.querySelector(`.status-select[data-id="${id}"]`).value;
                    const formType = document.getElementById('formSelector').value;  // Get the selected form type
        
                    // Log the data to ensure it's being sent correctly
                    console.log({ id, status, form_type: formType });
        
                    fetch('update_script.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id, status, form_type: formType }), // Send form_type as well
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            showPopup('Success', result.message);
                        } else {
                            showPopup('Error', result.message);
                        }
                    })
                    .catch(() => {
                        showPopup('Error', 'Unable to update status.');
                    });
                });
            });
        }
        $.ajax({
            url: "update_script.php", // Replace with your script URL
            type: "POST",
            contentType: "application/json", // Ensure JSON content type
            data: JSON.stringify({
                id: 1,
                status: "In Progress",
                form_type: "borang_ict1"
            }),
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

        // Function to fetch and display the forms
function fetchForms() {
    fetch('fetch_forms.php') // Your PHP endpoint to fetch forms
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#formsTable tbody');
            tableBody.innerHTML = ''; // Clear existing rows

            data.forms.forEach(form => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${form.id}</td>
                    <td>${form.form_type}</td>
                    <td>${form.status}</td>
                    <td><button onclick="openUpdateModal(${form.id}, '${form.form_type}', '${form.status}')">Update</button></td>
                `;
                tableBody.appendChild(row);
            });
        });
}

// Function to open the modal for updating status
function openUpdateModal(formId, formType, currentStatus) {
    document.getElementById('formId').value = formId;
    document.getElementById('status').value = currentStatus;
    document.getElementById('updateStatusModal').style.display = 'block';
}

// Function to close the modal
function closeModal() {
    document.getElementById('updateStatusModal').style.display = 'none';
}

// Function to update the status via the API
document.getElementById('updateStatusForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formId = document.getElementById('formId').value;
    const status = document.getElementById('status').value;
    const formType = "borang_ict1"; // This can be dynamically set based on the form (e.g., borang_ict2, borang_ict3)

    const requestData = {
        id: formId,
        status: status,
        form_type: formType
    };

    fetch('update_script.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                fetchForms(); // Refresh the table
                closeModal();
            } else {
                alert(data.message);
            }
        });
});

// Fetch the forms initially
fetchForms();

// Function to add delete listeners to the delete buttons
function addDeleteListeners() {
    document.querySelectorAll('.delete-form').forEach(button => {
        button.addEventListener('click', event => {
            const id = event.target.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this form?')) {
                fetch('delete_form.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id }),
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            event.target.closest('tr').remove(); // Remove the row from the table
                            showPopup('Success', result.message);
                        } else {
                            showPopup('Error', result.message);
                        }
                    })
                    .catch(() => {
                        showPopup('Error', 'Unable to delete form.');
                    });
            }
        });
    });
}

console.log(`Updating form with ID: ${id}, New Status: ${status}`);
console.log(result);

function loadFormData(formType) {
    fetch(`manage_forms.php?form_type=${formType}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('formData');
            tbody.innerHTML = ''; // Clear existing rows
            if (data.success && data.forms.length > 0) {
                data.forms.forEach((form, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${form.username}</td>
                        <td>${form.tarikh_diperlukan}</td>
                        <td>${form.keutamaan}</td>
                        <td>
                            <select class="status-select" data-id="${form.id}">
                                <option value="Pending" ${form.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="In Progress" ${form.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                <option value="Completed" ${form.status === 'Completed' ? 'selected' : ''}>Completed</option>
                            </select>
                        </td>
                        <td><button class="action-btn update-status" data-id="${form.id}">Update</button></td>
                        <td><button class="action-btn delete-form" data-id="${form.id}">Delete</button></td>
                    `;
                    tbody.appendChild(row);
                });
                addUpdateListeners();
                addDeleteListeners(); // Ensure delete listeners are also re-attached
            } else {
                tbody.innerHTML = '<tr><td colspan="7">No forms found.</td></tr>';
            }
        })
        .catch(() => {
            alert('Failed to load data!');
        });
}

console.log("ID:", id, "Status:", status);

$(document).ready(function () {
    // Fetch data and populate table
    function loadForms() {
        $.ajax({
            url: 'fetch_forms.php',
            method: 'GET',
            success: function (response) {
                console.log("Response from fetch_forms.php:", response); // Log the raw response
                try {
                    const data = JSON.parse(response); // Parse the response into JSON
                    console.log("Parsed Data:", data); // Log the parsed data

                    let tableRows = '';
                    data.forEach(form => {
                        tableRows += `
                            <tr>
                                <td>${form.id}</td>
                                <td>${form.username}</td>
                                <td>${form.form_type}</td>
                                <td>${form.tarikh_diperlukan}</td>
                                <td>${form.keutamaan}</td>
                                <td>
                                    <select class="form-status" data-id="${form.id}" data-form-type="${form.form_type}">
                                        <option value="Pending" ${form.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                        <option value="In Progress" ${form.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                        <option value="Completed" ${form.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="view-button" data-id="${form.id}">View</button>
                                </td>
                            </tr>`;
                    });

                    $('#formsTable tbody').html(tableRows);
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                    alert('Failed to parse data.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown); // Log AJAX error
                alert('Failed to fetch forms.');
            }
        });
    }

    // Load forms on page load
    loadForms();

    // Update the form status when the dropdown value changes
    $(document).on('change', '.form-status', function () {
        const id = $(this).data('id');
        const status = $(this).val();
        const form_type = $(this).data('form-type');

        console.log("Updating form:", { id, status, form_type }); // Log the data being sent

        // Send the updated status to the server
        $.ajax({
            url: 'update_status.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id, status, form_type }),
            success: function (response) {
                console.log("Response from update_status.php:", response); // Log the response from the server

                if (response.success) {
                    alert('Status updated successfully.');
                    loadForms(); // Reload the forms to reflect the changes
                } else {
                    alert('Unable to update status.');
                }
            },
            error: function () {
                alert('Error while updating status.');
            }
        });
    });

    // Handle view button click
    $(document).on('click', '.view-button', function () {
        const id = $(this).data('id');
        window.location.href = `view_form.php?id=${id}`;
    });
});

if (response.success) {
    alert('Status updated successfully.');
    loadForms();
} else {
    console.error("Error updating status:", response.message);
    alert('Error: ' + response.message);
}

$('#updateStatusBtn').click(function() {
    const selectedFormId = $(this).data('id'); // Get form ID from button
    const formType = $(this).data('form-type'); // Get form type dynamically
    const status = 'Completed'; // Example status

    // Debugging: Log data to console to verify correct values
    console.log({
        form_type: formType,
        id: selectedFormId,
        status: status
    });

    $.ajax({
        url: 'update_form_status.php',
        method: 'POST',
        data: {
            form_type: formType,
            id: selectedFormId,
            status: status
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
});

$('#updateStatusBtn').click(function() {
    const selectedFormId = $(this).data('id'); // Get form ID from button
    const formType = $(this).data('form-type'); // Get form type dynamically
    const status = 'Completed'; // Example status

    // Debugging: Log data to console to verify correct values
    console.log({
        form_type: formType,
        id: selectedFormId,
        status: status
    });

    $.ajax({
        url: 'update_form_status.php',
        method: 'POST',
        data: {
            form_type: formType,
            id: selectedFormId,
            status: status
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
});

$.ajax({
    url: 'update_form_status.php',
    method: 'POST',
    data: {
        form_type: formType,  // Send the form type
        id: id,               // Send the form ID
        status: status        // Send the status (like 'Completed')
    },
    dataType: 'json',
    success: function(response) {
        if (response.success) {
            alert(response.message);
        } else {
            alert(response.message);
        }
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
        console.log('Response:', xhr.responseText);
    }
});

$.ajax({
    url: 'update_form_status.php',
    method: 'POST',
    data: {
        form_type: formType,  // Send the form type
        id: id,               // Send the form ID
        status: status        // Send the status (like 'Completed')
    },
    dataType: 'json',
    success: function(response) {
        if (response.success) {
            alert(response.message);
        } else {
            alert(response.message);
        }
    },
    error: function(xhr, status, error) {
        console.error('Error:', error);
        console.log('Response:', xhr.responseText);
    }
});


        