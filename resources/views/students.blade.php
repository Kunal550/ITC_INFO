<!DOCTYPE html>
<html>

<head>
    <title>Student CRUD</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">
    <div class="container">
        <h2>Student Form</h2>

        <!-- Success Message -->
        <div id="success-message" class="alert alert-success d-none"></div>

        <form id="studentForm">
            <input type="hidden" name="id" id="student_id">

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
                <div class="text-danger error-name"></div>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
                <div class="text-danger error-email"></div>
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
                <div class="text-danger error-phone"></div>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>

        <hr>

        <h2>Student List</h2>
        <table class="table table-bordered mt-4" id="studentTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this student?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="confirmDelete" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle (required for modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const apiUrl = "{{ url('/api/students') }}";

        function loadStudents() {
            $.get(apiUrl, function(data) {
                let rows = '';
                $.each(data, function(i, student) {
                    rows += `
                    <tr data-id="${student.id}">
                        <td>${student.name}</td>
                        <td>${student.email}</td>
                        <td>${student.phone}</td>
                        <td>
                            <button class="btn btn-sm btn-info editBtn">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                        </td>
                    </tr>
                `;
                });
                $('#studentTable tbody').html(rows);
            });
        }

        $(document).ready(function() {
            loadStudents();

            $('#studentForm').on('submit', function(e) {
                e.preventDefault();

                const studentId = $('#student_id').val();
                const type = studentId ? 'PUT' : 'POST';
                const url = studentId ? `${apiUrl}/${studentId}` : apiUrl;

                let formData = {
                    name: $('input[name="name"]').val(),
                    email: $('input[name="email"]').val(),
                    phone: $('input[name="phone"]').val(),
                };

                $('.text-danger').html('');
                $('#success-message').addClass('d-none').html('');

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function(res) {
                        $('#success-message').removeClass('d-none').html(studentId ? 'Student updated!' : 'Student created!');
                        $('#studentForm')[0].reset();
                        $('#student_id').val('');
                        loadStudents();
                        setTimeout(() => $('#success-message').addClass('d-none'), 3000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('.error-' + key).text(value[0]);
                            });
                        }
                    }
                });
            });

            // Edit
            $(document).on('click', '.editBtn', function() {
                const tr = $(this).closest('tr');
                const id = tr.data('id');
                $.get(`${apiUrl}/${id}`, function(student) {
                    $('#student_id').val(student.id);
                    $('input[name="name"]').val(student.name);
                    $('input[name="email"]').val(student.email);
                    $('input[name="phone"]').val(student.phone);
                });
            });

            // Delete
            let deleteId = null;

            $(document).on('click', '.deleteBtn', function() {
                const tr = $(this).closest('tr');
                deleteId = tr.data('id');
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                deleteModal.show();
            });

            $('#confirmDelete').on('click', function() {
                if (deleteId) {
                    $.ajax({
                        url: `${apiUrl}/${deleteId}`,
                        type: 'DELETE',
                        success: function() {
                            $('#success-message').removeClass('d-none').html('Student deleted!');
                            loadStudents();
                            deleteId = null;
                            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                            setTimeout(() => $('#success-message').addClass('d-none'), 3000);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
