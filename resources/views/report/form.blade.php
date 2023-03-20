<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('report.index') }}" method="get" data-toggle="validator" class="form-horizontal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Periode Report</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="date_begin" class="col-lg-2 col-lg-offset-1 control-label">Date Begin</label>
                        <div class="col-lg-6">
                            <input type="text" name="date_begin" id="date_begin" class="form-control datepicker" required autofocus
                                value="{{ request('date_begin') }}"
                                style="border-radius: 0 !important;">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_end" class="col-lg-2 col-lg-offset-1 control-label">Date End</label>
                        <div class="col-lg-6">
                            <input type="text" name="date_end" id="date_end" class="form-control datepicker" required
                                value="{{ request('date_end') ?? date('Y-m-d') }}"
                                style="border-radius: 0 !important;">
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