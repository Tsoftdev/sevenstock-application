<div class="row">
    <div class="col-sm-8">
        <div class="justify-content-start d-flex">
            <span>
                <strong>{{$customer->name}}</strong>
            </span>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="justify-content-end d-flex">
            <a href="{{ url ('admin/edit_customer/'.$customer->id) }}">User Info  ></a>
        </div>
    </div>
</div>
<div class="row mt-2 mb-2" id="customer_notify_memo_add_form">
    <div class="col-sm-12 pt-1 pb-1">
        <button class="btn btn-primary w-100 btn-block" id="customer_notify_memo_add"> 메모등록</button>
    </div>
    <!-- <div class="col-sm-3 pt-1 pb-1">
        <button class="btn btn-secondary btn-block w-100 search-memo-data"><i class="fa fa-search"></i></button>
    </div> -->
</div>
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
                                <a class="dropdown-item customer_notify_memo_update" data-id="{{$memo->id}}" href="javascript:void(0);">수정</a>
                                <a class="dropdown-item customer_notify_memo_delete" data-id="{{$memo->id}}" href="javascript:void(0);">삭제</a>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="customer_notify_memo_pin" data-id="{{$memo->id}}"><i class="fas fa-thumbtack {{ $pin == true ? $key == 0 ? 'text-danger' : 'text-dark' : 'text-dark' }}"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row memo-border">
            <p class="card-title-desc">{!! $memo->keyword_name !!}</p>
        </div>
        @if ($memo->company)
        <div class="row memo-border">
            <div class="col-sm-6">
                <div class="justify-content-start d-flex">
                    <span style="padding-top: 3px;">Company</span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="justify-content-end d-flex">
                    <button class="btn btn-primary w-100 btn-sm">{{$memo->company->companyName}}</button>
                </div>
            </div>
        </div>
        @endif
        
    </div>
    <div class="card-footer border">
        <a href="javascript:void(0);" class="btn-link">
            <i class="ion ion-ios-person" style="font-size:16px;"></i>  {{$memo->username}} 
        </a>
        <a href="javascript:void(0);" class="btn-link" style="float:right;">{{$memo->date}}</a> 
    </div>
</div>
@empty
    <p class="text-center">고객 메모를 찾을 수 없습니다..</p>
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
    .memo-keyword {
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        font-family: Inter;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 20px;
        letter-spacing: 0.006em;
        color: #FFFFFF;
    }

    .memo-border {
        border-top:0px;
        border-bottom:1px solid rgba(0, 0, 0, 0.3);
        border-left:1px solid rgba(0, 0, 0, 0.3);
        border-right:1px solid rgba(0, 0, 0, 0.3);
        padding-top: 5px;
        padding-bottom: 5px;
    }

</style>
