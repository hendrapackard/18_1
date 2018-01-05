<?php

//get list of option for dropdown
function getDropdownList($table, $columns)
{
    $CI =& get_instance();
    $query = $CI->db->select($columns)->from($table)->get();

    if ($query->num_rows() >= 1){
        $options1 = ['' => '- Pilih -'];
        $options2 = array_column($query->result_array(), $columns[1],$columns[0]);
        $options = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Pilih -'];
}

//Show form error validation message for "file" input.
function fileFormError($field, $prefix='',$suffix = '')
{
    $CI =& get_instance();
    $error_field = $CI->form_validation->error_array();

    if (!empty($error_field[$field])) {
        return $prefix . $error_field[$field] . $suffix;
    }
    return '';
}

//Format tanggal dalam Bahasa Indonesia
function formatHariTanggal($waktu)
{
    $hari_array = [
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    ];
    $hr = date('w',strtotime($waktu));
    $hari = $hari_array[$hr];

    $tanggal = date('j',strtotime($waktu));

    $bulan_array = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    $bl = date('n',strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y',strtotime($waktu));
    return "$hari, $tanggal $bulan $tahun";
}