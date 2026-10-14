<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    /**
     * Unik kecuali untuk baris dengan id tertentu.
     * Pemakaian: edit_unique[tabel.kolom.id]
     */
    public function edit_unique($value, $params)
    {
        $parts = explode('.', $params);
        if (count($parts) !== 3) {
            return FALSE;
        }
        list($table, $field, $id) = $parts;

        $row = $this->CI->db
            ->limit(1)
            ->get_where($table, array($field => $value, 'id !=' => (int) $id))
            ->row();

        return $row === NULL;
    }

    /** URL boleh kosong, kalau diisi harus http(s). */
    public function url_opsional($value)
    {
        if ($value === '' || $value === NULL) {
            return TRUE;
        }
        return (bool) preg_match('#^https?://#i', $value) && filter_var($value, FILTER_VALIDATE_URL) !== FALSE;
    }
}
