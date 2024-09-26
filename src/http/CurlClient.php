<?php

namespace http;

class CurlClient
{
    public function CurlRequest($url, array $data = [], $method = 'GET', array $headers = [], array $options = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.104 Safari/537.36 Core/1.53.2372.400 QQBrowser/9.5.10548.400');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);

        // 处理 headers 键值对，转换成 cURL 需要的格式
        if (!empty($headers)) {
            $formattedHeaders = [];
            foreach ($headers as $key => $value) {
                $formattedHeaders[] = "$key: $value";
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $formattedHeaders);
        }

        // 处理请求方法
        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'DELETE':
            case 'PUT':
            case 'PATCH':
            case 'OPTIONS':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method)); // 使用自定义的 HTTP 方法
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // 对于 DELETE, PUT 等方法，仍然可以传数据
                }
                break;
            default:
                // 对于 GET 等其他默认方法，什么都不做，直接请求
                break;
        }

        // 传入额外的 cURL 选项
        if (!empty($options)) {
            curl_setopt_array($curl, $options);
        }

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 需要返回响应体

        // 执行请求并获取结果
        $result = curl_exec($curl);

        if ($result === false) {
            // 获取 cURL 错误信息
            $error = curl_error($curl);
        } else {
            // 获取状态码
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        }

        curl_close($curl);

        // 返回状态码和响应体
        return [
            'code' => $httpCode ?? 0,
            'body' => $result,
            'msg' => $error ?? "",
        ];
    }

}