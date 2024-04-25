<?php

$fuzzy = new Fuzzy(get_aturan(), get_relasi());
$fuzzy->calculate();

?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Nilai Akhir</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <?php foreach ($KRITERIA as $key => $val) : if ($key == $TARGET) continue ?>
                        <th><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($fuzzy->get_data() as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= $v ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Nilai Fuzzy</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover small">
            <thead>
                <tr>
                    <th rowspan="3"></th>
                    <?php foreach ($KRITERIA as $key => $val) : if ($key == $TARGET) continue ?>
                        <th colspan="<?= count($KRITERIA_HIMPUNAN[$key]) ?>" class="text-center"><?= $val->nama_kriteria ?></th>
                    <?php endforeach ?>
                </tr>
                <tr>
                    <?php foreach ($KRITERIA as $key => $val) : if ($key == $TARGET) continue ?>
                        <?php foreach ($KRITERIA_HIMPUNAN[$key] as $k => $v) : ?>
                            <td><?= $HIMPUNAN[$k]->nama_himpunan ?><br />[<?= $HIMPUNAN[$k]->n1 ?> <?= $HIMPUNAN[$k]->n2 ?> <?= $HIMPUNAN[$k]->n3 ?> <?= $HIMPUNAN[$k]->n4 ?>]</td>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($fuzzy->get_nilai() as $key => $val) : ?>
                <tr>
                    <th><?= $key ?></th>
                    <?php foreach ($val as $k => $v) : ?>
                        <?php foreach ($v as $a => $b) : ?>
                            <td><?= round($b, 3) ?></td>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Aturan</h3>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Aturan</th>
                <?php foreach ($ALTERNATIF as $key => $val) : ?>
                    <th>miu[<?= $key ?>]</th>
                    <th>z[<?= $key ?>]</th>
                <?php endforeach ?>
            </tr>
        </thead>
        <?php
        $miu = $fuzzy->get_miu();
        $z = $fuzzy->get_z();
        foreach ($fuzzy->get_rules() as $key => $val) : if (array_sum($miu[$key]) == 0) continue ?>
            <tr>
                <td><?= $key ?></td>
                <td><?= $val->to_string() ?></td>
                <?php foreach ($ALTERNATIF as $k => $v) : ?>
                    <td><?= round($miu[$key][$k], 3) ?></td>
                    <td>
                        <?php
                        $arr_z = array();
                        foreach ($z[$key][$k] as $b) {
                            $arr_z[] = round($b, 2);
                        }
                        ?>
                        [ <?= implode(',', $arr_z) ?> ]</td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Hasil Defuzifikasi</h3>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Total</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <?php
        $total = $fuzzy->get_total();
        $rank = $fuzzy->get_rank();
        $no = 1;
        foreach ($rank as $key => $val) : ?>
            <tr>
                <td><?= $val ?></td>
                <td><?= $key ?></td>
                <td><?= $ALTERNATIF[$key] ?></td>
                <td><?= round($total[$key], 3) ?></td>
                <td><?= $fuzzy->get_klasifikasi($total[$key]) ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>