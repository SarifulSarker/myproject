@extends('admin.master')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SMS List</h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="col-12 col-sm-10">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a href="{{ route('student.individualpage') }}" class="nav-link {{ request()->routeIs('student.individualpage') ? 'active' : '' }}" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">By Individual</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.byclass') }}" class="nav-link {{ request()->routeIs('student.byclass') ? 'active' : '' }}" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">By Class</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.byclasses') }}" class="nav-link {{ request()->routeIs('student.byclasses') ? 'active' : '' }}" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">By Classes</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <!-- Tab panes -->
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade {{ request()->routeIs('student.byclass') || request()->routeIs('student.searchbyclass') ? 'show active' : '' }}" id="custom-tabs-four-home" role="tabpanel">
                        {{-- Content for "By class" tab --}}
                        <form id="searchForm" action="{{ route('student.searchbyclass') }}" method="GET">
                            <div class="form-group">
                                <label for="searchInput">Search by Class:</label>
                                <input type="text" class="form-control" id="searchbyclass" name="searchbyclass" placeholder="Search by class">
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>

                        <!-- Search Results -->
                        @if (isset($students))
                        @if (!$students->isEmpty())
                            <h1>Search Results</h1>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAllCheckbox">
                                        </th> <!-- Add a new table header for the "all select" checkbox -->
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Student ID</th>
                                        <th>Roll</th>
                                        <th>Session</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="student-checkbox" name="selected_students[]" value="{{ $student->id }}">
                                        </td> <!-- Add a checkbox in each row -->
                                        <td>
                                            @if ($student->image)
                                            <img src="{{ asset($student->image) }}" alt="Student image" style="max-width: 100px;">
                                            @else
                                            No image Available
                                            @endif
                                        </td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->class }}</td>
                                        <td>{{ $student->student_id }}</td>
                                        <td>{{ $student->roll }}</td>
                                        <td>{{ $student->session }}</td>
                                        <td>{{ $student->phone }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            <!-- SMS Title and Text Area -->
                            <div class="form-group">
                                <label for="sms_title">Select SMS Title:</label>
                                <select class="form-control sms-title" id="sms_title_individual">
                                    <option value="">Select SMS title</option>
                                    @foreach($sms_lists as $row)
                                        <option value="{{ $row->id }}" data-text="{{ $row->text }}">{{ $row->sms_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group sms-text-area" style="display: none;" id="sms_text_area_individual">
                                <label for="sms_text">SMS Text:</label>
                                <textarea class="form-control sms-text" id="sms_text_individual" readonly></textarea>
                            </div>

                        @else
                            <p>No results found.</p>
                        @endif
                    @endif

                        <button type="button" class="btn btn-primary" id="sendSMSBtn">Send SMS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // for active tab
    function setActiveTab() {
        var tabLinks = document.querySelectorAll('.nav-link');
        var searchResultsExist = document.querySelector('#searchResultsTable');

        // Remove active class from all tab links
        tabLinks.forEach(function(link) {
            link.classList.remove('active');
        });

        // Add active class to the appropriate tab link
        if (searchResultsExist) {
            tabLinks.forEach(function(link) {
                if (link.getAttribute('href') == "{{ route('student.searchbyclass') }}") {
                    link.classList.add('active');
                }
            });
        } else {
            tabLinks.forEach(function(link) {
                if (link.getAttribute('href') == "{{ route('student.byclass') }}") {
                    link.classList.add('active');
                }
            });
        }
    }

    // Call the function to set the active tab
    setActiveTab();





    // Function to handle SMS title selection and SMS text display
    function handleSMSTitleSelection(selectId, textareaId) {
        // Get references to the select and textarea elements
        var selectElement = document.getElementById(selectId);
        var textareaElement = document.getElementById(textareaId);

        // Add event listener to the select element
        selectElement.addEventListener('change', function() {
            // Get the selected option
            var selectedOption = selectElement.options[selectElement.selectedIndex];

            // Get the text associated with the selected option
            var text = selectedOption.getAttribute('data-text');

            // Set the text area value to the selected text
            textareaElement.value = text;

            // Make the text area editable
            textareaElement.removeAttribute('readonly');

            // Display the text area container
            document.getElementById('sms_text_area_individual').style.display = 'block';
        });

        // On page load, populate the text area with the default selected SMS title's text
        window.onload = function() {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var text = selectedOption.getAttribute('data-text');
            textareaElement.value = text;
        };
    }
    handleSMSTitleSelection('sms_title_individual', 'sms_text_individual');

    // Function to handle the "Select All" checkbox
    document.getElementById('selectAllCheckbox').addEventListener('change', function(event) {
        var checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = event.target.checked;
        });
    });

// Function to handle sending SMS
document.getElementById('sendSMSBtn').addEventListener('click', function() {
    var selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
    var phoneNumbers = [];
    var message = document.getElementById('sms_text_individual').value.trim(); // Get the SMS message from the textarea

    // Check if any checkbox is selected
    if (selectedCheckboxes.length === 0) {
        // If no checkbox is selected, get all phone numbers from displayed students
        var allPhoneNumbers = document.querySelectorAll('td:nth-child(8)'); // Adjust nth-child index according to the position of the phone number column
        allPhoneNumbers.forEach(function(phoneNumber) {
            phoneNumbers.push(phoneNumber.textContent);
        });
    } else {
        // If checkboxes are selected, collect phone numbers of selected students
        selectedCheckboxes.forEach(function(checkbox) {
            var phoneNumber = checkbox.closest('tr').querySelector('td:nth-child(8)').textContent; // Adjust nth-child index according to the position of the phone number column
            phoneNumbers.push(phoneNumber);
        });
    }

    // Check if any phone numbers are selected
    if (phoneNumbers.length > 0) {
        var numbersString = phoneNumbers.join(',');
        // Call sms_send() function with the phone numbers and message
        sms_send(numbersString, message);
    } else {
        alert('No students selected. Please select at least one student.');
    }
});

// Function to send SMS using API
function sms_send(numbers, message) {
    var url = "http://bulksmsbd.net/api/smsapi";
    var apiKey = "8tzwxAVTkGoEGMQtpJ9x";
    var senderId = "8809617615123";

    var data = {
        "api_key": apiKey,
        "senderid": senderId,
        "number": numbers,
        "message": message
    };
console.log(data);
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        console.log('SMS sent:', data);
        // Handle response as needed
        alert('SMS sent successfully.');
    })
    .catch((error) => {
        console.error('Error:', error);
        // Handle errors
        alert('Failed to send SMS.');
    });
}
</script>

@endsection
