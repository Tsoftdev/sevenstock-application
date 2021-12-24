@if(count($titles) > 0)
@foreach($titles as $file)
    <hr>
    <div class="row">
        <div class="col-md-12">
            <label class="text-primary">{{ $file->name }}</label>
        </div>
    </div>
    <div class="row">
        <?php 
        $string = strip_tags($file->description);
        if (strlen($string) > 100) {
            $stringCut = substr($string, 0, 100);
            $endPoint = strrpos($stringCut, ' ');
            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '... <a href="javascript:void(0)" class="show-more">show more</a>';
        }
        ?>
        <div class="col-md-12 fileDescription">
            <p class="half-desc"><?php echo $string; ?></p>
            <p class="full-desc" style="display: none"><span>{{ strip_tags($file->description) }}</span><a href="javascript:void(0)" class="show-less">show less</a></p>
        </div>
        <div class="col-md-12 text-right btn-ctn mt-3">
            <a class="btn btn-outline-secondary btn-sm mb-2 copy-btn">
                <i class="fas fa-copy"></i>
            </a>
            <a class="btn btn-outline-secondary btn-sm mb-2 editFile" data-data="{{ $file }}" data-category_id="{{ $file->categories ? ($file->categories->first() ? $file->categories->first()->id : '') : ''}}">
                <i class="fas fa-pencil-alt text-success"></i>
            </a>
            <a href="{{ route('admin.file.delete',$file->id) }}" class="btn btn-outline-secondary btn-sm mb-2" title="Delete" onclick="return confirm('Are you sure?')">
                <i class="fas fa-trash text-danger"></i>
            </a>
        </div>
    </div>
@endforeach
@else
	<hr>
    <div class="row">
        <div class="col-md-12">
            <label class="text-danger">No matching records found</label>
        </div>
    </div>
@endif