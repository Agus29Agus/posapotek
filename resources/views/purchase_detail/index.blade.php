@extends('layouts.master')

@section('title')
    Active Purchase Transaction
@endsection

@push('css')
<style>
    .show-pay {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }
    .show-counted {
        padding: 10px;
        background: #f0f0f0;
    }
    .table-purchase tbody tr:last-child {
        display: none;
    }
    @media(max-width: 768px) {
        .show-pay {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Purchase Transaction</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <table>
                    <tr>
                        <td>Supplier</td>
                        <td>: {{ $supplier->name }}</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>: {{ $supplier->phone }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>: {{ $supplier->address }}</td>
                    </tr>
                </table>
            </div>
            <div class="box-body">
                    
                <form class="form-product">
                    @csrf
                    <div class="form-group row">
                        <label for="code_product" class="col-lg-2">Product Code</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_purchase" id="id_purchase" value="{{ $id_purchase }}">
                                <input type="hidden" name="id_product" id="id_product">
                                <input type="text" class="form-control" name="code_product" id="code_product">
                                <span class="input-group-btn">
                                    <button onclick="showProduct()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-stiped table-bordered table-purchase">
                    <thead>
                        <th width="5%">No</th>
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="15%">Total</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="show-pay bg-primary"></div>
                        <div class="show-counted"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('purchase.store') }}" class="form-purchase" method="post">
                            @csrf
                            <input type="hidden" name="id_purchase" value="{{ $id_purchase }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="pay" id="pay">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="discount" class="col-lg-2 control-label">Discount</label>
                                <div class="col-lg-8">
                                    <input type="number" name="discount" id="discount" class="form-control" value="{{ $discount }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cost" class="col-lg-2 control-label">Cost</label>
                                <div class="col-lg-8">
                                    <input type="text" value="0" id="cost" name="cost" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pay" class="col-lg-2 control-label">Pay</label>
                                <div class="col-lg-8">
                                    <input type="text" id="payrp" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-save"><i class="fa fa-floppy-o"></i> Save Transaction</button>
            </div>
        </div>
    </div>
</div>

@includeIf('purchase_detail.product')
@endsection

@push('scripts')
<script>
    let table, table2;
    $(function () {
        $('body').addClass('sidebar-collapse');
        table = $('.table-purchase').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('purchase_detail.data', $id_purchase) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'code_product'},
                {data: 'name_product'},
                {data: 'buy_price'},
                {data: 'total'},
                {data: 'subtotal'},
                {data: 'action', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#discount').val(),$("#cost").val());
        });
        table2 = $('.table-product').DataTable();
        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let total = parseInt($(this).val());
            if (total < 1) {
                $(this).val(1);
                alert('Total could not less than 1');
                return;
            }
            if (total > 10000) {
                $(this).val(10000);
                alert('Total could not more than 10000');
                return;
            }
            $.post(`{{ url('/purchase_detail') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'total': total
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#discount').val(),$("#cost").val()));
                    });
                })
                .fail(errors => {
                    alert('Could not save data');
                    return;
                });
        });
        $(document).on('input', '#discount', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }
            loadForm($(this).val(),$("#discount").val());
        });
        $(document).on('input', '#cost', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }
            loadForm($("#discount").val(),$(this).val());
        });
        $('.btn-save').on('click', function () {
            $('.form-purchase').submit();
        });
    });
    function showProduct() {
        $('#modal-product').modal('show');
    }
    function hideProduct() {
        $('#modal-product').modal('hide');
    }
    function chooseProduct(id, code) {
        $('#id_product').val(id);
        $('#code_product').val(code);
        hideProduct();
        addProduct();
    }
    function addProduct() {
        $.post('{{ route('purchase_detail.store') }}', $('.form-product').serialize())
            .done(response => {
                $('#code_product').focus();
                table.ajax.reload(() => loadForm($('#discount').val(),$("#cost").val()));
            })
            .fail(errors => {
                alert('Could not save data');
                return;
            });
    }
    function deleteData(url) {
        if (confirm('Are you sure want to delete selected data?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload(() => loadForm($('#discount').val(),$("#cost").val()));
                })
                .fail((errors) => {
                    alert('Could not delete data');
                    return;
                });
        }
    }
    function loadForm(discount = 0, cost =0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());
        let url = `{{ url('/purchase_detail/loadform') }}/${discount}/${$('.total').text()}/${cost}`;
        console.log(url);
        $.get(url)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#payrp').val('Rp. '+ response.payrp);
                $('#pay').val(response.pay);
                $('.show-pay').text('Rp. '+ response.payrp);
                $('.show-counted').text(response.counted);
            })
            .fail(errors => {
                console.log(errors);
                alert('Could not show data');
                return;
            })
    }
</script>
@endpush