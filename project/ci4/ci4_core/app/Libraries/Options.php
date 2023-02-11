<?php

namespace App\Libraries;

class Options
{

   public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->options = $this->db->table("options");
    
    }
    public function get($name=null)
    {
       $row= $this->options->select("option_value")
        ->where("option_name",$name)
        ->get()->getRow()->option_value;
        return $row;
    }
    public function set($post)
    {
        foreach($post as $key => $value)
        {
            $this->options->where("option_name",$key);
            $resp= $this->options->update([
                "option_value" => $value
            ]);

        }
        return true;
    }
    public function ukuran_kertas()
    {
        $ukuran = [
            [
                "label" => "Kecil (58mm)",
                "value" => "58mm"
            ],
            [
                "label" => "Kecil (80mm)",
                "value" => "80mm"
            ],
            [
                "label" => "Custom Printer",
                "value" => "custom"
            ],
            [
                "label" => "Medium (A5)",
                "value" => "A5"
            ],
            [
                "label" => "Besar (A4)",
                "value" => "A4"
            ],

        ];
        return $ukuran;
    
    }
    
}