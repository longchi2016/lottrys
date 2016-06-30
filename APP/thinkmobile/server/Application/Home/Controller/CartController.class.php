<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/22
 * Time: 10:15
 */

namespace Home\Controller;


use Common\Controller\CommonController;
use Home\Model\CartModel;

class CartController extends CommonController
{
    public function _initialize(){
        $this->model=D('Cart');
    }

    /**
     * ��ȡ��Ʒ������Ϣ
     */
    public function getInfo(){
        $data=$this->model->getInfo();
        $this->msg($data);
    }

    /**
     * ���빺�ﳵ
     */
    public function add(){
        if($this->isLogin()){
           $data=$this->model->addData();
            $this->msg($data);
        }
    }

    /**
     * �༭���ﳵ
     */
    public function edit(){
        if($this->isLogin()) {
            $res = $this->model->editCart();
            $this->msg($res);
        }
    }
    /**
     * ɾ�����ﳵ�е�ָ����Ʒ
     * @return mixed
     */
    public function delete(){
        if($this->isLogin()) {
            $res = $this->model->del();
            $this->msg($res);
        }
    }
}