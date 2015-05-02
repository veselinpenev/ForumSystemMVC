<div class="row">
    <div class="well well-lg col-md-8 col-md-offset-2">
        <div class="row">
            <div class="row">
                <h1 class="col-md-3"><?= htmlspecialchars($this->title) ?></h1>
                <div class="col-md-2 col-md-offset-6">
                    <a href="/questions/add" class="btn btn-primary">Add Question</a>
                </div>
            </div>

            <?php foreach ($this->questions as $q) : ?>
                <div class="panel panel-primary col-md-10 col-md-offset-1">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9"><a class="textWhite" href="/questions/view/<?= $q['Id']?>"><h3 class="panel-title"><?= htmlspecialchars($q['Title']) ?></h3></a></div>
                            <div class=" col-md-3 text-right"> <?= htmlspecialchars($q['Date']) ?></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2"><span>User: </span> <?= htmlspecialchars($q['Username']) ?></div>
                            <div class="col-md-8"><span>Category: </span> <?= htmlspecialchars($q['Category']) ?></div>
                            <div class="col-md-2 text-right"><span>Visits: </span> <?= htmlspecialchars($q['Counter']) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <div class="row text-center">
            <?php if($this->page != 1) : ?>
                <a href="/questions/index/<?= $this->page-1?>/<?= $this->pageSize ?>" class="btn btn-default">Previous</a>
            <?php endif ?>
            <?php for($i=1; $i<= $this->maxPage; $i++) : ?>
                <a href="/questions/index/<?= $i?>/<?= $this->pageSize ?>" class="btn btn-default"><?= $i ?></a>
            <?php endfor ?>
            <?php if($this->page != $this->maxPage && $this->maxPage != 0) : ?>
                <a href="/questions/index/<?= $this->page+1?>/<?= $this->pageSize ?>" class="btn btn-default">Next</a>
            <?php endif ?>
        </div>
    </div>
</div>