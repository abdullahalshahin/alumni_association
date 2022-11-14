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
                            <li class="breadcrumb-item active">Defence Request List</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Defence Request</h4>
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
                                        <th>Group</th>
                                        <th>Session</th>
                                        <th>Batch</th>
                                        <th>Department</th>
                                        <th>Teacher</th>
                                        <th>Topic</th>
                                        <th>Status</th>
                                        <th style="width: 75px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($defences as $defence)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $defence->student->name ?? '' }}</td>
                                            <td>{{ $defence->group->name ?? '' }}</td>
                                            <td>{{ $defence->group->session->name ?? '' }}</td>
                                            <td>{{ $defence->group->session->batch->name ?? '' }}</td>
                                            <td>{{ $defence->group->session->batch->department->name ?? '' }}</td>
                                            <td>{{ $defence->group->teacher->name ?? '' }}</td>
                                            <td>{{ $defence->group->topic_name ?? '' }}</td>
                                            <td>
                                                @if ($defence->status == 0)
                                                    <span class="badge badge-warning-lighten">Incomplete</span>
                                                @elseif ($defence->status == 1)
                                                    <span class="badge badge-success-lighten">Complete</span>
                                                @endif
                                            </td>
        
                                            <td>
                                                <form action="{{ route('defences.destroy', $defence->id) }}" method="POST">
                                                    <a href="{{ route('defences.edit', $defence->id) }}" class="action-icon" id="edit_button"> <i class="mdi mdi-square-edit-outline"></i></a>

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

        <script src="{{ asset('assets/js/pages/demo.defences.js') }}"></script>

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
