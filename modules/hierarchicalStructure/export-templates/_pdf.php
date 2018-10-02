<?php
/* @var \modules\hierarchicalStructure\models\KartikTreeNode[] $nodes*/
/* @var string $hsName */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $hsName ?></title>
    <style>

    </style>
</head>
<body>
<div class="pdf-page">
    <h3 style="text-align: center"><?= $hsName ?></h3>
    <table>
        <thead>
        <tr>
            <th width="10%" style="background-color: #b8b8b8">CODE PATH</th>
            <th width="16%" style="background-color: #b8b8b8">TITLE</th>
            <th width="5%" style="background-color: #b8b8b8">TERM</th>
            <th width="5%" style="background-color: #b8b8b8">FINAL DESTINATION</th>
            <th width="20%" style="background-color: #b8b8b8">DESCRIPTION</th>
            <th width="22%" style="background-color: #b8b8b8">NOTES APPLICATION</th>
            <th width="22%" style="background-color: #b8b8b8">NOTES EXCLUSION</th>
        </tr>
        </thead>
        <tbody>
        <?php
            while (($node = array_shift($nodes))) {

                echo '<tr>';
                echo '<td style="padding: 5px; vertical-align: top">' . $node->getCodePath() . '</td>';
                echo '<td style="padding: 5px; vertical-align: top">' . $node->name .'</td>';
                echo '<td style="padding: 5px; text-align: center; vertical-align: top">' . $node->hsTreeNode->conservation_term . '</td>';
                echo '<td style="padding: 5px; text-align: center; vertical-align: top">' . $node->hsTreeNode->finalDestination->abbreviation . '</td>';
                echo '<td style="padding: 5px; vertical-align: top">' . strip_tags($node->hsTreeNode->description) . '</td>';
                echo '<td style="padding: 5px; vertical-align: top">' . strip_tags($node->hsTreeNode->notes_application) . '</td>';
                echo '<td style="padding: 5px; vertical-align: top">' . strip_tags($node->hsTreeNode->notes_exclusion) . '</td>';
                echo '</tr>';
                unset($node);
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>