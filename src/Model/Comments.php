<?php

namespace Wladweb\SimpleCMS\Model;

class Comments extends BlogModel{
    
    const TABLE = 'comments';
    
    public function add($data){
        return $this->addRow(self::TABLE, $data);
    }
    
    public function getLastComments(){
        
        $sql = 'ORDER BY ctime DESC';
        
        $collection = $this->getCollection(self::TABLE, 0, 5, $sql);
        while ($row = $collection->next()){
            $bufer['cbody'] = mb_substr($row->cbody, 0, 100, 'utf-8');
            $bufer['anchor'] = $row->anchor;
            $bufer['author'] = $row->users->uname;
            $bufer['post_id'] = $row->posts->id;
            $result[] = $bufer;
        }
        
        return $result;
    }
    
    public function getCommentsList($start, $size){
        $sql = 'ORDER BY ctime DESC';
        
        $collection = $this->getCollection(self::TABLE, $start, $size, $sql);
        while ($row = $collection->next()){
            $bufer['cid'] = $row->id;
            $bufer['cbody'] = $row->cbody;
            $bufer['ctime'] = $row->ctime;
            $bufer['anchor'] = $row->anchor;
            $bufer['user'] = $row->users;
            $bufer['post'] = $row->posts;
            $result['comments'][] = $bufer;
        }
        $result['comment_count'] = $this->getCount(self::TABLE);
        return $result;
    }
    
    public function update($data){
        return $this->updateRow(self::TABLE, $data['cid'], $data);
    }
    
    public function delete($id){
        $this->deleteRow(self::TABLE, $id);
    }
}

