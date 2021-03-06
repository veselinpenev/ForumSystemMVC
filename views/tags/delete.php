<div class="row">
    <div class="well col-md-6 col-md-offset-3">
        <form class="form-horizontal" name="deleteTagsForm" method="POST">
            <fieldset>
                <div class="row">
                    <legend>Delete Tags</legend>
                </div>
                <div class="form-group">
                    <label for="title" class="col-lg-3 control-label">Title</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" id="title" name="title"value="<?= $this->tagsInfo['Title'] ?>" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <div class="text-center">
                        <input class="btn btn-primary" type="submit" value="Delete"/>
                        <a class="btn btn-default" href="/tags">Cancel</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
