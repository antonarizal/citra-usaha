<?php

namespace App\Libraries;

class W2ui
{

   public function __construct()
    {
		$this->db = db_connect();
    }
    public function result($getModel, $fields, $request,$where=false,$join=false)
    {
    
        $request =  (json_decode($request));
        $limit =isset($request->limit) ? $request->limit : false;
        $offset =isset($request->offset) ? $request->offset : false;
        $sort = isset($request->sort) ? $request->sort[0] : false;
        $search = isset($request->search) ? $request->search[0] : false;
        $delete = isset($request->action) && $request->action=="delete" ? $request : false;
        $save = isset($request->action) && $request->action=="save" ? $request : false;
    
        if($where){
            $getModel = $getModel->where($where);
        }
        if($join!=false){
            $getModel = $getModel->join($join[0],$join[1]);
        }
        if($sort){
            $getModel = $getModel->orderBy($sort->field, $sort->direction);
        }
        if($search){
            $getModel = $getModel->like($search->field, $search->value);
        }
        if($limit){
            $model = $getModel->findAll($limit, $offset);
    
        }else{
            $model = $getModel->findAll($limit, $offset);
        }
        if($save){
            $primaryKey = 'id';
            $data = [ ];

            $barang = $BarangModel->save($data);
            $getModel = $getModel->save($request->recid,true);
            $resp['status']  = 'success';
            $resp['message'] = 'Data berhasil disimpan';
    
        }
        if($delete){
            $getModel = $getModel->delete($request->recid,true);
            // $getModel = $getModel->delete($request->id,true);
            $resp['status']  = 'success';
            $resp['message'] = 'Data berhasil dihapus';
    
        }else{
            $i=0;
            $data=[];
    
            foreach($model as $row) {
                $data[$i]["recid"] = $row["id"];
                foreach($fields as $col){
                    $data[$i][$col] = $row[$col];
                }
    
                $i++;
            }
            $resp["records"] = ($data);
            // $data["total"] = count($pelanggan);
            $resp["total"] = '-1';
            $resp["status"] = "success";
            $resp["request"] = $request;
            $resp["sort"] = $sort;
        }
    
        return ($resp);
    }
    
}