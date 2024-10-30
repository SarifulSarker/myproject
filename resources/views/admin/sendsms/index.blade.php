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
        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">By Individual</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">By Class</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">By classes</a>
        </li>

        </ul>
        </div>
        <div class="card-body">

        <div class="tab-content" id="custom-tabs-four-tabContent">
             {{-- by individual --}}
        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

{{--
          @include('admin.sendsms.byindividual') --}}
        </div>


       {{-- by class --}}
       <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

        <div class="form-group">
            <label for="sms_title">Select SMS Title:</label>
            <select class="form-control sms-title" id="sms_title_class">
                <option value="">Select SMS title</option>
                @foreach($sms_lists as $key=>$row)
                <option value="{{ $row->id }}" data-text="{{ $row->text }}">{{ $row->sms_title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group sms-text-area" style="display: none;" id="sms_text_area_class">
            <label for="sms_text">SMS Text:</label>
            <textarea class="form-control sms-text" id="sms_text_class" readonly></textarea>
        </div>

        <form id="searchForm" action="{{ route('student.searchbyclass') }}" method="GET">
            <div class="form-group">
                <label for="searchInput">Search:</label>
                <input type="text" class="form-control" id="searchclass" name="searchclass" placeholder="Search by class">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Your search results -->
        <h1>Search Results</h1>

        @if (isset($students) && $students->isEmpty())
            <p>No results found.</p>
        @elseif (isset($students))
            <table class="table">
                <thead>
                    <tr>
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
        @endif

        <!-- Your send SMS button -->
        <button type="button" class="btn btn-primary" id="sendSMSBtn">Send SMS</button>






        <script>
            // Function to handle SMS title selection and SMS text display
        function handleSMSTitleSelection(selectId, textareaId, containerId) {
        // Get references to the select and textarea elements
        var selectElement = document.getElementById(selectId);
        var textareaElement = document.getElementById(textareaId);
        var textAreaContainer = document.getElementById(containerId);

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
        textAreaContainer.style.display = 'block';
        });
        }
           handleSMSTitleSelection('sms_title_class', 'sms_text_class', 'sms_text_area_class');

        </script>



    </div>


        {{-- by classes --}}
        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
     usce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
        </div>

        </div>
        </div>

        </div>
        </div>
        </div>




{{-- by individual search code --}}
{{-- <script>
      document.getElementById('searchBtn').addEventListener('click', function() {
    var query = document.getElementById('searchInput').value.trim().toLowerCase();
    var students = {!! json_encode($data) !!};
    var searchResults = [];

    students.forEach(function(student) {
        // Check if student ID contains the query
        if (student.student_id.toLowerCase().includes(query)) {
            // Check if student has an image path
            if (student.image) {
                searchResults.push({
                    name: student.name,
                    student_id: student.student_id,
                    roll: student.roll,
                    class: student.class,
                    session: student.session,
                    phone: student.phone,
                    image: student.image,
                });
            } else {
                // If student doesn't have an image path, you may want to handle this case
                // For example, you could push a placeholder image path
                searchResults.push({
                    name: student.name,
                    student_id: student.student_id,
                    roll: student.roll,
                    class: student.class,
                    session: student.session,
                    phone: student.phone,
                    image: '/placeholder_image.jpg', // Replace with your placeholder image path
                });
            }
        }
    });

    displaySearchResults(searchResults);

function displaySearchResults(results) {
    var searchResultsElement = document.getElementById('searchResults');
    searchResultsElement.innerHTML = '';

    if (results.length === 0) {
        var noResultsElement = document.createElement('div');
        noResultsElement.classList.add('alert', 'alert-warning');
        noResultsElement.textContent = 'No results found';
        searchResultsElement.appendChild(noResultsElement);
    } else {
        results.forEach(function(result) {
            var rowDiv = document.createElement('div');
            rowDiv.classList.add('row');

            // Create column for the student image
            var imageColDiv = document.createElement('div');
            imageColDiv.classList.add('col-md-3', 'mt-4');

            // Create circular placeholder for the image
            var circularPlaceholder = document.createElement('div');
            circularPlaceholder.classList.add('rounded-circle', 'overflow-hidden', 'd-inline-block', 'p-1');
            circularPlaceholder.style.width = '200px'; // Adjust size as needed
            circularPlaceholder.style.height = '200px'; // Adjust size as needed



            // Create image element and set its attributes
            var imageElement = document.createElement('img');
            imageElement.src = "{{ asset('') }}" + result.image; // Set image source dynamically
            imageElement.classList.add('img', 'img-responsive');
            imageElement.style.width = '100%';
            imageElement.style.height = 'auto';
            // Append image element to circular placeholder
            circularPlaceholder.appendChild(imageElement);

            // Append circular placeholder to image column
            imageColDiv.appendChild(circularPlaceholder);

            // Create column for student information
            var infoColDiv = document.createElement('div');
            infoColDiv.classList.add('col-md-9', 'mt-4');

            var tableElement = document.createElement('table');
            tableElement.classList.add('table', 'table-bordered', 'table-responsive-lg');
            var tbodyElement = document.createElement('tbody');

            // Add rows for each property (Name, Class, Student ID, Roll, Session, Phone)
            var properties = ['Name', 'Class', 'Student ID', 'Roll', 'Session', 'Phone'];
            properties.forEach(function(property) {
                var tr = document.createElement('tr');
                var td1 = document.createElement('td');
                td1.classList.add('font-weight-bold');
                td1.textContent = property;
                var td2 = document.createElement('td');
                // Special handling for 'Student ID' property to display 'student_id'
                if (property === 'Student ID') {
                    td2.textContent = result.student_id;
                } else {
                    td2.textContent = result[property.toLowerCase()]; // Access property dynamically
                }
                tr.appendChild(td1);
                tr.appendChild(td2);
                tbodyElement.appendChild(tr);
            });

            tableElement.appendChild(tbodyElement);
            infoColDiv.appendChild(tableElement);

            // Append image column and info column to the row
            rowDiv.appendChild(imageColDiv);
            rowDiv.appendChild(infoColDiv);

            // Append the row to the search results container
            searchResultsElement.appendChild(rowDiv);
        });
    }
}

});





</script> --}}


@endsection
