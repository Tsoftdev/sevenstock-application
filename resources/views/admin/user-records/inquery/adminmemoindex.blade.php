@forelse($memoes as $key=>$memo)
<div class="card"> 
    <div class="card-body border">
        <div class="row mt-1 mb-2">
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
                                <a class="dropdown-item customer_memo_update" data-id="{{$memo->id}}" href="javascript:void(0);">수정</a>
                                <a class="dropdown-item customer_memo_delete" data-id="{{$memo->id}}" href="javascript:void(0);">삭제</a>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="customer_memo_pin" data-id="{{$memo->id}}"><i class="fas fa-thumbtack {{ $key == 0 ? $pinned ? 'text-danger' : 'text-dark' : 'text-dark'}}"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-1 mb-2" style="height:1px;">
        <div class="row">
            <p class="card-title-desc">{!! $memo->keyword_name !!}</p>
        </div>
        
    </div>
    <div class="card-footer border">
        <a href="javascript:void(0);" class="btn-link">
            <img src="https://img.icons8.com/cotton/2x/gender-neutral-user--v2.png" class="img-rounded" width="20">  {{$memo->username}} 
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

</style>
