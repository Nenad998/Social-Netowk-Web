<div class="modal" id="editPostWallModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <form id="editPostWallForm">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="content" class="form-control" id="content">
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
