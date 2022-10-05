<?php
/*
*	设置文件
*
*/
!defined('EMLOG_ROOT') && exit('DYEXIT');

function plugin_setting_view() {	//设置页面加载配置文件 默认调用
	include(BAIDU_XZ_ROOT.'baidu_xz_config.php');
}

function plugin_setting() {
	$data= <<< DATA
<?php
!defined('EMLOG_ROOT') && exit('DYEXIT');
\$config = [
	'X_Appid'=>'{$_POST['xappid']}',
	'X_Token'=>'{$_POST['xtoken']}',
	'X_Type'=>'{$_POST['xtype']}', 
	'X_DisplayNum'=>'{$_POST['xdisplaynum']}'
];
?>
DATA;
	@file_put_contents(BAIDU_XZ_ROOT.'baidu_xz_config.php', $data);
}


/*
*	创建数据表如果不存在
*/

require_once(BAIDU_XZ_ROOT.'baidu_xz_config.php');
?>

<!-- 引入外部资源 -->
<link href="https://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"> 
<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>

<div class="containertitle"><h3>百度熊掌号一键集成+推送 - 设置 <?php if (isset($_GET['setting'])) {echo '<span class="actived">插件设置完成</span>';}?></h3></div>

<div class="panel panel-default">
  <div class="panel-heading">配置信息</div>
  <div class="panel-body">
<form action="plugin.php?plugin=baidu_xz&action=setting" method="post">
    <div class="setting">
        <div class="row">
            <div class="col-md-3 col-xs-2">
                推送类型：
            </div>
            <div class="col-md-2 col-xs-2">
                <label class="radio-inline">
                  <input type="radio" name="xtype" value="1" <?php if ($config['X_Type'] == 1) { echo 'checked'; } ?>> 天级收录
                </label>
            </div>
            <div class="col-md-2 col-xs-2">
                <label class="radio-inline">
                  <input type="radio" name="xtype" value="0" <?php if ($config['X_Type'] == 0) { echo 'checked'; } ?>> 周级收录
                </label>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5 col-xs-5">
                <div class="input-group">
                    <span class="input-group-addon">APPID</span>
                    <input type="text" class="form-control" name="xappid" placeholder="请输入Appid值" required value="<?php echo $config['X_Appid']; ?>" maxlength="16">
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
             <div class="col-md-5 col-xs-5">
                <div class="input-group">
                    <span class="input-group-addon">Token</span>
                    <input type="text" class="form-control" name="xtoken" placeholder="请输入Token值" required value="<?php echo $config['X_Token'];?>" maxlength="16">
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
             <div class="col-md-5 col-xs-5">
                <div class="input-group">
                    <span class="input-group-addon">展示条数</span>
                    <input type="number" class="form-control" name="xdisplaynum" placeholder="请输入数字" required value="<?php echo $config['X_DisplayNum'];?>">
                </div>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-danger">保存设置</button>
    </div>
</form>
</div></div>
<br/>

<div class="panel panel-default">
  <div class="panel-heading">使用说明</div>
  <div class="panel-body">
  	<div class="alert alert-success" role="alert">
  		为了方便广大站长快速接入熊掌号，同时为了快速支持那些不支持百度熊掌号的模版，小东特开发此款插件。如果您在使用过程中有任何的疑问或好的建议都可以直接在<a href="https://blog.dyboy.cn/develop/115.html" target="_blank">《Emlog百度熊掌号插件》</a>处留言评论
  	</div>
    - 在模版文件夹下<code>header.php</code>文件 <code>&lt;/head&gt;</code>标签前一行</code>添加如下代码：<br/><code>&lt;? php doAction('baidu_xz_echo',$logid, $log_title, $log_content, $date); ?&gt;</code><br/><br/>
    <div class="alert alert-success" role="alert">
  		少量文章（每日最多10条）推荐选择天级收录，其余的建议选择周级收录！
  	</div>
    - 天级收录： 每日推送有限度<br/>
    - 周级收录： 每日推送500万条<br/>
    - 展示条数：将在下面表格展示推送过的历史记录<br/>
    - <code>Appid</code>和<code>Token</code>：参看如下截图(网址:<a target="_blank" href="https://ziyuan.baidu.com/ydzq/includeday">https://ziyuan.baidu.com/ydzq/includeday</a>)<br/>
    <a href="https://ww2.sinaimg.cn/large/005PdFYUly1g0sctubrfzj312m0nzq6n.jpg" target="_blank" title="点击查看大图"><img src="https://ww2.sinaimg.cn/large/005PdFYUly1g0sctubrfzj312m0nzq6n.jpg" width="100%"></a><br/>
    - 更新地址：<a href="https://blog.dyboy.cn/develop/115.html" target="_blank">百度熊掌号插件最新版</a><br/>
  </div>
</div>

<!-- 本插件作者：DYBOY，免费发布到EMLOG社区，任何篡改版权的行为都是对作者和自己的不尊重 -->
<!-- Copyright DYBOY 2019 -->
<div class="panel panel-default">
  <div class="panel-heading">提交记录(显示<?php echo $config['X_DisplayNum'];?>条)</div>
  <div class="panel-body">
  	<table class="table table-hover">
      <thead>
        <tr>
          <th>文章链接</th>
          <th>提交时间</th>
          <th>状态</th>
          <th>提交类型</th>
        </tr>
      </thead>
      <tbody>
      	<?php
      		$DB = MySqlii::getInstance();
      		$sqlShow = 'SELECT * FROM emlog_xiongzhang ORDER BY id DESC limit 0,'.$config['X_DisplayNum'];
      		createTable($DB);
      		$result = $DB->query($sqlShow);
      		while($row = mysqli_fetch_assoc($result)){
      			echo '<tr> <th>'.$row['link'].'	</th> <td>'.$row['uptime'].'</td> <td>'.$row['status'].'</td> <td>'.$row['type'].'</td> </tr>';
      		}
      	?>
      </tbody>
    </table>
  </div>
</div>
