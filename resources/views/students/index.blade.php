<x-app-layout>
    <x-slot name="style">
        <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Student List</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Students</h4>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success" id="notificationAlert">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('students.create') }}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Student</a>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                                    <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>SL</th>
                                        <th>Student</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Department</th>
                                        <th>Earning Credit</th>
                                        <th>Status</th>
                                        <th style="width: 75px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ ++$i }}</td>
                                            <td class="table-user">
                                                @if ($student->image)
                                                    <img src="/images/users/{{ $student->image }}" alt="table-user" class="me-2 rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/avator.png') }}" alt="table-user" class="me-2 rounded-circle">
                                                @endif
                                                <a href="{{ route('students.show', $student->id) }}" class="text-body fw-semibold">{{ $student->name ?? '' }}</a>
                                            </td>
                                            <td>{{ $student->contact_number ?? '' }}</td>
                                            <td>{{ $student->email ?? '' }}</td>
                                            <td>{{ ($student->gender == 1) ? 'Male' : (($student->gender == 2) ? 'Female' : (($student->gender == 3) ? 'Others' : '')) }}</td>
                                            <td>{{ $student->session->batch->department->name ?? '' }}</td>
                                            <td>{{ $student->earning_credit ?? '' }}</td>
                                            <td>
                                                @if ($student->status == 1)
                                                    <span class="badge badge-success-lighten">Active</span>
                                                @elseif ($student->status == 2)
                                                    <span class="badge badge-warning-lighten">Inactive</span>
                                                @elseif ($student->status == 3)
                                                    <span class="badge badge-danger-lighten">Blocked</span>
                                                @endif
                                            </td>
        
                                            <td>
                                                <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                                                    <a href="{{ route('students.show', $student->id) }}" class="action-icon" id="view_button"> <i class="mdi mdi-eye"></i></a>
                                                    <a href="{{ route('students.edit', $student->id) }}" class="action-icon" id="edit_button"> <i class="mdi mdi-square-edit-outline"></i></a>

                                                    @csrf
                                                    @method('DELETE')

                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn action-icon show_confirm" data-toggle="tooltip" title='Delete'><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- script -->
    <x-slot name="script">
        <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>

        <script src="{{ asset('assets/js/pages/demo.student.js') }}"></script>

        <script>
            $('#notificationAlert').delay(3000).fadeOut('slow');     
                $(document).ready(function() {
                    $('#DataTable').DataTable();
            });

            $('.show_confirm').click(function(event) {
                var form =  $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this item ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
