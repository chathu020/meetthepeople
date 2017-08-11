<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}" class="site_title">
                <div class="logo"><img src="{{ asset("images/PAP.png") }}"/></div>
                <span>Meet The people!</span></a>
        </div>
        
        <div class="clearfix"></div>
        
        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="{{ Gravatar::src(Auth::user()->email) }}" alt="Avatar of {{ Auth::user()->name }}" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::user()->name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        
        <div class="clearfix"></div>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                
                <ul class="nav side-menu active">
                    <li>
                        <a href="/">
                            <i class="fa fa-dashboard"></i>
                            Dashboard
                            <span class="label label-success pull-right">Home</span>
                        </a>
                    </li>

                     <li>
                        <a><i class="fa fa-users"></i> Clients <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="/clients">All Clients</a>
                            </li>
                            <li>
                                <a href="/register">Add Client</a>
                            </li>   
                        </ul>
                    </li>
                     <li><a><i class="fa fa-list"></i> Queue Management <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                             @role((['counterA', 'admin', 'mp']))
                                <li><a href="/counterqueue">Counter A Queue</a></li>
                             @endrole
                            <li><a href="/writerqueue">Writer Queue</a></li>
                             <li><a href="/mpqueue">MP Queue</a></li>
                            
                        </ul>
                    </li>
                    <li>
                        <a href="/cases"><i class="fa fa-briefcase"></i> Cases <span class="fa "></span></a>
                        </li>    
                </ul>
            </div>
               @role(('admin')) 
            <div class="menu_section">
                <h3>System</h3>
                <ul class="nav side-menu">                 
                    <li><a><i class="fa fa-gear"></i> Administration <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/users">User Management</a></li>
                             <li><a href="/accommodations">Accomodation Management</a></li> 
                             <li><a href="/approvalparties">Approval Party Management</a></li> 
                             <li><a href="/templates">Template Management</a></li> 
                             <li><a href="/recipients">Recipient Management</a></li> 
                             <li><a href="/caseReferences">Case References Management</a></li> 
                            <li><a href="/roles">Roles</a></li>                            
                        </ul>
                    </li>
                       <li><a><i class="fa fa-file"></i> Reports <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/reportA">Report A</a></li>
                             <li><a href="/reportB">Report B</a></li>  
                        </ul>
                    </li>                   
                </ul>
            </div>
             @endrole
        </div>
        <!-- /sidebar menu -->
        
    </div>
</div>