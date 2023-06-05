<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name_product" class="col-lg-2 col-lg-offset-1 control-label">Name</label>
                        <div class="col-lg-6">
                            <input type="text" name="name_product" id="name_product" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_category" class="col-lg-2 col-lg-offset-1 control-label">Category</label>
                        <div class="col-lg-6">
                            <select name="id_category" id="id_category" class="form-control" required>
                                <option value="">Pilih category</option>
                                @foreach ($category as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brand" class="col-lg-2 col-lg-offset-1 control-label">Brand</label>
                        <div class="col-lg-6">
                            <input type="text" name="brand" id="brand" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="buy_price" class="col-lg-2 col-lg-offset-1 control-label">Buy Price</label>
                        <div class="col-lg-6">
                            <input type="number" name="buy_price" id="buy_price" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sell_price" class="col-lg-2 col-lg-offset-1 control-label">Sell Price</label>
                        <div class="col-lg-6">
                            <input type="number" name="sell_price" id="sell_price" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="discount" class="col-lg-2 col-lg-offset-1 control-label">Discount</label>
                        <div class="col-lg-6">
                            <input type="number" name="discount" id="discount" class="form-control" value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stock" class="col-lg-2 col-lg-offset-1 control-label">Stock</label>
                        <div class="col-lg-6">
                            <input type="number" name="stock" id="stock" class="form-control" required value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="batch" class="col-lg-2 col-lg-offset-1 control-label">Batch</label>
                        <div class="col-lg-6">
                            <input type="number" name="batch" id="batch" class="form-control" required value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="expired_date" class="col-lg-2 col-lg-offset-1 control-label">Expired Date</label>
                        <div class="col-lg-6">
                            <input type="date" name="expired_date" id="expired_date" class="form-control" required value="0">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>