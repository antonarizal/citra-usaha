<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class Mutasi  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->w2ui =  new W2ui();

    }

    public function index()
    {

    }
    public function all()
    {
        $date = date('Y-m-d');
        $date = '2022-04-26';
        $query = "SELECT TOP 100 * FROM tbMutasi WHERE date='$date' ORDER BY date ASC";
        $result = $this->db->query($query)->getResult();
        foreach($result as $row){
            print_r($row);
        }

    }
    public function count()
    {
        $query = "SELECT count(*) FROM tbMutasi";
        $result = $this->db->query($query)->getResultArray();
        print_r($result);
    }
    
    public function remove()
    {
        $date = '2015-12-31';
        $query = "DELETE FROM tbMutasi WHERE date <='$date'";
        $result = $this->db->query($query);
        print_r($result);
    
    }
    
    public function input()
    {	
        $request = (object)$this->request->getPost();
        $insert = 0;
        $lokasiStok = [
            "G00"=>"stock",
            "G01"=>"stock1",
            "G02"=>"stock2",
            "G03"=>"stock3",
            "G04"=>"stock4",
            "G05"=>"stock5",
            "G06"=>"stock6",
            "G07"=>"stock7",
        ];
        // print_r($request->data[0]);
        $values=[];
        $i=0;
        foreach($request->data as $data){
            // insert mutasi
            // $insert = $this->db->table("tbMutasi")->insert($data);
            // $insert = $this->db->query("tbMutasi");
            // foreach($data as $row)
            $fields = implode(',',array_keys($data));
            // // $values = implode(',',array_values($data));
            $j=0;
            foreach(array_values($data) as $value){
                $val[$j] = "'".$value."'";
                $j++;
            }
            $valuesx = implode(',',$val);
            $values[$i] = "($valuesx)";
            // $query = "INSERT INTO tbMutasi ($fields) VALUES ($values);";
            // $insert = $this->db->query($query);
            // echo $query;
            // update stok
            // $update = "";   
            $qty = $data["totqty"];
            $lok1 = $data["lok1"];
            $lok2 = $data["lok2"];
            $lokasi1 = $lokasiStok[$lok1];
            $lokasi2 = $lokasiStok[$lok2];
            // $this->db->query("UPDATE tbArtic SET $lokasi1 =1000 WHERE plu = '$data[plu]'");
            // $this->db->query("UPDATE tbArtic SET $lokasi2 = 10 WHERE plu = '$data[plu]'");
            $i++;
        }
        $values = implode(',',$values);
        $query = "INSERT INTO tbMutasi ($fields) VALUES $values;";
        // $insert = $this->db->query($query);
        // $response = [
        //     "status"=> $insert,
        //     "success"=> true,
        //     "message"=> "Berhasil",
        // ];
        // return $this->respond($response, 200);
        echo $query;




    }

}