@extends('crm.layouts.template')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('dashboard', $companyCode) }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Deals</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Deals </h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if( hasDailyLimit('deal'))
                        @include('crm.common.common_add_btn')
                        @else
                        <div class="text-danger">You have reached daily limit.You cannot add deals.</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-centered w-100 dt-responsive nowrap" id="deals-datatable">
                                <thead class="table-primary">
                                    <tr>
                                        <th> Title </th>
                                        <th> Deal No </th>
                                        <th> Customer </th>
                                        <th> Expected Delivery </th>
                                        <th> Assigned To</th>
                                        <th> Status </th>
                                        <th style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div>
        </div>
    </div>
@endsection
@section('add_on_script')
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/demo.deals.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            "use strict";

            const roletable = $('#deals-datatable').DataTable({

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= route('deals.list', $companyCode) ?>",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        "_token": "<?= csrf_token() ?>"
                    }
                },
                "columns": [
                    {
                        "data": "title"
                    },
                    {
                        "data": "deal_no"
                    },
                    {
                        "data": "customer"
                    },
                    {
                        "data": "expected_delivery"
                    },
                    {
                        "data": "assigned_to"
                    },
                    {
                        "data": "status"
                    },
                    {
                        "data": "action"
                    },
                ],
                "pageLength": 25,
                aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [-1]
                }]

            });
        });

        function ReloadDataTableModal(id) {
            var roletable = $('#' + id).DataTable();
            var currentPage = roletable.page();

            roletable.ajax.reload(function() {
                // After the reload, set the DataTable back to the previous page
                roletable.page(currentPage).draw('page');
            });
        }
    </script>
@endsection
