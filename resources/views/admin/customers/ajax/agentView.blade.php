<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">{{ ucfirst(request()->type) }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div style="border-bottom: 2px dashed #dcdbdb;">
        {{ Form::open(array('url' => 'admin/new-group','files' => true,'id'=>'infoSubForm', 'class'=>'pb-4')) }}
            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">Name</label>
                    {{ Form::text('groupName',null,array('class'=>'form-control','id'=>'groupName')) }}
                </div>
            </div>
            <div class="text-right">
                <input type="hidden" name="type_id" id="type_id" value="0">
                <input type="hidden" name="type"value="{{ request()->type }}">
                <button type="submit" class="btn btn-primary w-25">등록<i class="fa fa-spinner fa-spin" style="display:none;"></i>
            </button>
            </div>
        {{ Form::close() }}
    </div>
    <div class="table-responsive pt-3">
        <a href="javascript:void(0);" data-type="delete_agents" class="btn btn-danger btn-sm deleteMultipleRecord mb-2"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
        <form id="deleteAllAgentForm" action="{{ url('admin/delete/all/agents') }}" method="post">
            @csrf
            <table class="table">
                @foreach($agents as $agent)
                    <tr>
                        <td>
                            <div class="form-check">
                                <label for="agent_id_{{ $agent->id }}">
                                    <input name="agent_id[]" id="agent_id_{{ $agent->id }}" value="{{ $agent->id }}" class="form-check-input" type="checkbox">{{ $agent->groupName }}
                                </label>
                            </div>
                        </td>
                        <td class="text-right actions">
                            <a class="editAgent" data-data="{{ $agent }}" href="javascript:void(0);">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>&nbsp;
                            <a class="deleteRecord" href="{{ url('admin/agent/delete/'.$agent->id) }}">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
    </div>
</div>