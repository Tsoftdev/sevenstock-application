@forelse($feedhistories as $feedhistory)
    <li class="feed-item">
        <div class="feed-item-list">
            <div>
                <div class="date">
                    <span class="text-danger">
                        전체고객기록 - 
                        @if ($feedhistory->feedname == "Stock Transaction")
                            주식이체
                        @elseif ($feedhistory->feedname == "File Transfer")
                            파일전송
                        @elseif ($feedhistory->feedname == "Post Delivery")
                            우편발송
                        @elseif ($feedhistory->feedname == "Visitor Record")
                            방문기록
                        @elseif ($feedhistory->feedname == "Inquery")
                            전체메모
                        @endif
                    </span>  
                    <span class="text-dark">
                        |
                    </span> 
                    <span class="text-dark">
                        {{$feedhistory->date}}
                    </span> 
                </div>
                <p class="activity-text mb-0"><a href="javascript:void(0);" class="text-primary">{{$feedhistory->name}}</a> 
                    @if ($feedhistory->feedname == "Stock Transaction")
                        의 주식이체가 등록 됐습니다.
                    @elseif ($feedhistory->feedname == "File Transfer")
                        의 파일전송이 등록 됐습니다.
                    @elseif ($feedhistory->feedname == "Post Delivery")
                        의 우편발송이 등록 됐습니다.
                    @elseif ($feedhistory->feedname == "Visitor Record")
                        의 방문기록이 등록 됐습니다.
                    @elseif ($feedhistory->feedname == "Inquery")
                        의 메모가 등록 됐습니다.
                    @endif
                    
                </p>
                <p class="mb-0">&#x40; {{$feedhistory->UserName}}</p>
            </div>
        </div> 
    </li>
@empty
    <div style="height: 100px;justify-content: center;align-items: center;" class="alert alert-info align-content-center d-flex align-items-center">
        <p class="text-center">등록된 자료가 없습니다.</p>
    </div>
@endforelse