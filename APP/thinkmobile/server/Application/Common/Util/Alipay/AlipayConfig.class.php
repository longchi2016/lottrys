<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/25
 * Time: 16:04
 */

namespace Common\Util\Alipay;


class AlipayConfig
{

     const PARTNER='#';//���������id����2088��ͷ��16λ������
     const ALIURL='https://mapi.alipay.com/gateway.do?';//���������id����2088��ͷ��16λ������

     const SENDER='#';//�տ�֧�����˺ţ�һ��������տ��˺ž���ǩԼ�˺�

     const  KEY='#';//��ȫ�����룬�����ֺ���ĸ��ɵ�32λ�ַ�

     const TYPE='MD5';//ǩ����ʽ �����޸�

     const CHARSET='utf-8';//�ַ������ʽ Ŀǰ֧�� gbk �� utf-8
     //ca֤��·����ַ������curl��sslУ��
     //�뱣֤cacert.pem�ļ��ڵ�ǰ�ļ���Ŀ¼��
     const CACERT='cacert.pem';
     //����ģʽ,�����Լ��ķ������Ƿ�֧��ssl���ʣ���֧����ѡ��https������֧����ѡ��http
     const TRANSPORT='http';
     const NOTIFY_URL='#';
     const RETURN_URL='#';
}