<div class="row">
    <div class="well well-lg col-md-8 col-md-offset-2">
        <div class="panel panel-primary col-md-10 col-md-offset-1 row">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-9"><h3 class="panel-title"><?= htmlspecialchars($this->questionWithAnswers[0]['Title']) ?></h3></div>
                    <div class=" col-md-3 text-right"> <?= htmlspecialchars($this->questionWithAnswers[0]['Date']) ?></div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2 "><span class="text-primary">User: </span> <?= htmlspecialchars($this->questionWithAnswers[0]['Username']) ?></div>
                    <div class="col-md-8"><span class="text-primary">Category: </span> <?= htmlspecialchars($this->questionWithAnswers[0]['Category']) ?></div>
                    <div class="col-md-2 text-right"><span class="text-primary">Visits: </span> <?= htmlspecialchars($this->questionWithAnswers[0]['Counter']) ?></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><span class="text-primary">Tags: </span>
                        <?php
                        if(isset($this->questionWithAnswers[0]['Tags'])) {
                            echo htmlspecialchars($this->questionWithAnswers[0]['Tags']);
                        } else {
                            echo "No tags";
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="well top-buffer"> <?= htmlspecialchars($this->questionWithAnswers[0]['Content']) ?></div>

                </div>
            </div>
        </div>
        <?php if($this->questionWithAnswers[0]['AnswerContent'] != null):
            foreach ($this->questionWithAnswers as $q) : ?>
        <div class="panel panel-default col-md-10 col-md-offset-1">
            <div class="panel-heading ">
                <span class="col-md-6">
                    <span class="text-primary">Author: </span > <?= htmlspecialchars($q['AnswerAuthor']) ?>
                    <?php
                    if($q['AnswerAuthorEmail'] != null){
                        $email =  htmlspecialchars($q['AnswerAuthorEmail']);
                        echo "<span class='col-md-offset-1 text-primary'>Email: </span>$email";
                    }
                    ?>
                </span>
                <span class="col-md-3 text-right text-primary">Date: </span> <?= htmlspecialchars($q['AnswerDate']) ?>
            </div>

            <div class="panel-body ">
                <?= htmlspecialchars($q['AnswerContent'])?>
            </div>
        </div>
        <?php endforeach;
            endif?>

        <div class="col-md-2 col-md-offset-5">
            <a href="/answers/add/<?= htmlspecialchars($this->questionWithAnswers[0]['Id']) ?>" class="btn btn-primary">Add Answer</a>
        </div>
    </div>
</div>