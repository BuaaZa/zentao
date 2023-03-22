# README

[![pipeline status](http://121.89.178.134/15-test-group/zentaopms/badges/main/pipeline.svg)](http://121.89.178.134/15-test-group/zentaopms/-/commits/main) |
[![coverage report](http://121.89.178.134/15-test-group/zentaopms/badges/main/coverage.svg)](http://121.89.178.134/15-test-group/zentaopms/-/commits/main) |
[![Latest Release](http://121.89.178.134/15-test-group/zentaopms/-/badges/release.svg)](http://121.89.178.134/15-test-group/zentaopms/-/releases)

## Description

基于[禅道开源版17.7](https://www.zentao.net/dynamic/zentaopms17.7-81744.html)实现

+ [production环境](http://123.57.214.35:50000/product/zentaopms/www/index.php)
+ [main分支环境（Docker）](http://121.89.178.134:50000/zentaopms/www/index.php)
+ [精简版环境（Docker）](http://121.89.178.134:50001/zentaopms/www/index.php)
+ [禅道17.7原版环境（Docker）](http://121.89.178.134:50002/zentaopms/www/index.php)

## Installation

> 请在`Apache2`的`WebServer`下开发项目（通常是`/var/www/html/`），并设置所有者为`$USER`，设置访问权限为`777`
>
> 推荐使用`PhpStorm`开发

## Development

### Don't

+ 利用拓展机制开发，这样导致其他人在源码基础上修改后的结果在预期之外

### Please

+ 良好的git协作习惯，选择一种合适的[提交（commit）](https://www.ruanyifeng.com/blog/2016/01/commit_message_change_log.html)方式，使你的提交易于理解

## [License](https://gitee.com/wwccss/zentaopms/blob/master/COPYING)
