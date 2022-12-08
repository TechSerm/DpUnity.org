<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">আপনার তথ্য</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body" id="orderConfirmBody">
                @include('store.order.checkout.body_livewire')
            </div>
            <div class="modal-footer" style="background: #f5f5f5">
                <span class="invalid-feedback" style="display: block" id="" role="alert">
                    <strong id="orderConfirmResponseMessage"></strong>
                </span>
                <button type="button" class="btn btn-danger close-btn" data-dismiss="modal">বন্ধ করুন</button>
                <button type="button" data-token="{{ csrf_token() }}" id="orderConfirmBtn"
                    data-url="{{ route('store.order') }}" onclick="Store.order.create(this)"
                    class="btn btn-primary close-modal">অর্ডার কনফার্ম
                    করুন</button>
            </div>
        </div>
    </div>
</div>
