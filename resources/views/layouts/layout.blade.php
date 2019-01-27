<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

    <title> ChrisList </title>
    <meta name="description" content="">
    <meta name="author" content="">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Basic Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/js/plugin/datatables-responsive/css/datatables.responsive.css') }}">
    
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/smartadmin-production.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/smartadmin-skins.css') }}">

    <link href="{{ asset('plugins/croppie/croppie.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/css/override.css?version=1.1.0') }}">

    <!-- FAVICONS -->
    <link rel="shortcut icon" href="/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/img/favicon/favicon.ico" type="image/x-icon">

    <!-- GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

  </head>
  <body class="fixed-header fixed-navigation">
    <!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->

    <!-- HEADER -->
    <header id="header">
      <div id="logo-group">

        <!-- PLACE YOUR LOGO HERE -->
        <span id="logo"> <img src="/img/logo.png" alt="ChrisList"> </span>
        <!-- END LOGO PLACEHOLDER -->
      </div>

      <!-- projects dropdown -->
      <div id="project-context">

        <span class="label">Features:</span>
        <span id="project-selector" class="popover-trigger-element dropdown-toggle" data-toggle="dropdown">App Functionalities <i class="fa fa-angle-down"></i></span>

        <ul class="dropdown-menu">
          <li>
            <a href="javascript:void(0);"><i class="fa fa-check"></i> Easy-to-manage to-do list</a>
          </li>          
          <li>
            <a href="javascript:void(0);"><i class="fa fa-check"></i> Multiple to-do list management</a>
          </li>
          <li>
            <a href="javascript:void(0);"><i class="fa fa-check"></i> Activity tracking</a>
          </li>
          <li>
            <a href="javascript:void(0);"><i class="fa fa-check"></i> Printing of to-do list</a>
          </li>
          <li>
            <a href="javascript:void(0);"><i class="fa fa-check"></i> Authentication</a>
          </li>
          <li>
            <a href="javascript:void(0);"><i class="fa fa-check"></i> Change password & upload photo</a>
          </li>
        </ul>
        <!-- end dropdown-menu-->

      </div>
      <!-- end projects dropdown -->

      <!-- pulled right: nav area -->
      <div class="pull-right">

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
          <span> <a href="javascript:void(0);" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
          <span> <a href="/auth/logout" title="Sign Out"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->
      </div>
      <!-- end pulled right: nav area -->

    </header>
    <!-- END HEADER -->

    <!-- Left panel : Navigation area -->
    <!-- Note: This width of the aside area can be adjusted through LESS variables -->
    <aside id="left-panel">

      <!-- User info -->
      <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
          
          <a href="javascript:void(0)" id="show-shortcut" data-id="{{ Session::has('user') ? Session::get('user')->id : '' }}" data-action="toggleShortcut">
            <!-- Get the user session --> 
            @php $user = Session::has('user') ? App\User::find(Session::get('user')->id) : null; @endphp
            @php $photo = ''; @endphp

            <!-- Get the photo of the user --> 
            @if ($user && $user->person)
              @php $photo = $user->person->image; @endphp
            @endif

            <!-- If user has no photo, get the default avatars --> 
            @if (!$photo || $photo == '')
                @if ($user && $user->person)
                  @php $photo = '/img/avatars/initials/' . strtoupper($user->person->first_name[0]) . '.png'; @endphp
                @else
                  @php $photo = '/img/avatars/initials/G.png'; @endphp
                @endif
            @endif

            <img id="img-logged-in" src="{{ $photo }}" alt="me" class="offline" /> 
            <span>
              <!-- Display user's name --> 
              @if ($user && $user->person)
                  {{ $user->person->first_name }} {{ $user->person->last_name }}
              @else
                  Guest
              @endif
            </span>

            <i class="fa fa-angle-down"></i>
          </a> 
          
        </span>
      </div>
      <!-- end user info -->

      <nav>
        <ul>
          <li class="{{ isset($page) && $page == 'Todos' ? 'active' : '' }}">
            <a href="/todos" title="To-Do Lists">
              <i class="fa fa-lg fa-fw fa-check"></i> 
              <span class="menu-item-parent">To-Do Lists</span>
              @if (Session::has('user'))
                @php $user = App\User::find(Session::get('user')->id); @endphp

                <!-- Show number of To-Do's --> 
                <span class="badge pull-right inbox-badge margin-right-13">{{ $user->todos->count() }}</span>
              @endif
            </a>
          </li>
        </ul>
      </nav>
      <hr/>
      <a href="#modal-change-password" data-toggle="modal" class="btn btn-primary nav-demo-btn"><i class="fa fa-lock"></i> <span class="button-label">&nbsp; Change Password</span></a>
      <a href="#modal-upload-photo" data-toggle="modal" class="btn btn-primary nav-demo-btn upload-photo"><i class="fa fa-camera"></i> <span class="button-label">&nbsp; Upload Photo</span></a>
      <span class="minifyme"> <i class="fa fa-arrow-circle-left hit"></i> </span>

    </aside>
    <!-- END NAVIGATION -->

    <!-- MAIN PANEL -->
    <div id="main" role="main">

      <!-- RIBBON -->
      <div id="ribbon">
        @if ($page == 'Todos')  
          <span class="ribbon-button-alignment"> <span class="btn btn-ribbon" ><i class="fa fa-check"></i></span> </span>

          <!-- breadcrumb -->
          <ol class="breadcrumb">
            <li>
                To-Do Lists            
            </li>
          </ol>
          <!-- end breadcrumb -->
        @endif

      </div>
      <!-- END RIBBON -->

      <!-- MAIN CONTENT -->
      <div id="content">

        @yield("content")

      </div>
      <!-- END MAIN CONTENT -->

    </div>
    <!-- END MAIN PANEL -->

    <!--================================================== -->

    <!-- Modal to change the user password --> 
    <div class="modal fade" id="modal-change-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-primary">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Change Password</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form id="frm-change-password" method="POST" action="">
            <div class="modal-body">
              <div class="alert alert-info"><i class="fa fa-info-circle"></i> Fields with asterisks (*) are required</div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>* New Password</label>
                    <div class="input-group" rel="tooltip" data-placement="bottom" data-original-title="<div class='text-left password-requirement'>Password must meet the following requirements: </br> <i class='has-lower-upper fa-fw fa fa-circle font-xs txt-color-greenLight'></i>Has lower case letters.<br><i class='has-lower-upper fa-fw fa fa-circle font-xs txt-color-greenLight'></i>At least one capital letter.<br><i class='has-number fa-fw fa fa-circle font-xs txt-color-greenLight'></i>Contains at least one number.<br><i class='has-symbol fa-fw fa fa-circle font-xs txt-color-greenLight'></i>Includes at least one symbol.<br></div>" data-html="true" >
                      <input id="txt-change-password-new" type="password" class="form-control" name="password" autocomplete="off" />

                      <div class="font-xs"><span class="pass-label" style="display: none;">Password Strength: </span><strong><span id="result"></span> </strong> </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>* Confirm Password</label>
                    <input id="txt-change-password-confirm" type="password" class="form-control" name="confirm_password" autocomplete="off" />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal to upload the user photo --> 
    <div class="modal fade" id="modal-upload-photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-primary">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Upload Photo</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form id="frm-upload-photo" method="POST" action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="PATCH">
            <input id="hdn-upload-photo-id" type="hidden" value="{{ Session::has('user') ? Session::get('user')->id : '' }}">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div id="pnl-upload-container" class="photo-upload-container">
                    <br/>
                    <center>
                      <h3>Browse Photo...</h3>
                      <div class="row">
                        <div class="col-md-2"></div>
                          <div id="pnl-upload" class="croppie col-md-8">
                        </div>
                        <div class="col-md-2"></div>
                      </div>
                    </center>
                  </div>
                  <div class="buttons croppie">
                    <input id="file-photo-upload" name="file-photo-upload" accept="image/*" class="file-photo" type="file">
                    <center>
                      <button  type="button" class="btn btn-primary croppie-remove"><i class="fa fa-trash"></i> Remove</button>
                      <button  type="button" class="btn btn-primary croppie-rotate" data-deg="-90"><i class="fa fa-undo"></i> Rotate Left</button>
                      <button  type="button" class="btn btn-primary croppie-rotate" data-deg="90"><i class="fa fa-repeat"></i> Rotate Right</button>
                    </center>
                  </div>
                  <br/>
                  <div class="upload-status">
                    <div id="bar" class="progress progress-striped active" role="progressbar">
                      <div class="progress-bar progress-bar-success" style="width: 0%;"> </div>
                    </div>
                    <center>
                      <span>Uploading...</span>
                    </center>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
              <button id="btn-upload-photo" class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-main" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-info" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"></h4>
          </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <br/>
                  <div id="lbl-main"></div>
                  <br/>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

    @if (Session::has('user'))
      <!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
      Note: These tiles are completely responsive,
      you can add as many as you like
      -->
      <div id="shortcut">
        <ul>
          <li>
            <a href="#modal-change-password" data-toggle="modal" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-lock fa-4x"></i> <span>Change Password </span> </span> </a>
          </li>
          <li>
            <a href="#modal-upload-photo" data-toggle="modal" class="jarvismetro-tile big-cubes bg-color-blue upload-photo"> <span class="iconbox"> <i class="fa fa-camera fa-4x"></i> <span>Upload Photo </span> </span> </a>
          </li>
        </ul>
      </div>
      <!-- END SHORTCUT AREA -->
    @endif

    <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
    <script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ asset('/plugins/smartadmin/js/plugin/pace/pace.min.js') }}"></script>

    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    
    <script>
      if (!window.jQuery) {
        document.write('<script src="/plugins/smartadmin/js/libs/jquery-2.0.2.min.js"><\/script>');
      }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
      if (!window.jQuery.ui) {
        document.write('<script src="/plugins/smartadmin/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
      }
    </script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ asset('/plugins/smartadmin/js/bootstrap/bootstrap.min.js') }}"></script>

    <!-- CUSTOM NOTIFICATION -->
    <script src="{{ asset('/plugins/smartadmin/js/notification/SmartNotification.min.js') }}"></script>

    <!-- JARVIS WIDGETS -->
    <script src="{{ asset('/plugins/smartadmin/js/smartwidgets/jarvis.widget.min.js') }}"></script>

    <!-- EASY PIE CHARTS -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

    <!-- SPARKLINES -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- JQUERY VALIDATE -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

    <!-- JQUERY MASKED INPUT -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

    <!-- JQUERY SELECT2 INPUT -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/select2/select2.min.js') }}"></script>

    <!-- JQUERY UI + Bootstrap Slider -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>

    <!-- browser msie issue fix -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

    <!-- FastClick: For mobile devices -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/fastclick/fastclick.js') }}"></script>

    <script src="{{ asset('/js/controls/tab.js') }}"></script>
    <script src="{{ asset('/js/controls/modal.js') }}"></script>

    <!-- MAIN APP JS FILE -->
    <script src="{{ asset('/plugins/smartadmin/js/app.js?version=1.1.18') }}"></script>
    
    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables/jquery.dataTables-cust.min.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables/ColReorder.min.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables/FixedColumns.min.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables/ColVis.min.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables/ZeroClipboard.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables/media/js/TableTools.min.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables/DT_bootstrap.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables-row-reordering/media/js/jquery.dataTables.rowReordering.min.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/datatables-responsive/js/datatables.responsive.js') }}"></script>

    <!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/flot/jquery.flot.cust.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/flot/jquery.flot.tooltip.js') }}"></script>
    
    <!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
    <script src="{{ asset('/plugins/smartadmin/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('/plugins/smartadmin/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <script src="{{ asset('plugins/bootstrap-fileinput/js/plugins/canvas-to-blob.js') }}"></script>
    <script src="{{ asset('plugins/croppie/croppie.js') }}"></script>

    <script src="{{ asset('/js/utilities.js?version=1.1.18') }}"></script>

    <!-- Load JS only when needed by the current page --> 
    @if (isset($page) && $page == 'Todos')
      <script src="{{ asset('js/classes/todo.js?version=1.1.0') }}"></script>

      <script src="{{ asset('js/pages/todos.js?version=1.1.0') }}"></script>
    @elseif (isset($page) && $page == 'Show Todo')
      <script src="{{ asset('js/classes/todo.js?version=1.1.0') }}"></script>
      <script src="{{ asset('js/classes/task.js?version=1.1.0') }}"></script>

      <script src="{{ asset('js/pages/todos/show.js?version=1.1.1') }}"></script>
    @endif

    <script>    
      $(document).ready(function() {
        pageSetUp();    
      });
    </script>
  </body>

</html>