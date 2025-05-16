<?php
class StandardQualificationModel extends CI_Model
{

    public function get_record_by_id($id)
    {
        $query = $this->db->get_where('standard_qualification', ['id' => $id]);
        return $query->row(); // คืนค่าเป็น object
    }
    public function get_ids_by_tier_and_level($tier1_code, $tier2_code, $tier3_id, $level_code)
    {
        return $this->db->select('id')->get_where('standard_qualification', [
            'tier1_code' => $tier1_code,
            'tier2_code' => $tier2_code,
            'tier3_id' => $tier3_id,
            'level_code' => $level_code
        ])->result();
    }

    public function get_all_tier1_dropdown()
    {
        return $this->db->distinct()
            ->select('tier1_code, tier1_title')
            ->get_where('standard_qualification')
            ->result();
    }

    public function get_all_tier2_dropdown($tier1_code)
    {
        return $this->db->distinct()
            ->select('tier2_code, tier2_title')
            ->get_where('standard_qualification', [
                'tier1_code' => $tier1_code,
                'tier2_code !=' => null
            ])
            ->result();
    }

    public function get_all_tier3_dropdown($tier1_code, $tier2_code)
    {
        return $this->db->distinct()
            ->select('tier3_id, tier3_title')->get_where('standard_qualification', [
                'tier1_code' => $tier1_code,
                'tier2_code' => $tier2_code
            ])->result();
    }

    public function get_all_level_dropdown($tier1_code, $tier2_code, $tier3_id)
    {
        return $this->db->select('level_code, level_name')->get_where('standard_qualification', [
            'tier1_code' => $tier1_code,
            'tier2_code' => $tier2_code,
            'tier3_id' => $tier3_id
        ])->result();
    }

    
}
