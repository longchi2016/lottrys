<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/25
 * Time: 16:04
 */

namespace Common\Util\AlipayMobile;

class AlipaySubmit
{
     private $parameter;
     function  __construct(){
          $this->parameter=array(
              'service'        => 'mobile.securitypay.pay',
              "partner" => trim(AlipayConfig::PARTNER),//���������id
              "seller_id" => trim(AlipayConfig::SENDER),//�տ�֧�����˺�
              "payment_type"	=> 1,//֧������  1  ��Ʒ����   ֻ��Ϊ1
              "notify_url"	=> AlipayConfig::NOTIFY_URL,//֪ͨ��ַ
              "_input_charset"	=> trim(strtolower(AlipayConfig::CHARSET)),//���������ַ���
          );
     }

     /**
      * �����ύ�Ĳ�������װ֧����������ַ���
      * @param $data
      * @return ���������
      */
     function buildRequestPara($data){
          $this->parameter=array_merge($this->parameter,$data);
          //��ȥ��ǩ�����������еĿ�ֵ��ǩ������
          $para_filter = AlipayCore::paraFilter($this->parameter);

          //�Դ�ǩ��������������
          $para_sort = AlipayCore::argSort($para_filter);
          //����ǩ�����
          $mysign = $this->buildRequestMysign($para_sort);
          //ǩ�������ǩ����ʽ���������ύ��������
          $para_sort['sign'] = $mysign;
          $para_sort['sign_type'] = strtoupper(trim(AlipayConfig::RSA));
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

          $mysign = AlipayCore::rsaSign($prestr,AlipayConfig::PRIVATE_KEY);

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
          //return AlipayConfig::ALIURL.$request_data;
          return $request_data;
     }
}