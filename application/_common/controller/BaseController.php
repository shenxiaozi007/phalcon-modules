<?php
namespace App\Com\Controller;
use Phalcon\Mvc\Controller;

class BaseController extends Controller {
    
    

    public function initialize() {
        $this->view->setTemplateAfter('main');
    }
    
    
    
    protected function getList($from, $columns="*", $where="", $join="", $order="", $group="", $limit=10){

        $builder = $this->modelsManager->createBuilder();
        
        if(empty($join)){
            $data=$builder->columns($columns)->from($from)->where($where)
                         ->orderBy($order)
                         ->groupBy($group)
                         ->limit($limit)->getQuery()->execute();
        }else{
            $data=$builder->columns($columns)->from($from)->where($where)
            ->join($join['table'],$join['on'],$join['as'])
            ->orderBy($order) ->groupBy($group)->limit($limit)->getQuery()->execute();
        }
        
        return  $data;
      
    }
}