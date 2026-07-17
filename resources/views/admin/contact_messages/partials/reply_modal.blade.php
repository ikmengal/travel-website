<div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <form id="replyForm">

                @csrf

                <input type="hidden" name="id" id="reply_message_id">

                <div class="modal-header">

                    <h5 class="modal-title" id="replyModalTitle">
                        Reply Contact Message
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Name
                            </label>

                            <input type="text"
                                id="reply_name"
                                class="form-control"
                                readonly>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="text"
                                id="reply_email"
                                class="form-control"
                                readonly>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Subject
                            </label>

                            <input type="text"
                                id="reply_subject"
                                class="form-control"
                                readonly>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Customer Message
                            </label>

                            <textarea
                                id="customer_message"
                                class="form-control"
                                rows="5"
                                readonly></textarea>

                        </div>

                        <div class="col-md-12">

                            <label class="form-label">
                                Reply
                            </label>

                            <textarea
                                id="reply"
                                name="reply"
                                class="form-control"
                                rows="8"></textarea>

                            <span class="text-danger reply_error"></span>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-label-secondary"
                        data-bs-dismiss="modal">

                        Close

                    </button>

                    <button
                        type="submit"
                        id="sendReplyBtn"
                        class="btn btn-primary">

                        <i class="ti ti-send me-1"></i>

                        Send Reply

                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
