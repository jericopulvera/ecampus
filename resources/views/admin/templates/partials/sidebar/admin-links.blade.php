<ul class="nav side-menu">
    <li>
        <a href="/admin/dashboard"><i class="fa fa-home"></i> Dashboard</a>
    </li>    
    {{-- <li>
        <a href="/admin/announcements"><i class="fa fa-bell"></i> Announcements</a>
    </li> --}}
    <li>
        <a><i class="fa fa-user"></i>Users<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="/admin/users/create">Create User</a></li>
            <li><a href="/admin/users">All</a></li>
           <!--  <li><a href="/admin/professors">Professors</a></li>
           <li><a href="/admin/students">Students</a></li> -->
        </ul>
    </li>
    
   {{--  <li>
        <a><i class="fa fa-group"></i>Classes<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="/admin/classes">Current Term</a></li>
            <li><a href="/admin/classes/old">Old Classes</a></li>
        </ul>
    </li> --}}
    <li>
        <a><i class="fa fa-plus"></i>Student Grades<span class="fa fa-chevron-down"></span></a>
        <ul class="nav child_menu">
            <li><a href="/admin/grades">Student Grades List</a></li>
            <li><a href="/admin/grades/current">Current Term Fail and Incomplete Grades</a></li>
        </ul>
    </li>
   {{--  <li>
        <a href="/admin/academic-term"><i class="fa fa-graduation-cap"></i> Academic Terms</a>
    </li> --}}
    
    <li>
        <a href="/admin/settings"><i class="fa fa-cog"></i> Settings</a>
    </li>

<li><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fa fa-sign-out pull-right"></i> Log Out</a>
</li>
    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
</li>
</ul>
