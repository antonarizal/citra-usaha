<?php

namespace App\Modules\Api\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Libraries\W2ui;

class User  extends ResourceController
{

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->user      = $this->db->table("users");
        $this->w2ui =  new W2ui();

    }
    public function insert()
    {
        $data = $this->request->getPost();
        unset($data["insert"]);
        $request = (object)$this->request->getPost();
        $data = [
            "username"=>$request->username,
            "password"=>password_hash($request->password,PASSWORD_BCRYPT),
            "level"=>$request->level,
        ];

        if($request->insert){
            $result = $this->user->insert($data);
        }else{
            if($request->password == ""){
                $data = [
                    "username"=>$request->username,
                    "level"=>$request->level,
                ];
            }
            $this->user->where('username', $request->username);
            $result = $this->user->update($data);
            
        }
        if($result){
            $response=[
                "success"=>true,
                "message"=>"Data berhasil diperbaharui",
            ];
        }else{
            $response=[
                "success"=>false,
                "message"=>"Gagal",
            ];
        }
        return $this->respond($response);

    
    }
    public function remove()
    {
        $request = (object)$this->request->getPost();
        $this->user->where('username', $request->username);
        $this->user->delete();
    }
    

    public function all()
    {	
        $request = json_decode($this->request->getGet("request"));
        $search = isset($request->search) ? $request->search[0] : false;
        $result = $this->user;
        if($search){
            $result = $result->like($search->field, $search->value);
        }
        $data = $result->get()->getResult();
        $i=1;
        if($data)
        {
            foreach($data as $dt){
                $usr = (array) $dt;
                $resp[$i-1]["id"]=$i;
                foreach(array_keys($usr) as $col){
                    $resp[$i-1][$col] =  $usr[$col];
                }
                $i++;
            }
        }else{
            $resp = [];
        }

        $response = [
            "success"=>true,
            "data"=>$resp,
            "request"=>$request,
            "search"=>$search,
        ];
        return $this->respond($response);

    }

    public function login()
    {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");


        $user = $this->user->where(["username"=>$username])->get();
        if($user->getNumRows() > 0){
            $getdata = $this->user->where(["username"=>$username])->get()->getRow();

            if (password_verify($password, $getdata->password)) {
                $response=[
                    "success"=>true,
                    "isLogin"=>true,
                    "data"=>[
                        "user_id"=>$getdata->id,
                        "username"=>$getdata->username,
                        "level"=>$getdata->level,
                    ],
                    "message"=>"Anda berhasil Login",
                ];
            } else {
                $response=[
                    "success"=>false,
                    "isLogin"=>false,
                    "message"=>"Password salah",
                ];
            }


        }else{
            $response=[
                "success"=>false,
                "isLogin"=>false,
                "data"=>null,
                "message"=>"Gagal login"
            ];  
        }

        return $this->respond($response);

    
    }
    

}