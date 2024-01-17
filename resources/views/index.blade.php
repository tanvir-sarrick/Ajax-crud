<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <title>CRUD Using Ajax</title>
  </head>
  <body>
    <br>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add Student
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                <form id="yourForm">
                @csrf

                <!-- Your form fields go here -->
                <div class="form-group">
                    <label for="your_field">Enter Student Name:</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <label for="your_field">Enter Student Id Card:</label>
                    <input type="text" name="id_card" id="id_card" class="form-control">
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <br>
    <table class="table">
        <thead>
            <tr>
            <th scope="col">Sl#</th>
            <th scope="col">Name</th>
            <th scope="col">ID Card</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="dataTableBody">

        </tbody>
    </table>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


     <script>
        $(document).ready(function () {
            $('#yourForm').submit(function (e) {
                e.preventDefault();
                var form = $(this);

                $.ajax({
                    type: 'POST',
                    url: '{{ route("student.store") }}',
                    data: form.serialize(),
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);

                            setTimeout(function () {
                                $('#exampleModal').modal('hide');
                                form[0].reset();
                                fetchTableData();
                            }, 1000); // Set the delay in milliseconds
                        }

                        else {
                            toastr.error(response.message);
                        }
                    },

                    error: function (xhr, status, error) {
                        // Handle validation error messages
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            var keys = Object.keys(errors);

                            keys.forEach(function (key, index) {
                                setTimeout(function () {
                                    toastr.error(errors[key]);
                                }, index * 1000); // Set the delay in milliseconds
                            });
                        }

                        else {
                            toastr.error('An error occurred while processing your request.');
                        }
                    }
                });
            });
        });
    </script>

    <script>
        // Fetch and display table data
        function fetchTableData() {
            $.ajax({
                type: 'GET',
                url: '{{ route("get.student.data") }}',
                success: function (response) {
                    if (response.data.length > 0) {
                        // Counter for serial number
                        var counter = 1;
                        // Clear existing table rows
                        $('#dataTableBody').empty();
                        // Append new rows
                        $.each(response.data, function (index, student) {
                            $('#dataTableBody').append(`
                                <tr>
                                    <td>${counter}</td>
                                    <td>${student.name}</td>
                                    <td>${student.id_card}</td>
                                    <td>Edit/Delete</td>
                                </tr>
                            `);
                            // Increment counter for the next row
                            counter++;
                        });
                    }
                    else {
                        toastr.info('No data available.');
                        $('#dataTableBody').html(`
                        <tr>
                            <td colspan="4" style="text-align:center;">No data available.</td>
                        </tr>
                    `);
                    }
                },
                error: function () {
                    toastr.error('An error occurred while fetching table data.');
                }
            });
        }
        // Call the function to fetch data when the page loads
        fetchTableData();
    </script>
  </body>
</html>
