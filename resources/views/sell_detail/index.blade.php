@extends('layouts.master')

@section('title')
    Active Transaction
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

    .table-sell tbody tr:last-child {
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
    <li class="active">Active Transaction</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                    
                <form class="form-product">
                    @csrf
                    <div class="form-group row">
                        <label for="code_product" class="col-lg-2">Product Code</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_sell" id="id_sell" value="{{ $id_sell }}">
                                <input type="hidden" name="id_product" id="id_product">
                                <input type="text" class="form-control" name="code_product" id="code_product">
                                <span class="input-group-btn">
                                    <button onclick="showProduct()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-stiped table-bordered table-sell">
                    <thead>
                        <th width="5%">No.</th>
                        <th>Product Code</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="15%">Total</th>
                        <th>Discount</th>
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
                        <form action="{{ route('transaction.save') }}" class="form-sell" method="post">
                            @csrf
                            <input type="hidden" name="id_sell" value="{{ $id_sell }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="pay" id="pay">
                            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="code_member" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="code_member" value="{{ $memberSelected->code_member }}">
                                        <span class="input-group-btn">
                                            <button onclick="showMember()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="discount" class="col-lg-2 control-label">Discount</label>
                                <div class="col-lg-8">
                                    <input type="number" name="discount" id="discount" class="form-control" 
                                        value="{{ ! empty($memberSelected->id_member) ? $discount : 0 }}" 
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pay" class="col-lg-2 control-label">Pay</label>
                                <div class="col-lg-8">
                                    <input type="text" id="payrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="receive" class="col-lg-2 control-label">Received</label>
                                <div class="col-lg-8">
                                    <input type="number" id="receive" class="form-control" name="receive" value="{{ $sell->receive ?? 0 }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="change" class="col-lg-2 control-label">Change</label>
                                <div class="col-lg-8">
                                    <input type="text" id="change" name="change" class="form-control" value="0" readonly>
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

@includeIf('sell_detail.product')
@includeIf('sell_detail.member')
@endsection

@push('scripts')
<script>
    let table, table2;

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-sell').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaction.data', $id_sell) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'code_product'},
                {data: 'name_product'},
                {data: 'sell_price'},
                {data: 'total'},
                {data: 'discount'},
                {data: 'subtotal'},
                {data: 'action', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        .on('draw.dt', function () {
            loadForm($('#discount').val());
            setTimeout(() => {
                $('#receive').trigger('input');
            }, 300);
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

            $.post(`{{ url('/transaction') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'total': total
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#discount').val()));
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

            loadForm($(this).val());
        });

        $('#receive').on('input', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($('#discount').val(), $(this).val());
        }).focus(function () {
            $(this).select();
        });

        $('.btn-save').on('click', function () {
            $('.form-sell').submit();
        });
    });

    function showProduct() {
        $('#modal-product').modal('show');
    }

    function hideProduct() {
        $('#modal-product').modal('hide');
    }

    function chooseProduct(id, kode) {
        $('#id_product').val(id);
        $('#code_product').val(kode);
        hideProduct();
        addProduct();
    }

    function addProduct() {
        $.post('{{ route('transaction.store') }}', $('.form-product').serialize())
            .done(response => {
                $('#code_product').focus();
                table.ajax.reload(() => loadForm($('#discount').val()));
            })
            .fail(errors => {
                alert('Could not save data');
                return;
            });
    }

    function showMember() {
        $('#modal-member').modal('show');
    }

    function chooseMember(id, kode) {
        $('#id_member').val(id);
        $('#code_member').val(kode);
        $('#discount').val('{{ $discount }}');
        loadForm($('#discount').val());
        $('#receive').val(0).focus().select();
        hideMember();
    }

    function hideMember() {
        $('#modal-member').modal('hide');
    }

    function deleteData(url) {
        if (confirm('Are you sure want to delete selected data?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload(() => loadForm($('#discount').val()));
                })
                .fail((errors) => {
                    alert('Could not delete data');
                    return;
                });
        }
    }

    function loadForm(discount = 0, receive = 0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaction/loadform') }}/${discount}/${$('.total').text()}/${receive}`)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#payrp').val('Rp. '+ response.payrp);
                $('#pay').val(response.pay);
                $('.show-pay').text('Pay: Rp. '+ response.payrp);
                $('.show-counted').text(response.counted);

                $('#change').val('Rp.'+ response.changerp);
                if ($('#receive').val() != 0) {
                    $('.show-pay').text('Change: Rp. '+ response.changerp);
                    $('.show-counted').text(response.change_counted);
                }
            })
            .fail(errors => {
                alert('Could not retrieve data');
                return;
            })
    }
</script>
@endpush