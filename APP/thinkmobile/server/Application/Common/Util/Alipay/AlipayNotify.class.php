<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/25
 * Time: 16:04
 */

namespace Common\Util\Alipay;


class AlipayNotify
{
     private $parameter;
     function  __construct(){
          $this->parameter=array(
              "service" => "create_direct_pay_by_user",//�ӿ�����,��ʱ����
              "partner" => trim(AlipayConfig::PARTNER),//���������id
              "seller_email" => trim(AlipayConfig::SENDER),//�տ�֧�����˺�
              "payment_type"	=> 1,//֧������  1  ��Ʒ����   ֻ��Ϊ1
              "notify_url"	=> AlipayConfig::NOTIFY_URL,//֪ͨ��ַ
              "return_url"	=> AlipayConfig::RETURN_URL,//��ת��ַ
              "_input_charset"	=> trim(strtolower(AlipayConfig::CHARSET))//���������ַ���
          );
     }
     /**
      * ����Ҫ�����֧�����Ĳ�������
      * @param $para_temp ����ǰ�Ĳ�������
      * @return Ҫ����Ĳ�������
      */
     public  function buildRequestPara($data) {
          $this->parameter=array_merge($this->parameter,$data);

          //��ȥ��ǩ�����������еĿ�ֵ��ǩ������
          $para_filter = AlipayCore::paraFilter($this->parameter);

          //�Դ�ǩ��������������
          $para_sort = AlipayCore::argSort($para_filter);
          //����ǩ�����
          $mysign = $this->buildRequestMysign($para_sort);

          //ǩ�������ǩ����ʽ���������ύ��������
          $para_sort['sign'] = $mysign;
          $para_sort['sign_type'] = strtoupper(trim(AlipayConfig::TYPE));

          return $para_sort;
     }
     /**
      * ����ǩ�����
      * @param $para_sort ������Ҫǩ��������
      * return ǩ������ַ���
      */
     private function buildRequestMysign($para_sort) {
          //����������Ԫ�أ����ա�����=����ֵ����ģʽ�á�&���ַ�ƴ�ӳ��ַ���
          $prestr = AlipayCore::createLinkstring($para_sort);

          $mysign = "";
          switch (strtoupper(trim(AlipayConfig::TYPE))) {
               case "MD5" :
                    $mysign = AlipayCore::md5Sign($prestr, AlipayConfig::KEY);
                    break;
               default :
                    $mysign = "";
          }

          return $mysign;
     }
     /**
      * ����Ҫ�����֧������֧��url
      * @param $para_temp ����ǰ�Ĳ�������
      * @return Ҫ����Ĳ��������ַ���
      */
     function url($para_temp) {
          //�������������
          $para = $this->buildRequestPara($para_temp);

          //�Ѳ�����������Ԫ�أ����ա�����=����ֵ����ģʽ�á�&���ַ�ƴ�ӳ��ַ����������ַ�����urlencode����
          $request_data = AlipayCore::createLinkstringUrlencode($para);
          return AlipayConfig::ALIURL.$request_data;
     }
}