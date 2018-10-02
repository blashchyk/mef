<?php
/* @var \modules\hierarchicalStructure\models\KartikTreeNode[] $nodes*/
/* @var string $hsName */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report Eol - <?= date('Y-m-d'); ?></title>
    <style>

    </style>
</head>
<body>
<div class="pdf-page">
    <h3 style="text-align: center">Auto de Eliminação</h3>
    <p>Aos……dias do mês de…………………de…………., no(a)…………………., em………………………..,
        na presença dos abaixo assinados, procedeu-se à venda/inutilização por…………………….,
        de acordo com …………………., de …… de …………………., e Despacho de aprovação do
        relatório do Diretor Geral da DGLAB de ……/……/………..</p>
    <table>
        <thead>
        <tr>
            <th width="10%" style="background-color: #b8b8b8">Reference Code</th>
            <th width="16%" style="background-color: #b8b8b8">Title</th>
            <th width="5%" style="background-color: #b8b8b8">Initial date</th>
            <th width="5%" style="background-color: #b8b8b8">Final Date</th>
            <th width="20%" style="background-color: #b8b8b8">Extent and medium</th>
        </tr>
        </thead>
        <tbody>
        <?php

            while ($node = array_shift($nodes)) {
                echo '<tr>';
                echo '<td style="padding: 5px; fontvertical-align: top"><p>' . $node->full_code . '</p></td>';
                echo '<td style="padding: 5px; vertical-align: top"><p>' . $node->title .'</p></td>';
                echo '<td style="padding: 5px; text-align: center; vertical-align: top"><p>'
                    . date('Y-m-d', (int)$node->date)
                    . '</p></td>';
                echo '<td style="padding: 5px; text-align: center; vertical-align: top"><p>'
                    . ($node->final_date ? date('Y-m-d', (int)$node->final_date) : '')
                    . '</p></td>';
                echo '<td style="padding: 5px; vertical-align: top"><p>'
                    . strip_tags($node->extent_description)
                    . '</p></td>';
                echo '</tr>';
                unset($node);
            }
            ?>
        </tbody>
    </table>

    <h3>O responsável pelo arquivo:</h3>

    <h3>O responsável pelo organismo:</h3>
</div>
</body>
</html>
