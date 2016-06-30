<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/15
 * Time: 9:45
 */

namespace Common\Controller;
use Common\Util\WeiUtil;
use Think\Controller;

class CommonController extends Controller
{
    protected $wei;
    protected $model;
    function _initialize(){
        //session('user',array('id'=>2));
    }
    /**
     * ����������ҳ��ʾ��������
     */
    public function index(){
        $search=I('search',null);
        $list= $this->model->getAll();
        $show=$this->model->getPage();
        if($list){
            $data['list'] =$list;
            $this->ajaxReturn($data);
        }else{
            $this->ajaxReturn(0);
        }
    }

    /**
     * ����ָ����idɾ������
     */
    public function delete(){
        $id=I('id',0);
        $res=$this->model->delete($id);
        if($res){
            $this->success("ɾ���ɹ�");
        }else{
            $this->error("ɾ��ʧ��");
        }
    }

    /**
     * �������ݽ������
     * @param $data ��������ݣ�û�оͻ�ȡpost������
     */
    public function add($data=null){
        if(IS_POST) {
            $res = $this->model->addData($data);
            if ($res == CommonModel::MSUCCESS) {
                $this->success("��ӳɹ�");
            } else {
                $this->error("���ʧ��");
            }
        }else{
            $this->display();
        }
    }

    /**
     * �������ݽ����޸�
     * @param $data ��������ݣ�û�оͻ�ȡpost������
     */
    public function save($data=null){
        if(IS_POST) {
            $res = $this->model->editData($data);
            if ($res == CommonModel::MSUCCESS) {
                $this->success("�༭�ɹ�");
            } else {
                $this->error("�༭ʧ��");
            }
        }else{
            $id=I('id',0);
            $res = $this->model->getOne(array('id'=>$id));//����������ȡ����
            $this->assign("data",$res);//��������
            $this->display();
        }
    }
    protected function msg($data){
        if($data){
            ajax($data);
        }else{
            ajax(0);
        }
    }
    public function isLogin(){
            $flag=true;
            if(session('user.user_id')<1){
                $data['code']=5;
                $data['msg']='no login';
                $this->msg($data);
            }
            return $flag;
    }
}