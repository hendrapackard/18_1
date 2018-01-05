<?php


class Proyek_model extends MY_Model
{
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'tanggal',
                'label' => 'Tanggal',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'pic',
                'label' => 'PIC',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'proyek',
                'label' => 'Proyek',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'task',
                'label' => 'Task',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'waktu',
                'label' => 'Waktu',
                'rules' => 'trim|required'
            ],
        ];

        return $validationRules;
    }

    public function getDefaultValues()
    {
        return [
            'tanggal' => '',
            'pic' => '',
            'proyek' => '',
            'task' => '',
            'waktu' => '',
        ];
    }
}