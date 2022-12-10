CREATE OR REPLACE VIEW `ztv_projectsummary` AS select `zt_task`.`project` AS `project`,sum(if((`zt_task`.`parent` >= '0'),`zt_task`.`estimate`,0)) AS `estimate`,sum(if((`zt_task`.`parent` >= '0'),`zt_task`.`consumed`,0)) AS `consumed`,sum(if(((`zt_task`.`status` <> 'cancel') and (`zt_task`.`status` <> 'closed') and (`zt_task`.`parent` >= '0')),`zt_task`.`left`,0)) AS `left`,count(0) AS `number`,sum(if(((`zt_task`.`status` = 'wait') or (`zt_task`.`status` = 'doing')),1,0)) AS `undone`,sum((if((`zt_task`.`parent` >= '0'),`zt_task`.`consumed`,0) + if(((`zt_task`.`status` <> 'cancel') and (`zt_task`.`status` <> 'closed') and (`zt_task`.`parent` >= '0')),`zt_task`.`left`,0))) AS `totalReal` from `zt_task` where (`zt_task`.`deleted` = '0') group by `zt_task`.`project`;
UPDATE `zt_report` SET `langs` = '{\"stories\":{\"zh-cn\":\"\\u9700\\u6c42\\u603b\\u6570\",\"zh-tw\":\"\\u9700\\u6c42\\u603b\\u6570\",\"en\":\"Stories\"},\"doneStory\":{\"zh-cn\":\"\\u5b8c\\u6210\\u9700\\u6c42\\u6570\",\"zh-tw\":\"\\u5b8c\\u6210\\u9700\\u6c42\\u6570\",\"en\":\"Finished Stories\"},\"number\":{\"zh-cn\":\"\\u4efb\\u52a1\\u603b\\u6570\",\"zh-tw\":\"\\u4efb\\u52a1\\u603b\\u6570\",\"en\":\"Tasks\"},\"doneTask\":{\"zh-cn\":\"\\u5b8c\\u6210\\u4efb\\u52a1\\u6570\",\"zh-tw\":\"\\u5b8c\\u6210\\u4efb\\u52a1\\u6570\",\"en\":\"Finished Tasks\"},\"bugs\":{\"zh-cn\":\"Bug\\u6570\",\"zh-tw\":\"Bug\\u6570\",\"en\":\"Bugs\"},\"resolutions\":{\"zh-cn\":\"\\u89e3\\u51b3Bug\\u6570\",\"zh-tw\":\"\\u89e3\\u51b3Bug\\u6570\",\"en\":\"Solutions\"},\"bugthanstory\":{\"zh-cn\":\"Bug\\/\\u5b8c\\u6210\\u9700\\u6c42\",\"zh-tw\":\"Bug\\/\\u5b8c\\u6210\\u9700\\u6c42\",\"en\":\"Bugs\\/FinishedStories\"},\"bugthantask\":{\"zh-cn\":\"Bug\\/\\u5b8c\\u6210\\u4efb\\u52a1\",\"zh-tw\":\"Bug\\/\\u5b8c\\u6210\\u4efb\\u52a1\",\"en\":\"Bugs\\/FinishedTasks\"},\"seriousBugs\":{\"zh-cn\":\"\\u91cd\\u8981Bug\\u6570\",\"zh-tw\":\"\\u91cd\\u8981Bug\\u6570\",\"en\":\"Serious Bugs\"},\"seriousBugsPercent\":{\"zh-cn\":\"\\u4e25\\u91cdBug\\u6bd4\\u7387\",\"zh-tw\":\"\\u4e25\\u91cdBug\\u6bd4\\u7387\",\"en\":\"Severe bug ratio\"}}' WHERE `code`='project-quality';
UPDATE `zt_report` SET `langs` = '{\"stories\":{\"zh-cn\":\"\\u9700\\u6c42\\u603b\\u6570\",\"zh-tw\":\"\\u9700\\u6c42\\u603b\\u6570\",\"en\":\"Stories\"},\"doneStory\":{\"zh-cn\":\"\\u5b8c\\u6210\\u9700\\u6c42\\u6570\",\"zh-tw\":\"\\u5b8c\\u6210\\u9700\\u6c42\\u6570\",\"en\":\"Finished Stories\"},\"bugs\":{\"zh-cn\":\"Bug\\u6570\",\"zh-tw\":\"Bug\\u6570\",\"en\":\"Bugs\"},\"resolutions\":{\"zh-cn\":\"\\u89e3\\u51b3Bug\\u6570\",\"zh-tw\":\"\\u89e3\\u51b3Bug\\u6570\",\"en\":\"Solved Bugs\"},\"bugthanstory\":{\"zh-cn\":\"Bug\\/\\u5b8c\\u6210\\u9700\\u6c42\",\"zh-tw\":\"Bug\\/\\u5b8c\\u6210\\u9700\\u6c42\",\"en\":\"Bugs\\/FinishedStories\"},\"seriousBugs\":{\"zh-cn\":\"\\u91cd\\u8981Bug\\u6570\",\"zh-tw\":\"\\u91cd\\u8981Bug\\u6570\",\"en\":\"Serious Bugs\"},\"seriousBugsPercent\":{\"zh-cn\":\"\\u4e25\\u91cdbug\\u6bd4\\u7387\",\"zh-tw\":\"\\u4e25\\u91cdbug\\u6bd4\\u7387\",\"en\":\"Serious Bugs %\"}}' WHERE `code` = 'product-quality';
UPDATE `zt_report` SET `name` = '{\"zh-cn\":\"\\u516c\\u53f8\\u52a8\\u6001\\u6c47\\u603b\\u8868\",\"zh-tw\":\"\\u516c\\u53f8\\u52d5\\u614b\\u5f59\\u7e3d\\u8868\",\"en\":\"Company Dynamics\"}', `desc` = '{\"zh-cn\":\"\\u53ef\\u4ee5\\u6307\\u5b9a\\u4e00\\u4e2a\\u65f6\\u671f\\uff0c\\u5217\\u51fa\\u76f8\\u5e94\\u7684\\u6570\\u636e\\uff1a1. \\u6bcf\\u5929\\u7684\\u767b\\u5f55\\u6b21\\u6570\\u30022. \\u6bcf\\u5929\\u7684\\u65e5\\u5fd7\\u5de5\\u65f6\\u91cf\\u30023. \\u6bcf\\u5929\\u65b0\\u589e\\u7684\\u9700\\u6c42\\u6570\\u30024. \\u6bcf\\u5929\\u5173\\u95ed\\u7684\\u9700\\u6c42\\u6570\\u30025. \\u6bcf\\u5929\\u65b0\\u589e\\u7684\\u4efb\\u52a1\\u6570\\u30026. \\u6bcf\\u5929\\u5b8c\\u6210\\u7684\\u4efb\\u52a1\\u6570\\u30027. \\u6bcf\\u5929\\u65b0\\u589e\\u7684Bug\\u6570\\u30028. \\u6bcf\\u5929\\u89e3\\u51b3\\u7684Bug\\u6570\\u30029. \\u6bcf\\u5929\\u7684\\u52a8\\u6001\\u6570\\u3002\",\"zh-tw\":\"\\u53ef\\u4ee5\\u6307\\u5b9a\\u4e00\\u500b\\u6642\\u671f\\uff0c\\u5217\\u51fa\\u76f8\\u61c9\\u7684\\u6578\\u64da\\uff1a1.\\u6bcf\\u5929\\u7684\\u767b\\u9304\\u6b21\\u6578\\u30022.\\u6bcf\\u5929\\u7684\\u65e5\\u8a8c\\u5de5\\u6642\\u91cf\\u30023.\\u6bcf\\u5929\\u65b0\\u589e\\u7684\\u9700\\u6c42\\u6578\\u30024.\\u6bcf\\u5929\\u95dc\\u9589\\u7684\\u9700\\u6c42\\u6578\\u30025.\\u6bcf\\u5929\\u65b0\\u589e\\u7684\\u4efb\\u52d9\\u6578\\u30026.\\u6bcf\\u5929\\u5b8c\\u6210\\u7684\\u4efb\\u52d9\\u6578\\u30027.\\u6bcf\\u5929\\u65b0\\u589e\\u7684Bug\\u6578\\u30028.\\u6bcf\\u5929\\u89e3\\u51b3\\u7684Bug\\u6578\\u30029.\\u6bcf\\u5929\\u7684\\u52d5\\u614b\\u6578\\u3002\",\"en\":\"The summary of company dynamics\"}' WHERE `code` = 'company-dynamic';
UPDATE `zt_report` SET `desc` = '{\"zh-cn\":\"\\u67e5\\u770b\\u67d0\\u4e2a\\u65f6\\u95f4\\u6bb5\\u5185\\u7684\\u65e5\\u5fd7\\u60c5\\u51b5\\uff0c\\u53ef\\u4ee5\\u6309\\u7167\\u90e8\\u95e8\\u9009\\u62e9\\u3002\",\"zh-tw\":\" \\u67e5\\u770b\\u67d0\\u500b\\u6642\\u9593\\u6bb5\\u5167\\u7684\\u65e5\\u8a8c\\u60c5\\u51b5\\uff0c\\u53ef\\u4ee5\\u6309\\u7167\\u90e8\\u9580\\u9078\\u64c7\\u3002 \",\"en\":\"The summary of user efforts.\"}' WHERE `code` = 'effort';
UPDATE `zt_report` SET `desc` = '{\"zh-cn\":\"\\u5b9e\\u73b0\\u5458\\u5de5\\u767b\\u5f55\\u6b21\\u6570\\u7edf\\u8ba1\\u62a5\\u8868\\uff0c\\u6309\\u7167\\u5929\\u7edf\\u8ba1\\u6bcf\\u5929\\u6bcf\\u4e2a\\u4eba\\u7684\\u767b\\u5f55\\u6b21\\u6570\\uff0c\\u4ee5\\u53ca\\u603b\\u6570\\u3002\",\"zh-tw\":\"\\u5be6\\u73fe\\u54e1\\u5de5\\u767b\\u9304\\u6b21\\u6578\\u7d71\\u8a08\\u5831\\u8868\\uff0c\\u6309\\u5929\\u7d71\\u8a08\\u6bcf\\u5929\\u6bcf\\u500b\\u4eba\\u7684\\u767b\\u9304\\u6b21\\u6578\\uff0c\\u4ee5\\u53ca\\u7e3d\\u6578\\u3002 \",\"en\":\"The summary of user login times.\"}' WHERE `code` = 'user-login';
UPDATE `zt_report` SET `desc` = '{\"zh-cn\":\"\\u67e5\\u770b\\u67d0\\u4e2a\\u65f6\\u95f4\\u6bb5\\u5185\\u7684\\u65e5\\u5fd7\\u60c5\\u51b5\\uff0c\\u53ef\\u4ee5\\u6309\\u7167\\u90e8\\u95e8\\u9009\\u62e9\\u3002\",\"zh-tw\":\" \\u67e5\\u770b\\u67d0\\u500b\\u6642\\u9593\\u6bb5\\u5167\\u7684\\u65e5\\u8a8c\\u60c5\\u51b5\\uff0c\\u53ef\\u4ee5\\u6309\\u7167\\u90e8\\u9580\\u9078\\u64c7\\u3002 \",\"en\":\"Effort summary of users.\"}' WHERE `code` ='effort';
UPDATE `zt_report` SET `desc` = '{\"zh-cn\":\"\\u5217\\u51fa\\u89e3\\u51b3\\u7684Bug\\u603b\\u6570\\uff0c\\u89e3\\u51b3\\u65b9\\u6848\\u7684\\u5206\\u5e03\\uff0c\\u5360\\u7684\\u6bd4\\u4f8b\\uff08\\u8be5\\u7528\\u6237\\u89e3\\u51b3\\u7684Bug\\u7684\\u6570\\u91cf\\u5360\\u6240\\u6709\\u7684\\u89e3\\u51b3\\u7684Bug\\u7684\\u6570\\u91cf)\\u3002\",\"zh-tw\":\"\\u5217\\u51fa\\u89e3\\u51b3\\u7684Bug\\u7e3d\\u6578\\uff0c\\u89e3\\u6c7a\\u65b9\\u6848\\u7684\\u5206\\u4f48\\uff0c\\u5360\\u7684\\u6bd4\\u4f8b\\uff08\\u8a72\\u7528\\u6236\\u89e3\\u51b3\\u7684Bug\\u7684\\u6578\\u91cf\\u5360\\u6240\\u6709\\u7684\\u89e3\\u51b3\\u7684Bug\\u7684\\u6578\\u91cf\\uff09\\u3002\",\"en\":\"percentage:self resolved / all resolved\"}' WHERE `code` = 'bug-resolve';
