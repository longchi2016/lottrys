<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2015/12/25
 * Time: 16:04
 */

namespace Common\Util\AlipayMobile;


class AlipayCore
{
    /**
     * ����������Ԫ�أ����ա�����=����ֵ����ģʽ�á�&���ַ�ƴ�ӳ��ַ���
     * @param $para ��Ҫƴ�ӵ�����
     * return ƴ������Ժ���ַ���
     */
    public static function  createLinkstring($para) {
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
     * ����������Ԫ�أ����ա�����=����ֵ����ģʽ�á�&���ַ�ƴ�ӳ��ַ����������ַ�����urlencode����
     * @param $para ��Ҫƴ�ӵ�����
     * return ƴ������Ժ���ַ���
     */
    public static function createLinkstringUrlencode($para) {
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
    public static function argSort($para) {
        ksort($para);
        reset($para);
        return $para;
    }
    /**
     * д��־��������ԣ�����վ����Ҳ���ԸĳɰѼ�¼�������ݿ⣩
     * ע�⣺��������Ҫ��ͨfopen����
     * @param $word Ҫд����־����ı����� Ĭ��ֵ����ֵ
     */
    public static function logResult($word='') {
        $fp = fopen("log.txt","a");
        flock($fp, LOCK_EX) ;
        fwrite($fp,"ִ�����ڣ�".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    /**
     * Զ�̻�ȡ���ݣ�POSTģʽ
     * ע�⣺
     * 1.ʹ��Crul��Ҫ�޸ķ�������php.ini�ļ������ã��ҵ�php_curl.dllȥ��ǰ���";"������
     * 2.�ļ�����cacert.pem��SSL֤���뱣֤��·����Ч��ĿǰĬ��·���ǣ�getcwd().'\\cacert.pem'
     * @param $url ָ��URL����·����ַ
     * @param $cacert_url ָ����ǰ����Ŀ¼����·��
     * @param $para ���������
     * @param $input_charset �����ʽ��Ĭ��ֵ����ֵ
     * return Զ�����������
     */
    public static function getHttpResponsePOST($url, $cacert_url, $para, $input_charset = '') {

        if (trim($input_charset) != '') {
            $url = $url."_input_charset=".$input_charset;
        }
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL֤����֤
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//�ϸ���֤
        curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//֤���ַ
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // ����HTTPͷ
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// ��ʾ������
        curl_setopt($curl,CURLOPT_POST,true); // post��������
        curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post��������
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//���ִ��curl�����г����쳣���ɴ򿪴˿��أ��Ա�鿴�쳣����
        curl_close($curl);

        return $responseText;
    }

    /**
     * Զ�̻�ȡ���ݣ�GETģʽ
     * ע�⣺
     * 1.ʹ��Crul��Ҫ�޸ķ�������php.ini�ļ������ã��ҵ�php_curl.dllȥ��ǰ���";"������
     * 2.�ļ�����cacert.pem��SSL֤���뱣֤��·����Ч��ĿǰĬ��·���ǣ�getcwd().'\\cacert.pem'
     * @param $url ָ��URL����·����ַ
     * @param $cacert_url ָ����ǰ����Ŀ¼����·��
     * return Զ�����������
     */
    public static function getHttpResponseGET($url,$cacert_url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // ����HTTPͷ
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// ��ʾ������
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL֤����֤
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//�ϸ���֤
        curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//֤���ַ
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//���ִ��curl�����г����쳣���ɴ򿪴˿��أ��Ա�鿴�쳣����
        curl_close($curl);

        return $responseText;
    }

    /**
     * ʵ�ֶ����ַ����뷽ʽ
     * @param $input ��Ҫ������ַ���
     * @param $_output_charset ����ı����ʽ
     * @param $_input_charset ����ı����ʽ
     * return �������ַ���
     */
    public static function charsetEncode($input,$_output_charset ,$_input_charset) {
        $output = "";
        if(!isset($_output_charset) )$_output_charset  = $_input_charset;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset change.");
        return $output;
    }
    /**
     * ʵ�ֶ����ַ����뷽ʽ
     * @param $input ��Ҫ������ַ���
     * @param $_output_charset ����Ľ����ʽ
     * @param $_input_charset ����Ľ����ʽ
     * return �������ַ���
     */
    public static  function charsetDecode($input,$_input_charset ,$_output_charset) {
        $output = "";
        if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset changes.");
        return $output;
    }
    /**
     * RSAǩ��
     * @param $data ��ǩ������
     * @param $private_key_path �̻�˽Կ�ļ�·��
     * return ǩ�����
     */
    public static  function rsaSign($data, $private_key_path) {
        $priKey = file_get_contents(dirname($_SERVER['SCRIPT_FILENAME']).$private_key_path);
        $res = openssl_get_privatekey($priKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        //base64����
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * RSA��ǩ
     * @param $data ��ǩ������
     * @param $ali_public_key_path ֧�����Ĺ�Կ�ļ�·��
     * @param $sign ҪУ�Եĵ�ǩ�����
     * return ��֤���
     */
    public static function rsaVerify($data, $ali_public_key_path, $sign)  {
        $pubKey = file_get_contents($ali_public_key_path);
        $res = openssl_get_publickey($pubKey);
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        openssl_free_key($res);
        return $result;
    }

    /**
     * RSA����
     * @param $content ��Ҫ���ܵ����ݣ�����
     * @param $private_key_path �̻�˽Կ�ļ�·��
     * return ���ܺ����ݣ�����
     */
    public static  function rsaDecrypt($content, $private_key_path) {
        $priKey = file_get_contents($private_key_path);
        $res = openssl_get_privatekey($priKey);
        //��base64�����ݻ�ԭ�ɶ�����
        $content = base64_decode($content);
        //����Ҫ���ܵ����ݣ���128λ�𿪽���
        $result  = '';
        for($i = 0; $i < strlen($content)/128; $i++  ) {
            $data = substr($content, $i * 128, 128);
            openssl_private_decrypt($data, $decrypt, $res);
            $result .= $decrypt;
        }
        openssl_free_key($res);
        return $result;
    }
}