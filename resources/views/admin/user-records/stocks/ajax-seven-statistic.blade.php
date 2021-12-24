<table id="datatable-all" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th></th>
            <th>이름</th>
            <th>지역</th>
            <th>전화번호</th>
            <th>경험</th>
            <!-- <th>평균 주가금액</th>
            <th>총 주식 수</th> -->
            <th>총 투자금액</th>
            <th>투자 가능 유동성 자금</th>
            <th>주식투자경력</th>
            <th>상장주식 투자 수익률</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stocks as $key=>$stock)
        <tr>
            <td class="align-middle" style="width: 4%;">
                <a href="javascript:void(0);" onclick="showHideRow('hidden_row{{$key}}');"  class="btn btn-outline-primary btn-sm">
                    <i class="mdi mdi-plus"></i>
                </a>
            </td>
            <td class="bg-light text-primary fw-bold"><a href="{{ url('admin/edit_customer/'.$stock->user->id) }}" >{{ $stock->name }}</a></td>
            <td>{{ $stock->user->customerCity != null ? $stock->user->customerCity->cityName : "" }}</td>
            <td>{{ $stock->phonenumber1 }}</td>
            <td>{{ $stock->user->levelExp != null ? $stock->user->levelExp->levelName : "" }}</td>
            <!-- <td>{{ number_format($stock->stockPrice) }}</td>
            <td>{{ number_format($stock->quantity) }}</td> -->
            <td>{{ number_format($stock->invested) }}</td>
            <td>{{ $stock->user->investable_liquid_funds != null ? $stock->user->investable_liquid_funds : "" }}</td>
            <td>{{ $stock->user->stock_investment_experience != null ? $stock->user->stock_investment_experience : "" }}</td>
            <td>{{ $stock->user->return_on_investment != null ? $stock->user->return_on_investment : "" }}</td>
        </tr>
        <tr id="hidden_row{{$key}}" class="hidden_row">
            <td></td>
            <td colspan=6>
                <div class="row">
                    @foreach($companies as $company)
                    <div class="col-md-3 p-1">
                        <a data-id="1" class="btn btn-outline-secondary waves-effect w-100 hover" href="javascript:void(0);">{{$company->companyName}} : <span class="fw-bold text-danger">{{ $company->stocks ? number_format($company->stocks->sum('invested')) : 0 }} 원</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </td>
            <td></td>
        </tr>
        @empty
        <!-- <tr>
            <p class="text-center">등록된 자료가 없습니다.</p>
        </tr> -->
        @endforelse
    </tbody>
</table>
<style>
    #datatable-all .hidden_row {
        display: none;
    }
</style>
<script>
    function showHideRow(row) {
        $("#" + row).toggle();
    }
</script>