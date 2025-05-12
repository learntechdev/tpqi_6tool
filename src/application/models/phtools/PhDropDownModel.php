<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PhDropDownModel extends CI_Model
{
    public function getTier2($tier1_code)
    {
        return $this->db->distinct()
            ->select('tier2_code, tier2_title')
            ->get_where('standard_qualification', [
                'tier1_code' => $tier1_code,
                'tier2_code !=' => null
            ])
            ->result();
    }

    public function getTier3($tier1_code, $tier2_code)
    {
        return $this->db->distinct()
            ->select('tier3_id, tier3_title')->get_where('standard_qualification', [
                'tier1_code' => $tier1_code,
                'tier2_code' => $tier2_code
            ])->result();
    }

    public function getLevel($tier1_code, $tier2_code, $tier3_id)
    {
        return $this->db->select('level_code, level_name')->get_where('standard_qualification', [
            'tier1_code' => $tier1_code,
            'tier2_code' => $tier2_code,
            'tier3_id' => $tier3_id
        ])->result();
    }

    public function getStandardQualification($tier1_code, $tier2_code, $tier3_id, $level_code)
    {
        return $this->db->select('id')->get_where('standard_qualification', [
            'tier1_code' => $tier1_code,
            'tier2_code' => $tier2_code,
            'tier3_id' => $tier3_id,
            'level_code' => $level_code
        ])->result();
    }
}
