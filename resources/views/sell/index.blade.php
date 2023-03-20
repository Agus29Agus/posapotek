@extends('layouts.master')

@section('title')
    Sell
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Sell List</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered table-sell">
                    <thead>
                        <th width="5%">No.</th>
                        <th>Date</th>
                        <th>Member Code</th>
                        <th>Total Item</th>
                        <th>Total Price</th>
                        <th>Discount</th>
                        <th>Total Payments</th>
                        <th>Cashier</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('sell.detail')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {
        table = $('.table-sell').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('sell.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'date'},
                {data: 'code_member'},
                {data: 'total_item'},
                {data: 'total_price'},
                {data: 'discount'},
                {data: 'pay'},
                {data: 'cashier'},
                {data: 'action', searchable: false, sortable: false},
            ]
        });

        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'code_product'},
                {data: 'name_product'},
                {data: 'sell_price'},
                {data: 'total'},
                {data: 'subtotal'},
            ]
        })
    });

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
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
</script>
@endpush