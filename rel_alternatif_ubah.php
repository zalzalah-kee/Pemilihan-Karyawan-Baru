<?php
$row = $db->get_row("SELECT * FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
?>
<div class="page-header">
    <h1>Ubah Nilai Test &raquo; <small><?= $row->nama_alternatif ?></small></h1>
</div>
<div class="row">
    <div class="col-sm-4">
        <form method="POST" action="aksi.php?act=rel_alternatif_ubah&ID=<?= $row->kode_alternatif ?>">
            <?php
            $rows = $db->get_results("SELECT * FROM tb_rel_alternatif ra INNER JOIN tb_kriteria k ON k.kode_kriteria=ra.kode_kriteria WHERE kode_alternatif='$_GET[ID]' ORDER BY ra.kode_kriteria");
            foreach ($rows as $row) : if ($row->kode_kriteria == $TARGET) continue ?>
                <div class="form-group">
                    <label><?= $row->nama_kriteria ?> (<?= $row->batas_bawah ?> - <?= $row->batas_atas ?>)</label>
                    <input class="form-control" type="text" name="ID-<?= $row->ID ?>" value="<?= $row->nilai ?>" />
                </div>
            <?php endforeach ?>
            <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            <a class="btn btn-danger" href="?m=rel_alternatif"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        </form>
    </div>
</div>