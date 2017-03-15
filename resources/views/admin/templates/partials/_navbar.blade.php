<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{auth()->user()->image}}" alt="">{{auth()->user()->name}}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="/">
                                <span>Go back to main panel</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/settings">
                                <span>Settings</span>
                            </a>
                        </li>
                        <li><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out pull-right"></i> Log Out</a>
                        </li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                             {{ csrf_field() }}
                         </form>
                    </ul>
                </li>

                {{-- @include('admin.templates.partials.navbar.notifications') --}}

                <li class="user-footer">
                             
                          
                           
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
