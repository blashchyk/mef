<?php
use modules\snippet\models\frontend\Snippet;

$snippets = Snippet::getPageSnippets($location, !empty($page) ? $page->id : null);
?>

<?php foreach($snippets as $snippet): ?>
    <?= $snippet->content; ?>
<?php endforeach; ?>
