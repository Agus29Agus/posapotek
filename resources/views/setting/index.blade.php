@extends('layouts.master')

@section('title')
    Setting
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Setting</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <form action="{{ route('setting.update') }}" method="post" class="form-setting" data-toggle="validator" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> Changes saved successfully
                    </div>
                    <div class="form-group row">
                        <label for="name_company" class="col-lg-2 control-label">Company Name</label>
                        <div class="col-lg-6">
                            <input type="text" name="name_company" class="form-control" id="name_company" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-lg-2 control-label">Phone</label>
                        <div class="col-lg-6">
                            <input type="text" name="phone" class="form-control" id="phone" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-lg-2 control-label">Address</label>
                        <div class="col-lg-6">
                            <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="path_logo" class="col-lg-2 control-label">Company Logo</label>
                        <div class="col-lg-4">
                            <input type="file" name="path_logo" class="form-control" id="path_logo"
                                onchange="preview('.show-logo', this.files[0])">
                            <span class="help-block with-errors"></span>
                            <br>
                            <div class="show-logo"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="path_card_member" class="col-lg-2 control-label">Member Card</label>
                        <div class="col-lg-4">
                            <input type="file" name="path_card_member" class="form-control" id="path_card_member"
                                onchange="preview('.show-card-member', this.files[0], 300)">
                            <span class="help-block with-errors"></span>
                            <br>
                            <div class="show-card-member"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="discount" class="col-lg-2 control-label">Discount</label>
                        <div class="col-lg-2">
                            <input type="number" name="discount" class="form-control" id="discount" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="type_nota" class="col-lg-2 control-label">Invoice Type</label>
                        <div class="col-lg-2">
                            <select name="type_nota" class="form-control" id="type_nota" required>
                                <option value="1">Small Invoice</option>
                                <option value="2">Big Invoice</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        showData();

        $('.form-setting').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.ajax({
                    url: $('.form-setting').attr('action'),
                    type: $('.form-setting').attr('method'),
                    data: new FormData($('.form-setting')[0]),
                    async: false,
                    processData: false,
                    contentType: false
                })
                .done(response => {
                    showData();
                    $('.alert').fadeIn();

                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 3000);
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
            }
        });
    });

    function showData() {
        $.get('{{ route('setting.show') }}')
            .done(response => {
                $('[name=name_company]').val(response.name_company);
                $('[name=phone]').val(response.phone);
                $('[name=address]').val(response.address);
                $('[name=discount]').val(response.discount);
                $('[name=type_nota]').val(response.type_nota);
                $('title').text(response.name_company + ' | Setting');
                
                let words = response.name_company.split(' ');
                let word  = '';
                words.forEach(w => {
                    word += w.charAt(0);
                });
                $('.logo-mini').text(word);
                $('.logo-lg').text(response.name_company);

                $('.show-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="200">`);
                $('.show-card-member').html(`<img src="{{ url('/') }}${response.path_card_member}" width="300">`);
                $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
</script>
@endpush