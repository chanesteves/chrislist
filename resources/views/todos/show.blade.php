@extends("layouts.layout")

@section('content')
	<div class="row todo-header">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">
			<h1><strong>{{ $todo->name }}</strong></h1>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center status">
			@php $total = $todo->tasks->count(); @endphp
			@php $done = $todo->tasks()->whereNotNull('done_at')->count(); @endphp

			@if ($total > 0)
				@php $percent = round($done / $total * 100); @endphp
			@else
				@php $percent = 0; @endphp
			@endif

			@if ($percent > 75)
				<span class="label label-success">{{ $percent }}% DONE</span>
			@elseif ($percent > 50)
				<span class="label label-primary">{{ $percent }}% DONE</span>
			@elseif ($percent > 25)
				<span class="label label-warning">{{ $percent }}% DONE</span>
			@else
				<span class="label label-danger">{{ $percent }}% DONE</span>
			@endif
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center buttons">
			<div class="button-group">
				<a href="/todos" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
				<a id="btn-print" href="javascript:void(0)" class="btn btn-lg btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>
			</div>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-md-6">
			<div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
				<header>
					<span class="widget-icon"></span> <center><h2>To Do's</h2></center>
				</header>
				<!-- widget div-->
				<div>
					<!-- widget content -->
					<div class="widget-body">						
				    	<form id="frm-add-task" method="post">
				    		<input type="hidden" id="hdn-add-task-todo-id" value="{{ $todo->id }}" />
				    		<input id="txt-add-task-name" class="form-control input-lg" placeholder="Add New Task" autocomplete="off">
					    </form>
					    <div class="row">
					    	<div class="col-md-12">
							    <div class="pull-right">
							    	<a id="lnk-all-done" class="btn btn-success"><i class="fa fa-check"></i> Mark All As Done</a>
							    </div>
							</div>
						</div>
					    <div class="smart-form task-list todo">
					    	<div class="extra-task"></div>
					    	@foreach($todo->tasks()->whereNull('done_at')->get() as $task)
					    		<div class="task row">
					    			<div class="view-mode">
					    				<div class="col-xs-8">
											<label class="checkbox inline-block">
												<input type="checkbox" data-id="{{ $task->id }}" data-name="{{ $task->name }}" name="checkbox-inline">
												<i></i><span>{{ $task->name }}</span>
											</label>
										</div>
										<div class="col-xs-4">
											<div class="pull-right">
												<a class="btn btn-sm btn-primary task-edit"><i class="fa fa-pencil"></i></a>
												<a class="btn btn-sm btn-danger task-remove"><i class="fa fa-trash"></i></a>
											</div>
										</div>				
									</div>
									<div class="edit-mode">
										<form class="task-edit-form" method="POST">
											<input class="form-control task-edit-name" value="" />
										</form>
									</div>
					    		</div>
					    	@endforeach
					    </div>
					    <br/>
					    <div class="row todo-footer">
					    	<div class="col-md-12">
							    <label>{{ $todo->tasks()->whereNull('done_at')->count() }} item{{ $todo->tasks()->whereNull('done_at')->count() > 1 ? 's' : '' }} left</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
				<header>
					<span class="widget-icon"></span> <center><h2><span class="hidden-xs">Already</span> Done</h2></center>
				</header>
				<!-- widget div-->
				<div>
					<!-- widget content -->
					<div class="widget-body">
						<div class="row">
					    	<div class="col-md-12">
							    <div class="pull-right">
							    	<a id="lnk-all-not-done" class="btn btn-default"><i class="fa fa-times"></i> Mark All As Not Done</a>
							    </div>
							</div>
						</div>
					    <div class="smart-form task-list done">
					    	<div class="extra-task"></div>
					    	@foreach($todo->tasks()->whereNotNull('done_at')->get() as $task)
					    		<div class="task row">
					    			<div class="view-mode">
						    			<div class="col-xs-8">
											<label class="checkbox inline-block">
												<input type="checkbox" data-id="{{ $task->id }}" data-name="{{ $task->name }}" name="checkbox-inline" checked>
												<i></i><del><span>{{ $task->name }}</span></del>
											</label>    			
										</div>
										<div class="col-xs-4">
											<div class="pull-right">
												<a class="btn btn-sm btn-primary task-edit"><i class="fa fa-pencil"></i></a>
												<a class="btn btn-sm btn-danger task-remove"><i class="fa fa-trash"></i></a>
											</div>
										</div>	
									</div>	
									<div class="edit-mode">
										<form class="task-edit-form" method="POST">
											<input class="form-control task-edit-name" value="" />
										</form>
									</div>
					    		</div>
					    	@endforeach
					    </div>
					    <br/>
					    <div class="row done-footer">
					    	<div class="col-md-12">
							    <label>{{ $todo->tasks()->whereNotNull('done_at')->count() }} item{{ $todo->tasks()->whereNotNull('done_at')->count() > 1 ? 's' : '' }} left</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<article class="col-md-12">	
			<div id="modification-area" class="padding-10 well">
				<table id="tbl-modifications" class="table table-striped table-hover">
					<thead>
						<tr>
							<th style="display: none;"></th>
							<th><span class="display-inline"><i class="fa fa-rss text-success"></i> Activity</span></th>									
						</tr>
					</thead>
					<tbody>
						@foreach($modifications as $modification)							
							<tr>
								@php $dt = \Carbon\Carbon::parse($modification->updated_at); @endphp

								<td style="display: none;">
									{{ $dt->format('Y-m-d H:i:s') }}
								</td>
								<td>
									@php $user = $modification->performer; @endphp
						            @php $photo = ''; @endphp

						            @if ($user && $user->person)
						              @php $photo = $user->person->image; @endphp
						            @endif

						            @if (!$photo || $photo == '')
						                @if ($user && $user->person)
						                  @php $photo = '/img/avatars/initials/' . strtoupper($user->person->first_name[0]) . '.png'; @endphp
						                @else
						                  @php $photo = '/img/avatars/initials/G.png'; @endphp
						                @endif
						            @endif

						            <div class="col-xs-2 col-sm-1">
										<img src="{{ $photo }}" alt="me" width="30" class="offline" />
									</div>
									<div class="col-xs-10 col-sm-11">
										<span class="pull-right"><i>{{ $dt->diffForHumans() }}</i></span>
										@if ($modification->type == 'create')
											<span class="label label-primary">Created</span> the task <strong>{{ $modification->task_name }}</strong>
										@elseif ($modification->type == 'update')
											<span class="label label-primary">Edited</span> the task <strong>{{ $modification->task_name }}</strong>
										@elseif ($modification->type == 'destroy')
											<span class="label label-danger">Deleted</span> the task <strong>{{ $modification->task_name }}</strong>
										@elseif ($modification->type == 'done')
											Marked the task <strong>{{ $modification->task_name }}</strong> as <span class="label label-success">Done</span>
										@elseif ($modification->type == 'undone')
											Marked the task <strong>{{ $modification->task_name }}</strong> as <span class="label label-default">Not Done</span>
										@endif
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</article>
	</div>

	<div class="print-todo-paper">
		<div class="well">
			<center><h1><strong class="print-test-title">{{ $todo->name }}</strong></h1></center>
			<br/><br/>
			<ul  class="print-test-list">
			</ul>
		</div>
	</div>

	<iframe name="iframe_todo" id="iframe_todo" width="0" height="0" frameborder="0" src="about:blank">
	</iframe>

	<script type="text/javascript">
		var print_todo_url = "{{ asset('/css/print.css') }}"
		var font_awesome_url = "{{ asset('/plugins/smartadmin/css/font-awesome.min.css') }}"
	</script>
@endsection