@forelse($total_statistis as $key=>$total)
<div class="mb-3">
    <label class="form-label">
        <span class="text-dark bold">{{$key+ 1}}. {{$total->companyName}}</span>
        <span class="text-danger">|</span> 
        {{number_format($total->amount)}} 원</label>
    <div class="progress" style="height: 16px;">
        <div class="progress-bar" role="progressbar" style="width: {{$total->percent}}%; background-color:{{$total->backgroundColor}}" aria-valuenow="{{$total->percent}}" aria-valuemin="0" aria-valuemax="100">{{$total->percent}}%</div>
    </div>
</div>
@empty
<p class="text-center">등록된 자료가 없습니다.</p>    
@endforelse