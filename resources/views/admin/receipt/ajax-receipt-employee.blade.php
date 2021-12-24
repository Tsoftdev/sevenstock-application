<div class="invoice-wid">
    @foreach($employees as $employee)
    <a href="javascript:void(0);" data-id="{{$employee->id}}" data-status="{{$employee->status}}" class="text-dark invoiceone">
        <div class="invoice-item">
            <div class="float-start me-3">
                <p class="invoice-item-text mb-0">
                    <span>{{ date('m.d', strtotime($employee->issueddate)) }}</span>
                </p>
            </div>
            <div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="invoice-item-author mb-1 font-size-14">{{$employee->employee->name}}</h6>
                        <p class="invoice-item-text text-muted mb-0">
                            <span>{{$employee->category}}</span>
                            <span>|</span>
                            <span>
                                @if($employee->payment == "CD")
                                Card
                                @elseif($employee->payment == "CH")
                                Cash
                                @endif
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <ul class="no-list-style">
                            @if($employee->status == "A")
                            <li class="receipt-info text-end fw-bold text-danger">{{number_format($employee->receiptitem()->sum('total'))}} 원</li>
                            <li class="receipt-status text-end fw-bold" style="color:#0faf43;">Completed</li>
                            @elseif($employee->status == "P")
                            <li class="receipt-info text-end fw-bold text-danger">{{number_format($employee->receiptitem()->sum('total'))}} 원</li>
                            <li class="receipt-status text-end fw-bold" style="color:#0014ff;">Pending</li>
                            @elseif($employee->status == "R")
                            <li class="receipt-info text-end fw-bold text-dark text-decoration-line-through">{{number_format($employee->receiptitem()->sum('total'))}} 원</li>
                            <li class="receipt-status text-end fw-bold" style="color:#343a40;">Rejected</li>
                            @elseif($employee->status == "PP")
                            <li class="receipt-info text-end fw-bold text-danger">{{number_format($employee->receiptitem()->sum('total'))}} 원</li>
                            <li class="receipt-status text-end fw-bold" style="color:#0014ff;">Pending(Photo)</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>