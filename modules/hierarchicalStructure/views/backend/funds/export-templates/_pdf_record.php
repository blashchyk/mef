<?php

use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\controllers\backend\FundsController;
use modules\hierarchicalStructure\models\Funds;

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
<div class="pdf-page">
    <table>
        <thead>
        <tr>
            <th width="15%" style="background-color: #b8b8b8">Number and name ofelement of description</th>
            <th width="85%" style="background-color: #b8b8b8">Description</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $node_code = KartikTreeNode::getNoteCode($record->node_id);
            $parent_record_code = FundsController::getCodeRecordParent($record->node_id);
            $fund_code = Funds::findOne($record->fond_id);
            echo '<tr>';
            echo '<td width="15%" style="background-color: #b8b8b8">Reference code</td>';
            echo '<td width="85%" style="background-color: #1a1a1a; color: #ffffff">' . $fund_code->code
                . (!empty(str_replace('.', '', $node_code))
                    ? (FundsController::DELIMITER_RECORDS . trim($node_code, FundsController::DELIMITER))
                    : '')
                . (isset($parent_record_code)
                    ? FundsController::DELIMITER_RECORDS . $parent_record_code
                    : '')
                . FundsController::DELIMITER_RECORDS
                . $record->code . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td width="15%" style="background-color: #b8b8b8">Title</td>';
            echo '<td width="85%">' . $record->title . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td width="15%" style="background-color: #b8b8b8">Initial date</td>';
            echo '<td width="85%">' . date('Y-m-d', $record->date) . '</td>';
            echo '</tr>';
            if (!empty($record->final_date)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Final date</td>';
                echo '<td width="85%">' . date('Y-m-d', $record->final_date) . '</td>';
                echo '</tr>';
            }
            echo '<tr>';
            echo '<td width="15%" style="background-color: #b8b8b8">Level of description</td>';
            echo '<td width="85%">' . $record->level_description . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td width="15%" style="background-color: #b8b8b8">Extent and medium of the unit of description (quantity, bulk, or size)</td>';
            echo '<td width="85%">' . $record->extent_description . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td width="15%" style="background-color: #b8b8b8">Name of creator</td>';
            echo '<td width="85%">' . $record->creator . '</td>';
            echo '</tr>';
            if (!empty($record->administrative_history)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Administrative / Biographical history</td>';
                echo '<td width="85%">' . $record->administrative_history . '</td>';
                echo '</tr>';
            }
            if (!empty($record->archival_history)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Archival history</td>';
                echo '<td width="85%">' . $record->archival_history . '</td>';
                echo '</tr>';
            }
            if (!empty($record->trans)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Immediate source of acquisition or trans</td>';
                echo '<td width="85%">' . $record->trans . '</td>';
                echo '</tr>';
            }
            if (!empty($record->content)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Scope and content</td>';
                echo '<td width="85%">' . $record->content . '</td>';
                echo '</tr>';
            }
            if (!empty($record->information)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Appraisal, destruction and scheduling information</td>';
                echo '<td width="85%">' . $record->information . '</td>';
                echo '</tr>';
            }
            if (!empty($record->accruals)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Accruals</td>';
                echo '<td width="85%">' . $record->accruals . '</td>';
                echo '</tr>';
            }
            if (!empty($record->arrangement)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">System of arrangement</td>';
                echo '<td width="85%">' . $record->arrangement . '</td>';
                echo '</tr>';
            }
            if (!empty($record->access)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Conditions governing access</td>';
                echo '<td width="85%">' . $record->access . '</td>';
                echo '</tr>';
            }
            if (!empty($record->reproduction)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Conditions governing reproduction</td>';
                echo '<td width="85%">' . $record->reproduction . '</td>';
                echo '</tr>';
            }
            if (!empty($record->language)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Language / scripts of material</td>';
                echo '<td width="85%">' . $record->language . '</td>';
                echo '</tr>';
            }
            if (!empty($record->characteristics)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Physical characteristics and technical requirements</td>';
                echo '<td width="85%">' . $record->characteristics . '</td>';
                echo '</tr>';
            }
            if (!empty($record->aids)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Finding aids</td>';
                echo '<td width="85%">' . $record->aids . '</td>';
                echo '</tr>';
            }
            if (!empty($record->location_originals)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Existence and location of originals</td>';
                echo '<td width="85%">' . $record->location_originals . '</td>';
                echo '</tr>';
            }
            if (!empty($record->location_copies)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Existence and location of copies</td>';
                echo '<td width="85%">' . $record->location_copies . '</td>';
                echo '</tr>';
            }
            if (!empty($record->related_units)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Related units of description</td>';
                echo '<td width="85%">' . $record->related_units . '</td>';
                echo '</tr>';
            }
            if (!empty($record->publication_note)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Publication note</td>';
                echo '<td width="85%">' . $record->publication_note . '</td>';
                echo '</tr>';
            }
            if (!empty($record->note)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Note</td>';
                echo '<td width="85%">' . $record->note . '</td>';
                echo '</tr>';
            }
            if (!empty($record->archivist_note)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Archivist\'s Note</td>';
                echo '<td width="85%">' . $record->archivist_note . '</td>';
                echo '</tr>';
            }
            if (!empty($record->rules)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Rules or Conventions</td>';
                echo '<td width="85%">' . $record->rules . '</td>';
                echo '</tr>';
            }
            if (!empty($record->date_descriptions)) {
                echo '<tr>';
                echo '<td width="15%" style="background-color: #b8b8b8">Date of descriptions</td>';
                echo '<td width="85%">' . $record->date_descriptions . '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>