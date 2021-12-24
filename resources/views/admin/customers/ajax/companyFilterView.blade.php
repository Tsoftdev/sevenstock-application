@if($stocks->count() > 0)
	@foreach($stocks as $stock)
	    <tr>
	        <td>
	            <input type="checkbox" name="stock_transfer_id[]" class="form-check-input selectCheckbox" value="{{ $stock->id }}" />
	        </td>
	        <td class="align-middle">{{ $stock->date }}</td>
	        <td class="align-middle bg-light text-primary fw-bold">
	        	<a href="javascript:void(0);" class="stock_edit" data-id="{{$stock->id}}">
	        		{{ $stock->company ? $stock->company->companyName : '' }}
	        	</a>
	        </td>
	        <td class="align-middle">{{ number_format($stock->stockPrice) }}</td>
	        <td class="align-middle">{{ number_format($stock->quantity) }}</td>
	        <td class="align-middle">{{ number_format($stock->invested) }}</td>

	        <td class="align-middle">
	            <a class="image-popup-vertical-fit" href="{{ $stock->picture }}">
	                <img src="{{ $stock->picture }}" width="30">
	            </a>
	        </td>
	        <td class="align-middle">{{ $stock->admin ? $stock->admin->name : '' }}</td>
	        <td class="align-middle">
	            @if($stock->status == "Active")
	                <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_stock_status" data-status="{{ $stock->status }}" data-id="{{ $stock->id }}">Completed</a>
	            @elseif ($stock->status == "Pending")
	                <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_stock_status w-50" data-status="{{ $stock->status }}" data-id="{{ $stock->id }}">Pending</a>
	            @elseif ($stock->status == "Canceled")
	                <a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_stock_status w-50" data-status="{{ $stock->status }}" data-id="{{ $stock->id }}">Cancel</a>
	            @endif
	        </td>
	        <th class="align-middle text-center">
	            @if($stock->status == "Active")
	                <label class="form-check-label ">
	                    <input type="checkbox" class="form-check-input active" checked>
	                </label>
	            @elseif ($stock->status == "Pending")
	                <label class="form-check-label">
	                    <input type="checkbox" class="form-check-input">
	                </label>
	            @elseif ($stock->status == "Canceled")
	                <label class="form-check-label">
	                    <input type="checkbox" class="form-check-input">
	                </label>
	            @endif
	        </th>
	    </tr>
	@endforeach
@else
	<tr>
		<td colspan="10" class="text-center text-danger">No data available in table</td>
	</tr>
@endif