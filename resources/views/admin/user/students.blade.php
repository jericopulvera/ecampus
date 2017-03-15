@extends('admin.templates.app')

@section('content')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Student Users list</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="users">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">USN</th>
                            <th class="column-title">Name</th>
                            <th class="column-title">Course</th>
                            <th class="column-title">Followers</th>
                            <th class="column-title">Following</th>
                            <th class="column-title">Posts</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span></th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('admin-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/r-2.1.1/datatables.min.css"/>
@endpush

@push('admin-js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/r-2.1.1/datatables.min.js"></script>

    <script>

      $(function() {
            $('#users').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url('/admin/api/students') !!}',
                columns: [
                    { data: 'usn', name: 'USN' },
                    { data: 'name', name: 'name' },
                    { data: 'course', name: 'course' },
                    { data: 'followerCount', name: 'followers' },
                    { data: 'followCount', name: 'following' },
                    { data: 'postCount', name: 'posts' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });

    </script>
@endpush
