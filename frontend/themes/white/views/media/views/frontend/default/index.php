<?php

use yii\widgets\ListView;

?>

<div class="row">
    <div class="col-sm-12">
        <p class="text-center text-red lead">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris nec velit consequat, pharetra risus et, tempus mi.
        </p>
    </div>
</div> <!-- / .row -->
<div class="row">
    <div class="col-sm-12">
        <ul id="filters" class="list-inline text-center">
            <li><a href="#" class="btn-glass" data-filter="*"><?= Yii::t('app', 'Show All') ?></a></li>
            <?php foreach ($categories as $category) : ?>
                <li><a href="#" class="btn-glass" data-filter=".<?= $category->slug ?>"><?= $category->name ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div> <!-- / .row -->

<div class="center" id="isotope-container">

    <?= Listview::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item'
    ]) ?>

</div>

