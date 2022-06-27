<?php

namespace App\Helpers;

class Status
{
    public static $status = [
        0 => 'Belum Di Ajukan',
        1 => 'Di Ajukan',
        2 => 'Di Validasi',
        3 => 'Di Setujui',
        5 => 'Di Tolak Validasi',
        6 => 'Di Tolak Persetujuan'
    ];

    public static $typeSubmissionEspecially = [
        'baptis' => 'Cuti Baptis',
        'marry' => 'Cuti Menikah',
        'give_birth' => 'Cuti Melahirkan',
        'wife_give_birth' => 'Cuti Istri Melahirkan',
        'mortality' => 'Cuti Kematian Keluarga',
        'married_child' => 'Cuti Anak Menikah',
        'khitanan' => 'Cuti Khitanan',
        'graduation' => 'Cuti Wisuda',
        'pilgrimage' => 'Ibadah Naik Haji Pertama',
        'legal_summons' => 'Pemanggilan Pihak Berwajib'
    ];
}
