<div class="modal fade" tabindex="-1" role="dialog" id="exportModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __("Exportar") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('product.export', 'extension')}}" method="POST" id="export">
                @csrf
                <div class="modal-body">
                    <label for="extension">{{ __("Selecciona el formato") }}</label>
                    <select class="custom-select" id="extension" name="extension">
                        <option value="">--</option>
                        <option value="xlsx">{{ __("XLSX") }}</option>
                        <option value="csv">{{ __("CSV") }}</option>
                        <option value="tsv">{{ __("TSV") }}</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn" form="export">
                        <i class="fa fa-file-excel"></i> {{ __("Exportar") }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
