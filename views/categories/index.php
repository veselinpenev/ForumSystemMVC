<div class="col-md-6 col-md-offset-3">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th class="col-md-1">Id</th>
            <th>Title</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($this->categories as $c) : ?>
                <tr>
                    <td><?= htmlspecialchars($c['Id']) ?></td>
                    <td><?= htmlspecialchars($c['Title']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="row text-center">
        <?php if($this->page != 1) : ?>
            <a href="/categories/index/<?= $this->page-1?>/<?= $this->pageSize ?>" class="btn btn-default">Previous</a>
        <?php endif ?>
        <?php for($i=1; $i<= $this->maxPage; $i++) : ?>
            <a href="/categories/index/<?= $i?>/<?= $this->pageSize ?>" class="btn btn-default"><?= $i ?></a>
        <?php endfor ?>
        <?php if($this->page != $this->maxPage && $this->maxPage != 0) : ?>
            <a href="/categories/index/<?= $this->page+1?>/<?= $this->pageSize ?>" class="btn btn-default">Next</a>
        <?php endif ?>
    </div>
</div>