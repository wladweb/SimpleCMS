<?php

namespace Wladweb\SimpleCMS\Model;

use RedBeanPHP\RedException;

class Users extends BlogModel{
    
    const TABLE = 'users';
    
    public function add($data){
        $data['lastvote'] = date('Y-m-d H:i:s', time());
        $data['role_id'] = 2;
        $data['ukey'] = null;
        $data['avatar'] = 'site.gif';
        
        try{
            return $this->addRow(self::TABLE, $data);
        } catch (RedException $e){
            return false;
        }
    }
    
    public function get($data){
        
        if (is_int($data)){
            return $this->getRow(self::TABLE, $data);
        }elseif (is_array($data)){
            
            $sql = $data['sql'];unset($data['sql']);
            return $this->findRow(self::TABLE, $sql, $data);
        }
    }
    
    public function getUsersList($start, $size){
        $sql = 'ORDER BY id ASC';
        
        $collection = $this->getCollection(self::TABLE, $start, $size, $sql);
        
        while ($row = $collection->next()){
            $bufer['uid'] = $row->id;
            $bufer['uname'] = $row->uname;
            $bufer['utime'] = $row->utime;
            $bufer['avatar'] = $row->avatar;
            $bufer['uemail'] = $row->uemail;
            $bufer['lastvote'] = $row->lastvote;
            $bufer['post'] = $row->utime;
            $bufer['role'] = $row->role;
            $bufer['coment_count'] = count($row->ownCommentsList);
            $result['users'][] = $bufer;
        }
        $result['users_count'] = $this->getCount(self::TABLE);
        return $result;
    }
    
    public function delete($id){
        $this->deleteRow(self::TABLE, $id);
    }
    
    public function update($data){
        return $this->updateRow(self::TABLE, (int)$data['uid'], $data);
    }
}

