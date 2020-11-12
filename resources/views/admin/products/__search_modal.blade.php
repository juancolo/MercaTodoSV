<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Filtrar por</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="searchForm" action="{{ route('products.index') }}" method="get">
                    <input type="hidden" id="format" name="format">
                    <div class="form-group row">
                        <div class="col">
                            <label>{{ __("Nombre") }}</label>
                            <input type="hidden" id="old_product_name" name="old_product_name" value="{{ $request->get('product') }}">
                            <input type="hidden" id="old_id" name="old_id" value="{{ $request->get('id') }}">
                            <v-select v-model="old_product_values" label="name" :filterable="false" :options="options" @search="searchProduct"
                                      class="form-control">
                                <template slot="no-options">
                                    {{ __("Ingresa el nombre...") }}
                                </template>
                            </v-select>
                            <input type="hidden" name="product" id="product" :value="(old_product_values) ? old_product_values.name : '' ">
                            <input type="hidden" name="id" id="id" :value="(old_product_values) ? old_product_values.id : '' ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="per_page">{{ __("Registros por página") }}</label>
                            <select id="per_page" name="per_page" class="form-control">
                                @for($i = 10; $i <= 100; $i += 10)
                                    <option value="{{ $i }}" {{ $products->perPage() == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{ __("Cerrar") }}
                </button>
                <button type="submit" form="searchForm" class="btn btn-primary">
                    <i class="fa fa-search"></i> {{ __("Buscar") }}
                </button>
            </div>
        </div>
    </div>
</div>
