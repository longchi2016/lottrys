<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/25
 * Time: 16:04
 */

namespace Common\Util\AlipayMobile;


class AlipayConfig
{

     const PARTNER='#';//���������id����2088��ͷ��16λ������
     const ALIURL='https://mapi.alipay.com/gateway.do?';//���������id����2088��ͷ��16λ������

     const SENDER='#';//�տ�֧�����˺ţ�һ��������տ��˺ž���ǩԼ�˺�

     const  KEY='#';//��ȫ�����룬�����ֺ���ĸ��ɵ�32λ�ַ�

     const RSA='RSA';//ǩ����ʽ �����޸�
     //֧������Կ����׺��.pen���ļ����·��
     const PUBLIC_KEY='./key/alipay_public_key.pem';
     //�̻���˽Կ����׺��.pem���ļ��ľ���·��
     const PRIVATE_KEY='/Application/Common/Util/AlipayMobile/key/rsa_private_key.pem';
     const CHARSET='utf-8';//�ַ������ʽ Ŀǰ֧�� gbk �� utf-8
     //ca֤��·����ַ������curl��sslУ��
     //�뱣֤cacert.pem�ļ��ڵ�ǰ�ļ���Ŀ¼��
      const TRANSPORT='http';
     const NOTIFY_URL='#';
}