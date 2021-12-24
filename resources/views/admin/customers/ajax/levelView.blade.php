<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">{{ ucfirst(request()->type) }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div style="border-bottom: 2px dashed #dcdbdb;">
        {{ Form::open(array('url' => 'admin/new-level','files' => true,'id'=>'infoSubForm', 'class'=>'pb-4')) }}
            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">Name</label>
                    {{ Form::text('levelName',null,array('class'=>'form-control','id'=>'levelName')) }}
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
        <a href="javascript:void(0);" data-type="delete_levels" class="btn btn-danger btn-sm deleteMultipleRecord mb-2"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
        <form id="deleteAllLevelForm" action="{{ url('admin/delete/all/levels') }}" method="post">
            @csrf
            <table class="table">
                @foreach($levels as $level)
                    <tr>
                        <td>
                            <div class="form-check">
                                <label for="level_id_{{ $level->id }}">
                                    <input name="level_id[]" id="level_id_{{ $level->id }}" value="{{ $level->id }}" class="form-check-input" type="checkbox">{{ $level->levelName }}
                                </label>
                            </div>
                        </td>
                        <td class="text-right actions">
                            <a class="editLevel" data-data="{{ $level }}" href="javascript:void(0);">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>&nbsp;
                            <a class="deleteRecord" href="{{ url('admin/level/delete/'.$level->id) }}">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
    </div>
</div>