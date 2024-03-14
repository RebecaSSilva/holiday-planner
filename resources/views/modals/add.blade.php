<!-- Modal add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">New Holiday</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addTitle">Title</label>
                                <input type="text" class="form-control" required id="addTitle" name="title" maxlength="255" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addDescription">Description</label>
                                <textarea class="form-control" id="addDescription" required name="description" required maxlength="255"></textarea>
                            </div>      
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addDate">Date</label>
                                <input type="date" class="form-control" id="addDate" required name="date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addLocation">Location</label>
                                <textarea class="form-control" id="addLocation" required name="location" required maxlength="255"></textarea>
                            </div>      
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="addParticipants">Participants</label>
                                <textarea class="form-control" id="addParticipants" name="participants" required maxlength="255"></textarea>
                            </div>  
                        </div>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnSaveAdd">Save</button>
            </div>
        </div>
    </div>
</div>
