<style>
    tbody, td {
   
    vertical-align: middle !important;
}
</style>
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card text-center" v-if="orderDetails.lastOrder">
            <div class="card-body">
                <h4 class="header-title mb-3">Last Order Summary</h4>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th> Date </th>
                                <th> Order No </th>
                                <th> Invoice No </th>
                                <th> Product </th>
                                <th> Price </th>
                                <th> Qty </th>
                                <th> Payment Status </th>
                                <th> Order Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">
                                   @{{ orderDetails.lastOrder.date }}
                                </td>
                                <td class="align-middle"> @{{ orderDetails.lastOrder.orderNo }} </td>
                                <td class="align-middle">
                                    <span class="label label-info-lighten"> @{{ orderDetails.lastOrder.invoiceNo }} </span>
                                     <span>
                                        <a :href="orderDetails.lastOrder.file"
                                                target="_blank" data-bs-container="#tooltip-container9"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                class="btn btn-link text-muted btn-lg px-1"
                                                data-bs-original-title="Download">
                                                <i class="uil uil-cloud-download text-success"></i>
                                            </a>
                                    </span>
                                </td>
                                <td class="align-middle"> @{{ orderDetails.lastOrder.product }} </td>
                                <td class="align-middle"> @{{ orderDetails.lastOrder.price }} </td>
                                <td class="align-middle"> @{{ orderDetails.lastOrder.qty }} </td>
                                <td class="align-middle">
                                    <h5>
                                        <span class="badge badge-danger-lighten" v-if="orderDetails.lastOrder.payment_status == 'Failed'">

                                            <i class="mdi mdi-bitcoin"></i>
                                            @{{ orderDetails.lastOrder.payment_status }}
                                        </span>
                                        <span class="badge badge-success-lighten" v-else>
                                            <i class="mdi mdi-bitcoin"></i>
                                            @{{ orderDetails.lastOrder.payment_status }}
                                        </span>
                                           
                                    </h5>
                                </td>
                                <td class="align-middle">
                                    <h5>
                                        <span class="badge badge-success-lighten" v-if="orderDetails.lastOrder.order_status == 'Completed'">
                                            <i class="mdi mdi-bitcoin"></i>
                                            @{{ orderDetails.lastOrder.order_status }} 
                                        </span>
                                        <span class="badge badge-danger-lighten" v-else>
                                            <i class="mdi mdi-bitcoin"></i>
                                            @{{ orderDetails.lastOrder.order_status }} 
                                        </span>
                                    </h5>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->

            </div> <!-- end card-body -->
        </div> <!-- end card -->

        <div class="card text-center" v-if="orderDetails.pendingApproval">
            <div class="card-body">
                <h4 class="header-title mb-3">Pending Invoice Approval</h4>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th> Date </th>
                                <th> Invoice No </th>
                                <th> Product </th>
                                <th> Price </th>
                                <th> Qty </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pending in orderDetails.pendingApproval">
                                <td class="align-middle">
                                    @{{ pending.date }}
                                </td>
                                <td class="align-middle"> @{{ pending.invoiceNo }}</td>
                                <td class="align-middle"> @{{ pending.product }} </td>
                                <td class="align-middle"> @{{ pending.price }} </td>
                                <td class="align-middle"> @{{ pending.qty }} </td>
                                <td class="align-middle">
                                    <div class="col-auto" id="tooltip-container9">
                                        <!-- Button -->
                                        <a :href="pending.file"
                                            target="_blank" data-bs-container="#tooltip-container9"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                            class="btn btn-link text-muted btn-lg px-1"
                                            data-bs-original-title="Download">
                                            <i class="uil uil-cloud-download text-success"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            @click="changeDocumentStatus( pending.id, 'approved')" title="Approve"
                                            class="btn btn-link text-success btn-lg px-1">
                                            <i class="uil uil-check"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            @click="changeDocumentStatus( pending.id, 'rejected')"
                                            data-bs-container="#tooltip-container9" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title=""
                                            class="btn btn-link text-danger btn-lg px-1"
                                            data-bs-original-title="Reject">
                                            <i class="uil uil-multiply"></i>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->

            </div> <!-- end card-body -->
        </div> <!-- end card -->

    </div> <!-- end col-->

    <div class="col-xl-12 col-lg-12" v-if="orderDetails.orderHistory">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i>
                    Customer Orders
                </h5>
                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                    <thead class="table-primary">
                        <tr>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="history in orderDetails.orderHistory">
                            <td class="align-middle"> @{{ history.invoiceNo }}
                                <span>
                                    <a :href="history.file"
                                            target="_blank" data-bs-container="#tooltip-container9"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                            class="btn btn-link text-muted btn-lg px-1"
                                            data-bs-original-title="Download">
                                            <i class="uil uil-cloud-download text-success"></i>
                                        </a>
                                </span>
                            </td>
                            <td class="align-middle"> @{{ history.date }}</td>
                            <td class="align-middle"> @{{ history.product  }}</td>
                            <td class="align-middle"> @{{ history.qty }}</td>
                            <td class="align-middle"> @{{ history.price }}</td>
                            <td class="align-middle">
                                <h5>
                                    <span class="badge badge-success-lighten" v-if="history.payment_status == 'Paid'">
                                        <i class="mdi mdi-bitcoin"></i>
                                        @{{ history.payment_status }}
                                    </span>
                                    <span class="badge badge-warning-lighten" v-else-if="history.payment_status == 'Pending'">
                                        <i class="mdi mdi-bitcoin"></i>
                                        @{{ history.payment_status }}
                                    </span>
                                    <span class="badge badge-danger-lighten" v-else>
                                        <i class="mdi mdi-bitcoin"></i>
                                        @{{ history.payment_status }}
                                    </span>
                                </h5>
                            </td>
                            <td class="align-middle">
                                <h5>
                                    <span class="badge badge-success-lighten" v-if="history.order_status == 'Completed'">
                                        <i class="mdi mdi-bitcoin"></i>
                                        @{{ history.order_status }} 
                                    </span>
                                    <span class="badge badge-warning-lighten" v-else-if="history.order_status == 'Pending'">
                                        <i class="mdi mdi-bitcoin"></i>
                                        @{{ history.order_status }} 
                                    </span>
                                    <span class="badge badge-danger-lighten" v-else>
                                        <i class="mdi mdi-bitcoin"></i>
                                        @{{ history.order_status }} 
                                    </span>
                                </h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-xl-12 col-lg-12">
        <div class="card text-center" v-if="orderDetails.rejectedInvoice">
            <div class="card-body">
                <h4 class="header-title mb-3">Rejected Invoices</h4>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th> Date </th>
                                <th> Invoice No </th>
                                <th> Product </th>
                                <th> Price </th>
                                <th> Qty </th>
                                <th> Reject Reason </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pending in orderDetails.rejectedInvoice">
                                <td class="align-middle">
                                    @{{ pending.date }}
                                </td>
                                <td class="align-middle"> @{{ pending.invoiceNo }}</td>
                                <td class="align-middle"> @{{ pending.product }} </td>
                                <td class="align-middle"> @{{ pending.price }} </td>
                                <td class="align-middle"> @{{ pending.qty }} </td>
                                <td class="align-middle"> @{{ pending.reject_reason }} </td>
                                <td class="align-middle">
                                    <div class="col-auto" id="tooltip-container9">
                                        <!-- Button -->
                                        <a :href="pending.file"
                                            target="_blank" data-bs-container="#tooltip-container9"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                            class="btn btn-link text-muted btn-lg px-1"
                                            data-bs-original-title="Download">
                                            <i class="uil uil-cloud-download"></i>
                                        </a>
                                        
                                    </div>
                                </td>

                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div>
</div>
