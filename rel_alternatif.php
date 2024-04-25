<div class="page-header">
    <h1>Nilai Test Pelamar</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="rel_alternatif" />
            <div class="form-group">
                <input class="form-control" type="text" name="q" value="<?= _get('q') ?>" placeholder="Pencarian..." />
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Pelamar</th>
                <?php foreach ($KRITERIA as $key => $val) : if ($key == $TARGET) continue ?>
                    <th><?= $val->nama_kriteria ?></th>
                <?php endforeach ?>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = $db->get_results("SELECT * FROM tb_alternatif  WHERE nama_alternatif LIKE '%" . esc_field(_get('q')) . "%' ORDER BY kode_alternatif");
            $data = get_relasi();
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row->kode_alternatif ?></td>
                    <td><?= $row->nama_alternatif ?></td>
                    <?php foreach ($data[$row->kode_alternatif] as $k => $v) : if ($k == $TARGET) continue ?>
                        <td><?= $v ?></td>
                    <?php endforeach ?>
                    <td>
                        <a class="btn btn-xs btn-warning" href="?m=rel_alternatif_ubah&ID=<?= $row->kode_alternatif ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>