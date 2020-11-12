<div class="modal fade" id="import">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="importProductsForm" action="{{route('product.import', 'file')}}" method="POSt" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4>{{__('New import')}}</h4>
                    <button class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="custom-file">
                        <input type="file"
                               class="custom-file-input"
                               id="file"
                               name="file">
                        <label class="custom-file-label" for="importFile">@lang('Upload a file')</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" form="importProductsForm">{{__('Import')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
