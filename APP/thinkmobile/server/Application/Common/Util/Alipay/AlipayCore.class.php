<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/25
 * Time: 16:04
 */

namespace Common\Util\Alipay;


class AlipayCore
{
 /**
 * ��ȥ�����еĿ�ֵ��ǩ������
 * @param $para ǩ��������
 * return ȥ����ֵ��ǩ�����������ǩ��������
 */
  public static function paraFilter($para) {
     $para_filter = array();
     while (list ($key, $val) = each ($para)) {
          if($key == "sign" || $key == "sign_type" || $val == "")continue;
          else	$para_filter[$key] = $para[$key];
     }
     return $para_filter;
    }
     /**
      * ����������
      * @param $para ����ǰ������
      * return ����������
      */
     function argSort($para) {
          ksort($para);
          reset($para);
          return $para;
     }
     /**
      * ����������Ԫ�أ����ա�����=����ֵ����ģʽ�á�&���ַ�ƴ�ӳ��ַ���
      * @param $para ��Ҫƴ�ӵ�����
      * return ƴ������Ժ���ַ���
      */
     function createLinkstring($para) {
          $arg  = "";
          while (list ($key, $val) = each ($para)) {
               $arg.=$key."=".$val."&";
          }
          //ȥ�����һ��&�ַ�
          $arg = substr($arg,0,count($arg)-2);

          //�������ת���ַ�����ôȥ��ת��
          if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

          return $arg;
     }
     /**
      * ǩ���ַ���
      * @param $prestr ��Ҫǩ�����ַ���
      * @param $key ˽Կ
      * return ǩ�����
      */
     function md5Sign($prestr, $key) {
          $prestr = $prestr . $key;
          return md5($prestr);
     }
     /**
      * ����������Ԫ�أ����ա�����=����ֵ����ģʽ�á�&���ַ�ƴ�ӳ��ַ����������ַ�����urlencode����
      * @param $para ��Ҫƴ�ӵ�����
      * return ƴ������Ժ���ַ���
      */
     function createLinkstringUrlencode($para) {
          $arg  = "";
          while (list ($key, $val) = each ($para)) {
               $arg.=$key."=".urlencode($val)."&";
          }
          //ȥ�����һ��&�ַ�
          $arg = substr($arg,0,count($arg)-2);

          //�������ת���ַ�����ôȥ��ת��
          if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

          return $arg;
     }
}