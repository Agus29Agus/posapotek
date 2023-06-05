@extends('layouts.master')

@section('title')
    Product
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Product List</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="btn-group">
                    <button onclick="addForm('{{ route('product.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Add</button>
                    <button onclick="deleteSelected('{{ route('product.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Delete</button>
                    {{-- <button onclick="printBarcode('{{ route('product.print_barcode') }}')" class="btn btn-info btn-xs btn-flat"><i class="fa fa-barcode"></i> Print Barcode</button> --}}
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-product">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">No.</th>
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th>Discount</th>
                            <th>Stock</th>
                            <th>Batch</th>
                            <th>Expired Date</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('product.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('product.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'code_product'},
                {data: 'name_product'},
                {data: 'name_category'},
                {data: 'brand'},
                {data: 'buy_price'},
                {data: 'sell_price'},
                {data: 'discount'},
                {data: 'stock'},
                {data: 'batch'},
                {data: 'expired_date'},
                {data: 'action', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Could not save data');
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Add Product');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=name_product]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Product');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=name_product]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=name_product]').val(response.name_product);
                $('#modal-form [name=id_category]').val(response.id_category);
                $('#modal-form [name=brand]').val(response.brand);
                $('#modal-form [name=buy_price]').val(response.buy_price);
                $('#modal-form [name=sell_price]').val(response.sell_price);
                $('#modal-form [name=discount]').val(response.discount);
                $('#modal-form [name=stock]').val(response.stock);
                $('#modal-form [name=batch]').val(response.batch);
                $('#modal-form [name=expired_date]').val(response.expired_date);
            })
            .fail((errors) => {
                alert('Could not show data');
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
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Could not delete data');
                    return;
                });
        }
    }

    function deleteSelected(url) {
        if ($('input:checked').length > 1) {
            if (confirm('Are you sure want to delete selected data?')) {
                $.post(url, $('.form-product').serialize())
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Could not delete data');
                        return;
                    });
            }
        } else {
            alert('Choose data to delete');
            return;
        }
    }

    function printBarcode(url) {
        if ($('input:checked').length < 1) { //ditampilkan per 1 baris
            alert('Choose data to print');
            return;
        } else if ($('input:checked').length < 3) {
            alert('Choose minimal 3 data to print');
            return;
        } else {
            $('.form-product')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush