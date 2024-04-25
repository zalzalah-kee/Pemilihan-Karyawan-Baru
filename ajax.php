<?php
require_once 'functions.php';
if ($mod == 'simpan_aturan') {
    $db->query("UPDATE tb_aturan SET kode_himpunan='$_POST[kode_himpunan]' WHERE kode_kriteria='$_POST[kode_kriteria]' AND no_aturan='$_POST[no_aturan]'");
    echo "Simpan Aturan Berhasil!";
}
