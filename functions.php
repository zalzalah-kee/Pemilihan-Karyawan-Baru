<?php
error_reporting(~E_NOTICE);
session_start();

include 'config.php';
include 'includes/db.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'includes/general.php';
include 'includes/fuzzy.php';

function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');

$db->query("DELETE FROM tb_himpunan WHERE kode_kriteria NOT IN (SELECT kode_kriteria FROM tb_kriteria)");

$rows = $db->get_results("SELECT kode_alternatif, nama_alternatif FROM tb_alternatif ORDER BY kode_alternatif");
foreach ($rows as $row) {
    $ALTERNATIF[$row->kode_alternatif] = $row->nama_alternatif;
}

$rows = $db->get_results("SELECT * FROM tb_himpunan ORDER BY kode_himpunan");
$HIMPUNAN = array();
$KRITERIA_HIMPUNAN = array();
foreach ($rows as $row) {
    $HIMPUNAN[$row->kode_himpunan] = $row;
    $KRITERIA_HIMPUNAN[$row->kode_kriteria][$row->kode_himpunan] = $row;
}

$rows = $db->get_results("SELECT * FROM tb_kriteria ORDER BY kode_kriteria");
foreach ($rows as $row) {
    $KRITERIA[$row->kode_kriteria] = $row;
    $TARGET = $row->kode_kriteria;
}

/** ============================== */

function get_aturan()
{
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_aturan ORDER BY no_aturan, kode_kriteria");
    $arr = array();
    foreach ($rows as $row) {
        $arr[$row->no_aturan][$row->kode_kriteria] = $row;
    }

    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[$key] = new Rule($val);
    }
    //echo '<pre>' . print_r($arr2, 1) . '</pre>';
    return $arr2;
}

function get_relasi()
{
    global $db, $TARGET;
    $data = array();
    $rows = $db->get_results("SELECT * 
        FROM tb_rel_alternatif r INNER JOIN tb_kriteria k ON k.kode_kriteria=r.kode_kriteria        
        ORDER BY kode_alternatif, r.kode_kriteria");
    foreach ($rows as $row) {
        if ($row->kode_kriteria == $TARGET) continue;
        $data[$row->kode_alternatif][$row->kode_kriteria] = $row->nilai;
    }
    return $data;
}

function get_hasil_option($selected)
{
    global $KRITERIA_HIMPUNAN, $TARGET;
    $a = '';
    foreach ($KRITERIA_HIMPUNAN[$TARGET] as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val->nama_himpunan</option>";
        else
            $a .= "<option value='$key'>$val->nama_himpunan</option>";
    }
    return $a;
}

function get_himpunan_option($kode_kriteria, $selected)
{
    global $KRITERIA_HIMPUNAN;
    $a = '';
    foreach ($KRITERIA_HIMPUNAN[$kode_kriteria] as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val->nama_himpunan</option>";
        else
            $a .= "<option value='$key'>$val->nama_himpunan</option>";
    }
    return $a;
}

function get_operator_option($selected)
{
    $arr = array('AND' => 'AND', 'OR' => 'OR');
    $a = '';
    foreach ($arr as $key => $val) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$val</option>";
        else
            $a .= "<option value='$key'>$val</option>";
    }
    return $a;
}
