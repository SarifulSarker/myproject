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
                    <div class="tab-pane fade {{ request()->routeIs('student.byclasses') ? 'show active' : '' }}" id="custom-tabs-four-home" role="tabpanel">
                        {{-- Content for "By Classes" tab --}}
                        <h1>All Classes</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAllCheckbox">
                                    </th>
                                    <th>Class</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classNames as $className)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="student-checkbox" name="selected_classes[]" value="{{ $className }}">
                                    </td>
                                    <td>{{ $className }}</td>
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

                        <button type="button" class="btn btn-primary" id="sendSMSBtn">Send SMS</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Function to handle SMS title selection and SMS text display
function handleSMSTitleSelection(selectId, textareaId) {
    var selectElement = document.getElementById(selectId);
    var textareaElement = document.getElementById(textareaId);

    selectElement.addEventListener('change', function() {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var text = selectedOption.getAttribute('data-text');

        textareaElement.value = text;
        textareaElement.removeAttribute('readonly');
        document.getElementById('sms_text_area_individual').style.display = 'block';
    });

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

// handle send sms
// Function to handle sending SMS
document.getElementById('sendSMSBtn').addEventListener('click', function() {
    var phoneNumbers = [];
    var message = document.getElementById('sms_text_individual').value.trim();

    var checkedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
    if (checkedCheckboxes.length === 0) {
        alert('No classes selected. Please select at least one class.');
        return;
    }

    var promises = [];

    checkedCheckboxes.forEach(function(checkbox) {
        var className = checkbox.value;
        var promise = fetch('{{ route('sendsms.getStudentsPhoneNumbers') }}?class=' + encodeURIComponent(className))
            .then(response => response.json())
            .then(data => {
                if (data.phoneNumbers && data.phoneNumbers.length > 0) {
                    phoneNumbers = phoneNumbers.concat(data.phoneNumbers);
                }
            });

        promises.push(promise);
    });

    Promise.all(promises)
        .then(function() {
            if (phoneNumbers.length > 0) {
                var numbersString = phoneNumbers.join(', ');
                sms_send(numbersString, message);
            } else {
                alert('No phone numbers found for selected classes.');
            }
        });
});



// send sms function
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
       // console.log('SMS sent:', data);
        // Handle response as needed
        alert('SMS sent successfully.');
    })
    .catch((error) => {
        //console.error('Error:', error);
        // Handle errors
        alert('Failed to send SMS.');
    });
}

</script>
@endsection
