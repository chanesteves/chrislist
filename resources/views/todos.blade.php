@extends("layouts.layout")

@section('content')
	<div class="alert alert-info">
		<i class="fa fa-info-circle"></i> This screen lets you manage (add, edit, archive, view) multiple task lists.
	</div>

	<ul class="nav nav-tabs bordered">
		<li class="active">
			<a href="#active" data-toggle="tab">
				Active
				<span class="badge bg-color-green">{{ $todos->count() }}</span>
			</a>
		</li>
		<li>
			<a href="#archive" data-toggle="tab">
				Archive
				<span class="badge bg-color-red">{{ $archives->count() }}</span>
			</a>			
		</li>
	</ul>

	<div class="tab-content padding-10">
		<div class="tab-pane fade in active" id="active">
			<!-- widget grid -->
			<section id="widget-grid" class="">
			
				<!-- row -->
				<div class="row">
					<!-- NEW WIDGET START -->
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-12 col-sm-6 col-md-4">
					      <div class="card">
					        <div class="card-body">
					          <div class="blank">
					            <br/><br/><br/><br/>
					            <center>
					              <a href="#modal-add-todo" data-toggle="modal"><i class="fa fa-plus fa-4x"></i></a>
					              <br/><br/><span class="subtitle">(Click to add new to-do list)</span>
					            </center>
					          </div>
					        </div>
					      </div>
					    </div>
						@foreach($todos as $todo)
					      <div class="col-xs-12 col-sm-6 col-md-4">
					        <div class="card">
					          <div class="card-body">
					            <div class="card-cover">
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
					              	<h2>{{ $todo->name }}</h2>
					              	<i class="fa fa-check-circle"></i> {{ $done }}/{{ $total }} tasks
					            </div>
					            <div class="actions">
					              <div class="row">
					              	<div class="col-xs-4 text-center">
					                  <a class="todo-view" data-id="{{ $todo->id }}" href="/todos/{{ $todo->slug }}" ><i class="fa fa-eye"></i> View</a>
					                </div>
					                <div class="col-xs-4 text-center">
					                  <a class="todo-edit" data-id="{{ $todo->id }}" href="#modal-edit-todo" data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
					                </div>
					                <div class="col-xs-4 text-center">
					                  <a href="javascript:void(0);" class="todo-remove" data-id="{{ $todo->id }}"><i class="fa fa-trash"></i> Archive</a>
					                </div>
					              </div>
					            </div>
					          </div>
					        </div>
					      </div>
					    @endforeach
					</article>
				</div>
			</section>
		</div>
		<div class="tab-pane fade" id="archive">
			<!-- widget grid -->
			<section id="widget-grid" class="">
			
				<!-- row -->
				<div class="row">
					<!-- NEW WIDGET START -->
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						@if ($archives->count() == 0)
							<center><h3>No archives yet.</h3></center>
						@endif

						@foreach($archives as $archive)
					      <div class="col-xs-12 col-sm-6 col-md-4">
					        <div class="card">
					          <div class="card-body">
					            <div class="card-cover">
					            	@php $total = $archive->tasks->count(); @endphp
									@php $done = $archive->tasks()->whereNotNull('done_at')->count(); @endphp

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
					              	<h2>{{ $archive->name }}</h2>
					              	<i class="fa fa-check-circle"></i> {{ $done }}/{{ $total }} tasks
					            </div>
					            <div class="actions">
					              <div class="row">
					                <div class="col-xs-12 text-center">
					                  <a href="javascript:void(0);" class="todo-restore" data-id="{{ $archive->id }}"><i class="fa fa-undo"></i> Restore</a>
					                </div>
					              </div>
					            </div>
					          </div>
					        </div>
					      </div>
					    @endforeach
					</article>
				</div>
			</section>
		</div>
    </div>
  </div>

  <div class="modal fade" id="modal-add-todo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-primary">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add To-Do List</h4>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form id="frm-add-todo" method="POST" action="">
          <div class="modal-body">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Fields with asterisks (*) are required</div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>* Name</label>
                  <input id="txt-add-todo-name" type="text" class="form-control input-lg" name="name" autocomplete="off" />
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

  <div class="modal fade" id="modal-edit-todo" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-primary">
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Edit To-Do List</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>					
				</div>
				<form id="frm-edit-todo" method="post" action="" >
					<div class="modal-body">
						<div class="alert alert-info"><i class="fa fa-info-circle"></i> Fields with asterisks are required.</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input id="hdn-edit-todo-id" type="hidden" name="id">
						<br/>
						<div class="row">
							<div class="col-md-12">
				                <div class="form-group">
				                  <label>* Name</label>
				                  <input id="txt-edit-todo-name" type="text" class="form-control input-lg" name="name" autocomplete="off" />
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
@endsection