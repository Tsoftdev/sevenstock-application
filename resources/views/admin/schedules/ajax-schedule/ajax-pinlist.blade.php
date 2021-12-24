@forelse($pinneds as $key=>$pinned)
    <div class="row">
        <p class="pin-description">
            {{$pinned->message}}
        </p>
        
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-6">
            <div class="d-flex mb-1">
                <div class="flex-grow-1 align-self-center">
                    <h4 class="font-size-13 pin-user m-0">{{$pinned->UserName}}</h4>
                    
                </div>
            </div>
        </div>    
        <div class="col-sm-6 col-xs-6">
            <div class="justify-content-end d-flex">
                <div class="btn-group">
                    <div class="dropdown me-1">
                        <a href="javascript:void(0);" id="pinneddrop" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ion ion-ios-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="pinneddrop">
                            <a class="dropdown-item pinned_update" data-id="{{$pinned->id}}" href="javascript:void(0);">수정</a>
                            <a class="dropdown-item pinned_delete" data-id="{{$pinned->id}}" href="javascript:void(0);">삭제</a>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="pinned_pin" data-id="{{$pinned->id}}"><i class="fas fa-thumbtack {{ $key == 0 ? $ped ? 'text-danger' : 'text-dark' : 'text-dark' }}"></i></a>
                </div>
            </div>
            <div class="justify-content-end d-flex">
                <small class="pin-user">{{$pinned->created_at_date}} at {{$pinned->created_at_time}}</small>
            </div>
        </div>    
    </div>
    
    <hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
    
@empty
<p class="text-center">등록된 자료가 없습니다.</p>    
@endforelse

<div class="d-flex justify-content-center">
    {!! $pinneds->links() !!}
</div>
<style>
    .pin-user {
        font-family: Inter;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 20px;
        letter-spacing: 0.6px;
        color: #92929D;
    }
    .pin-description {
        font-family: Inter;
        font-style: normal;
        font-weight: normal;
        line-height: 20px;
        font-size: 14px;
        letter-spacing: 0.6px;
        color: #000000;
        opacity: 0.77;
    }
</style>