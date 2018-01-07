<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends MY_Model
{
    public $table = 'user';

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'no_induk',
                'label' => 'No Induk',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required'
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'no_induk' => '',
            'password' => ''
        ];
    }

    public function login($input)
    {
        $input->password = md5($input->password);

        $user = $this->db->where('no_induk',$input->no_induk)
            ->where('password',$input->password)
            ->where('is_verified', 'y')
            ->limit(1)
            ->get($this->table)
            ->row();

        if (count($user)) {
            $data = [
                'no_induk' => $user->no_induk,
                'level' => $user->level,
                'id_user' => $user->id_user,
                'nama' => $user->nama,
                'jenis_kelamin' => $user->jenis_kelamin,
                'foto' => $user->foto,
                'is_login' => true
            ];

            $this->session->set_userdata($data);
            return true;
        }

        return false;
    }

    public function logout()
    {
        $data = [
            'no_induk' => null,
            'level' => null,
            'id_user' => null,
            'nama' => null,
            'jenis_kelamin' => null,
            'foto' => null,
            'is_login' => null
        ];
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
    }
}

