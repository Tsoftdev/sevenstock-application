@forelse($contacts as $contact)
<div class="p-1">
    <div class="row mb-2">
        <div class="date">
            <span class="text-dark">
                {{$contact->date}}
            </span>  
            <span class="text-dark ms-3">
                |
            </span> 
            <span class="text-dark ms-3">
                {{$contact->name}}
            </span> 
            <span class="text-dark ms-3">
                |
            </span> 
            <span class="text-dark ms-3">
                {{$contact->phone_number}}
            </span> 
        </div> 
    </div>
    <div class="row mb-2">
        <textarea class="form-control" type="text" rows="3" placeholder="Content will be on here.">{{$contact->inquiry}}</textarea>
    </div>
    <div class="row">
        <div class="justify-content-end d-flex">
            <a href="javascript:void(0);" class="btn btn-primary me-2 btn-sm btn_new_user" data-cuser="{{$contact->name}}" data-cphone="{{$contact->phone_number}}"> 유저로 등록</a>
            <a href="javascript:void(0);" class="btn btn-secondary btn-sm btn_delete_contact"> 삭제</a>
        </div>
    </div>
</div>
<hr class="mb-3" style="height:2px;">
@empty
    <div style="height: 100px;justify-content: center;align-items: center;" class="alert alert-info align-content-center d-flex align-items-center">
        <p class="text-center">등록된 자료가 없습니다.</p>
    </div>
@endforelse