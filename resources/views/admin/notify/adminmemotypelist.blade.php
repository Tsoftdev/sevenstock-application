@forelse($memoes as $key =>$memo)
<div class="card"> 
    <div class="card-body border">
        <div class="row mt-1 memo-information">
            <div class="col-sm-10 col-xs-10">
                <p class="card-title-desc">{{$memo->note}}</p>
            </div>
            <div class="col-sm-2 col-xs-2">
                <div class="justify-content-end d-flex">
                    <div class="btn-group">
                        <div class="dropdown me-1">
                            <a href="javascript:void(0);" id="memodrop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ion ion-ios-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="memodrop">
                                <a class="dropdown-item admin_notify_memo_update" data-id="{{$memo->id}}" href="javascript:void(0);">수정</a>
                                <a class="dropdown-item admin_notify_memo_delete" data-id="{{$memo->id}}" href="javascript:void(0);">삭제</a>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="admin_notify_memo_pin" data-id="{{$memo->id}}"><i class="fas fa-thumbtack {{ $pin == true ? $key == 0 ? 'text-danger' : 'text-dark' : 'text-dark' }}"></i></a>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <div class="card-footer border">
        <a href="javascript:void(0);" class="btn-link">
            <i class="ion ion-ios-person" style="font-size:16px;"></i>  {{$memo->name}} 
        </a>
        <a href="javascript:void(0);" class="btn-link" style="float:right;">{{$memo->date}}</a> 
    </div>
</div>
@empty
    <p class="text-center">관리자 메모를 찾을 수 없습니다..</p>
@endforelse
<style>
    .tail-p {
        padding: .375rem .15rem;
    }
    .card-title-desc {
        color: #6c757d;
        margin-bottom: 0px;
        line-height: 1.5;
    }
    .card-body {
        padding: .75rem 1.25rem;
    }
    .bootstrap-tagsinput {
        padding: 3px 6px;
        width: 100%;
    }
    .memo-information {
        min-height: 120px;
        border: 1px solid rgba(0, 0, 0, 0.3);
        border-radius: 5px 5px 0px 0px;
        padding: 5px;
    }
</style>
