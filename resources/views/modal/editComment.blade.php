<div class="modal" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="comment" class="form-control" id="comment">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="post_id" id="post_id">
                        <input type="hidden" name="id" id="id">
                    </div>
                    <div class="d-md-flex justify-content-md-end mt-2">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
