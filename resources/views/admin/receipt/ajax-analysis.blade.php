<table id="datatable-analysis" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th></th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Cash</th>
            <th>Card</th>
            <th>Users</th>
        </tr>
    </thead>
    @foreach($groups as $key=>$receipt)
    <tbody>
        <tr>
            <td class="align-middle" style="width: 4%;">
                <a href="javascript:void(0);" onclick="showHideRow('hidden_row{{$key}}');"  class="btn btn-outline-primary btn-sm">
                    <i class="mdi mdi-plus"></i>
                </a>
            </td>
            <td class="bg-light text-primary fw-bold">{{ date('Y.m.d', strtotime($receipt->issueddate)) }}</td>
            <td>{{ number_format($receipt->totalamount) }}</td>
            <td>{{ $receipt->card != null ? number_format($receipt->card) : 0 }}</td>
            <td>{{ $receipt->cash != null ? number_format($receipt->cash) : 0 }}</td>
            <td>{{ number_format($receipt->employee) }}</td>
        </tr> 
    </tbody>
    <tbody id="hidden_row{{$key}}" class="hidden_row text-white" style="background-color: #7a7f83!important;">
        <tr>
            <th></th>
            <th>User Name</th>
            <th>Total Amount</th>
            <th>Cash</th>
            <th>Card</th>
            <th></th>
        </tr>
        @foreach($everyreceipt as $rec)
            @if($receipt->issueddate == $rec->issueddate)
            <tr>
                <td></td>
                <td>{{$rec->employee->name}}</td>
                <td>{{$rec->total}}</td>
                <td>{{$rec->card}}</td>
                <td>{{$rec->cash}}</td>
                <td></td>
            </tr>
            @endif
        @endforeach
    </tbody>
    @endforeach
</table>
<style>
    #datatable-analysis .hidden_row {
        display: none;
    }
</style>
<script>
    var table = $('#datatable-analysis').DataTable({
        ordering: false,
    });
    table.on( 'search.dt', function () {
        $(".hidden_row").css('display', 'none');
    } );
    function showHideRow(row) {
        $("#" + row).toggle();
    }
</script>