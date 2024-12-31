<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Forms</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #020c1b, #0b1d3f); /* Dark blue gradient */
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        h1 {
            font-size: 2.5rem;
            color: #00ffff; /* Bright cyan for title */
            letter-spacing: 2px;
        }

        /* Main Container */
        main {
            background: rgba(20, 30, 48, 0.95);
            border-radius: 15px;
            padding: 30px;
            max-width: 1100px;
            width: 90%;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.5);
            margin-top: 30px;
        }

        /* Back Button */
        .back-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 20px;
            transition: background-color 0.2s ease, transform 0.2s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        .back-btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        .back-btn:active {
            transform: scale(0.95);
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 30px;
        }

        .tab {
            background: linear-gradient(135deg, #1d4b6f, #2c4f64);
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
        }

        .tab.active {
            background: linear-gradient(135deg, #0a9cc2, #1d5b6e);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.6);
        }

        .tab:hover {
            transform: translateY(-5px);
        }

        /* Tab Content */
        .tab-content {
            display: none;
            padding: 20px;
            background: rgba(20, 30, 48, 0.95);
            border-radius: 10px;
            border-top: 3px solid #00ffff;
            color: #ffffff;
            margin-top: 20px;
        }

        .tab-content.active {
            display: block;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            text-align: left;
            padding: 15px;
        }

        th {
            background-color: #24344d;
            color: #ffffff;
            text-transform: uppercase;
            font-weight: bold;
        }

        td {
            background-color: rgba(20, 30, 48, 0.95);
            border-bottom: 1px solid #1f4068;
            color: #ffffff;
        }

        tr:hover td {
            background-color: #24344d;
        }

        /* Action Button */
        .view-btn {
            padding: 8px 16px;
            background-color: #00bcd4;
            color: #ffffff;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-btn:hover {
            background-color: #008c96;
        }

        .view-btn:active {
            transform: scale(0.95);
        }
        /* Center the Back Button */
        .back-button-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 20px; /* Adjust spacing from bottom */
        }

        /* Button style for 'Back to Dashboard' */
        .back-button {
            padding: 12px 20px;
            background-color: #28a745;
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Forms</h1>
    </header>
    <main>
        <div class="tabs">
            <div class="tab active" data-tab="borang_ict1">Form 1</div>
            <div class="tab" data-tab="borang_ict2">Form 2</div>
            <div class="tab" data-tab="borang_ict3">Form 3</div>
        </div>

        <div class="tab-content" id="borang_ict1">
            <h2>Borang ICT 1</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Priority</th>
                        <th>Tarikh Diperlukan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="borang_ict1_data">
                    <!-- Data will be dynamically populated here -->
                </tbody>
            </table>
        </div>

        <div class="tab-content" id="borang_ict2">
            <h2>Borang ICT 2</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Priority</th>
                        <th>Tarikh Diperlukan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="borang_ict2_data">
                    <!-- Data will be dynamically populated here -->
                </tbody>
            </table>
        </div>

        <div class="tab-content" id="borang_ict3">
            <h2>Borang KEW.PA-9</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Priority</th>
                        <th>Tarikh Diperlukan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="borang_ict3_data">
                    <!-- Data will be dynamically populated here -->
                </tbody>
            </table>
        </div>
    </main>

    <script>
        $(document).ready(function () {
            function loadFormData(formType) {
                $.ajax({
                    url: 'fetch_forms.php',
                    method: 'GET',
                    data: { form_type: formType },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            const data = response.data;
                            let tableData = '';
                            let counter = 1; // Initialize counter for sequential numbering
                            data.forEach(function (row) {
                                const link = row.id ? `view_form.php?form_type=${formType}&id=${row.id}` : '#';
                                tableData += ` 
                                    <tr>
                                        <td>${counter}</td> <!-- Use counter instead of row.id -->
                                        <td>${row.username}</td>
                                        <td>${row.keutamaan}</td>
                                        <td>${row.tarikh_diperlukan}</td>
                                        <td>${row.status || 'Pending'}</td>
                                        <td><a href="${link}" class="view-btn">View</a></td>
                                    </tr>
                                `;
                                counter++; // Increment counter for each row
                            });
                            $(`#${formType}_data`).html(tableData);
                        } else {
                            $(`#${formType}_data`).html('<tr><td colspan="6">No data found</td></tr>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                        alert('Error fetching data.');
                    }
                });
            }

            // Initial data load for the first tab
            loadFormData('borang_ict1');

            // Tab switching logic
            $('.tab').click(function () {
                const tab = $(this).data('tab');
                $('.tab').removeClass('active');
                $(this).addClass('active');
                $('.tab-content').removeClass('active');
                $('#' + tab).addClass('active');
                loadFormData(tab);
            });
        });
    </script>
    <div class="back-button-container">
        <button class="back-button" onclick="window.location.href='admin_dashboard.html'">Back to Dashboard</button>
    </div>
</div>
</body>
</html>