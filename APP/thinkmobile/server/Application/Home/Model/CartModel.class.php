<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/22
 * Time: 10:14
 */

namespace Home\Model;


use Common\Model\CommonModel;

class CartModel extends CommonModel
{
    private  $product;//��Ʒģ��
    private  $goods;//��Ʒģ��
    private  $brand;//��Ʒģ��
    private  $goods_attr;//��Ʒ����ģ��
    private  $attr;//����ģ��
    private  $user_id;//�û�id
    private  $success=array('code'=>0,'msg'=>'success');//��治��
    private  $nonum=array('code'=>1,'msg'=>'number not enough');//��治��
    private  $noattrid=array('code'=>2,'msg'=>'no attr_id');//����Ʒ����û�д���Ʒ����id
    private  $fail=array('code'=>3,'msg'=>'fail');//���빺�ﳵʧ��
    const INC='inc';
    const DEC='dec';
    protected $_auto = array (
        array('is_real',1),  // ������ʱ���status�ֶ�����Ϊ1
        array('parent_id',0) ,
        array('rec_type',0),
        array('is_gift',0),
        array('can_handsel',0),
    );
    protected $_validate = array(
        array('user_id','require','�û�id���룡'), //Ĭ������������������֤
        array('session_id','require','session_id'), // ��������ʱ����֤name�ֶ��Ƿ�Ψһ
        array('goods_id','require','goods_id'),
        array('product_id','require','product_id'),
        array('goods_name','require','goods_name'),
        array('goods_price','require','goods_price'),
        array('goods_number','require','goods_number'),
    );
    public function _initialize(){
        $this->product=M('products');
        $this->goods_attr=M('goods_attr');
        $this->goods=M('goods');
        $this->attr=M('attribute');
        $this->user_id=session('user.user_id');
    }

    /**
     * ��ȡ���ﳵ�е���Ϣ
     * @return array
     */
    public function getAll(){
        $list=null;
        $result=array();
        $where['user_id']=$this->user_id;
        $data=$this->alias('c')->join('LEFT JOIN __GOODS__ g on g.goods_id = c.goods_id')
            ->field('c.goods_id,c.goods_number,c.goods_name,c.goods_attr,c.goods_price,c.rec_id,c.product_id,g.goods_thumb')
            ->where($where)->select();
        foreach($data as $k=>$v){
            $id=$v['goods_id'];
            $res=$this->goods->alias('g')->join('LEFT JOIN __BRAND__ b on g.brand_id = b.brand_id')
                ->field('g.*,b.*')->where(array('goods_id'=>$id))->select();
            $brand_id=$res[0]['brand_id'];
            $list['brand'][$brand_id]['brand_logo']=$res[0]['brand_logo'];
            $list['brand'][$brand_id]['brand_name']=$res[0]['brand_name'];
            $list['brand'][$brand_id]['brand_id']=$brand_id;
            $list['brand'][$brand_id]['goods'][]=$v;
        }
        foreach($list['brand']  as $k=>$v){
            $result['brand'][]=$v;
        }
        return $result;
    }
    /**
     * ��ȡ��Ʒ���ԵĿ��ͼ۸�
     * @return array|null
     */
    public function getInfo(){
           $data=null;
           $goods_id=I('goods_id',0);
           $attr_id=I('attr_id',0);
           $data=$this->proinfo($goods_id,$attr_id);
           return $data;
    }

    /**
     * ��ȡ��Ʒ�Ŀ��ͼ۸�
     * @param $goods_id ��Ʒid
     * @param $goods_attr ��Ʒ������
     * @return array ��Ʒ�Ŀ��ͼ۸�
     */
    private function proinfo($goods_id,$goods_attr){
        $return_array = array();
        //��ȡ��Ʒ�����Ϣ
        $return_array['number']=$this->getNumber($goods_id,$goods_attr);
        //��ȡ��Ʒ�ļ�
        $return_array['price']=$this->getPrice($goods_id,$goods_attr);
        //�۸����
        return $return_array;
    }
    /**
     * ���빺�ﳵ
     */
    public function addData(){
        $goods_id=I('goods_id',0);
        $attr_id=I('attr_id');
        $number=I('number',1);
        $data=$this->addCart($goods_id,$attr_id,$number);
        return $data;
    }
    private function addCart($goods_id,$attr_id,$number){
        $data=$this->getAttr($goods_id);//��ȡ��Ʒ����
        if($data && !$attr_id){//����Ʒ����û�д���Ʒ����id
          return $this->noattrid;//û����Ʒ
        }
        $result=$this->getCart($goods_id,$attr_id);
        $amount=$this->getNumber($goods_id,$attr_id);//��ȡ���
        if($result){//���ﳵ�д�����Ʒ�͸���
            if(intval($number)+intval($result['goods_number'])>$amount){
                return $this->nonum;//��治��
            }
           $res=$this->addNum($goods_id,$attr_id,$number);
           if($res){
               return $this->success;//��ӳɹ�
           }else{
               return $this->fail;//���ʧ��
           }
        }else{//û�оͼ��빺�ﳵ
            $amount=$this->getNumber($goods_id,$attr_id);

            if(intval($number)>$amount){
                return $this->nonum;//��治��
            }
            $info=array(
                'user_id'=>$this->user_id,
                'session_id'=>session_id(),
                'goods_id'=>$goods_id,
                'goods_attr_id'=>$attr_id,
                'goods_number'=>$number,
                'goods_price'=>$this->getPrice($goods_id,$attr_id)
            );
            $where['goods_id']=$goods_id;
            $ginfo=$this->goods->field('goods_sn,market_price,shop_price,goods_name')->where($where)->find();//��ȡ��Ʒ��Ϣ
            $product=$this->getProduct($goods_id,$attr_id);
            $datas=array_merge($info,$ginfo,$product);
            $datas['goods_attr']=$this->getAttrName($goods_id,$attr_id);
            $res=parent::addData($datas);
            if($res==CommonModel::MSUCCESS){
                return $this->success;//��ӳɹ�
            }else{
                return $this->fail;//���ʧ��
            }
        }
    }
    protected function getAttrName($goods_id,$goods_attr){
        $info=null;
        $attr=explode(',',$goods_attr);
        $where['g.goods_id']=$goods_id;
        $where['a.attr_type']=1;
        $where['g.goods_attr_id']=array('in',$attr);
        $data=$this->goods_attr->alias('g')->join('LEFT JOIN __ATTRIBUTE__ a on g.attr_id = a.attr_id')
            ->field('attr_value,attr_name')->where($where)->select();
        foreach($data as $k=>$v){
            $info.=$v['attr_name'].':';
            $info.=$v['attr_value'].' ';
        }
        return $info;
    }
    /**
     * ��ȡ��Ʒ���
     * @param $goods_id ��Ʒid
     * @param $goods_attr ��Ʒ����
     * @return int �����
     */
    public function getNumber($goods_id,$goods_attr){
        $attr='%'.implode('|',explode(',',$goods_attr)).'%';
        $attr2='%'.implode('|',array_reverse(explode(',',$goods_attr))).'%';
        $where['goods_attr']=array('like',array($attr,$attr2),'or');
        $where['goods_id']=$goods_id;
        $number=$this->product->where($where)->sum('product_number');//��Ʒ���
        return $number?$number:0;
    }

    /**
     * ��ȡ��Ʒ�ļ۸�
     * @param $goods_id ��Ʒid
     * @param $goods_attr ��Ʒ����
     * @return mixed ��Ʒ�ļ۸�
     */
    public function getPrice($goods_id,$goods_attr){
        $attr_id=explode(',',$goods_attr);
        $where['goods_id']=$goods_id;
        $row=$this->goods->field('shop_price')->where($where)->find();
        $shop_price=$row['shop_price'];
        $where['goods_attr_id']=array('in',$attr_id);
        $add_price=$this->goods_attr->where($where)->sum('attr_price');//���ӵļ۸�
        $price=$shop_price+$add_price;
        return $price;
    }

    /**
     * ������Ʒid��ȡ��Ʒ����
     * @param $goods_id ������Ʒid��ȡ��Ʒ����
     * @return mixed ��Ʒ����Ϣ
     */
    public function getAttr($goods_id){
        $where['g.goods_id']=$goods_id;
        $where['a.attr_type']=1;
        $data=$this->goods_attr->alias('g')->join('LEFT JOIN __ATTRIBUTE__ a on g.attr_id = a.attr_id')
            ->where($where)->select();
        return $data;
    }

    /**
     * ������Ʒid����Ʒ����id����ȡ���ﳵ�е���Ʒ��Ϣ
     * @param $goods_id ��Ʒ��id
     * @param $goods_attr ��Ʒ������
     * @return mixed ���ﳵ����Ʒ����Ϣ | null
     */
    public function getCart($goods_id,$goods_attr){
        $where['goods_id']=$goods_id;
        $attr2=implode(',',array_reverse(explode(',',$goods_attr)));
        $where['goods_attr_id']=array('like',array($goods_attr,$attr2),'or');
        $where['user_id']=$this->user_id;
        $data=$this->where($where)->find();
        return $data;
    }

    /**
     * ������Ʒ��Ϣ����ӹ��ﳵ���Ѵ��ڵ���Ʒ
     * @param $goods_id
     * @param $attr_id
     * @param $number
     * @return bool
     */
    public function addNum($goods_id,$attr_id,$number){
        $where=array(
            'user_id'=>$this->user_id,
            'goods_id'=>$goods_id,
            'goods_attr_id'=>$attr_id
        );
        $res=$this->where($where)->setInc('goods_number',$number);
        return $res;
    }

    /**
     * ������Ʒ��Ϣ�����ٹ��ﳵ���Ѵ��ڵ���Ʒ
     * @param $goods_id
     * @param $attr_id
     * @param $number
     * @return bool
     */
    public function decNum($goods_id,$attr_id,$number){
        $where=array(
            'user_id'=>$this->user_id,
            'goods_id'=>$goods_id,
            'goods_attr_id'=>$attr_id
        );
        $res=$this->where($where)->setDec('goods_number',$number);
        return $res;
    }

    /**
     * ��ȡ��Ʒ��Ϣ
     * @param $goods_id
     * @param $goods_attr
     * @return mixed
     */
    protected function getProduct($goods_id,$goods_attr){
        $attr='%'.implode('|',explode(',',$goods_attr)).'%';
        $attr2='%'.implode('|',array_reverse(explode(',',$goods_attr))).'%';
        $where['goods_attr']=array('like',array($attr,$attr2),'or');
        $where['goods_id']=$goods_id;
        $data=$this->product->where($where)->find();//��Ʒ��Ϣ
        return $data;
    }

    /**
     * �޸Ĺ��ﳵ
     * @return bool|int
     */
    public function editCart(){
        $where['rec_id']=I('rec_id',0);
        $number=1;
        $flag=I('flag',CartModel::INC);
        $proid=I('product_id',0);
        $res=0;
        $num=$this->where($where)->field('goods_number')->find();
        if($flag==CartModel::INC){
            $all=$this->product->where(array('product_id'=>$proid))->field('product_number')->find();
            if($num['goods_number']+$number>$all['product_number']){
                return 2;//��治��
            }
            $res= $this->where($where)->setInc('goods_number',$number);
        }else if($flag==CartModel::DEC){
            if($num['goods_number']<=1){
                return $res;
            }
            $res= $this->where($where)->setDec('goods_number',$number);
        }
        return $res;
    }

    /**
     * ɾ�����ﳵ�е�ָ����Ʒ
     * @return mixed
     */
    public function del(){
        $where=array(
            'user_id'=>$this->user_id,
            'rec_id'=>I('rec_id',0),
        );
        $res=$this->where($where)->delete();
        return $res;
    }
}