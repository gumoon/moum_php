## 域名说明

1. 阿里云测试服务器api域名：http://moum.xiaoyuweb.cn/api/v1
2. 生产服务器api域名：https://moum.xiaoyuweb.cn/api/v1

## 注意事项

1. 生产环境下接口域名请用 https 协议
2. 请兼容接口名和返回值变化的可能性。
3. 接口调用需要先获得access_token，每次调用接口，需要通过http头传递 Authorization和uuid。
