{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-2" style="padding-top:10px;margin-bottom:0px;">
				{x2;include:menu}
			</div>
			<div class="col-xs-10" id="datacontent">
{x2;endif}
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a></li>
							<li><a href="index.php?{x2;$_app}-master-contents&page={x2;$page}">内容管理</a></li>
							<li class="active">添加内容</li>
						</ol>
					</div>
				</div>
				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;overflow:visible">
					<h4 class="title" style="padding:10px;">
						添加内容
						<a class="btn btn-primary pull-right" href="index.php?{x2;$_app}-master-contents&catid={x2;$catid}&page={x2;$page}">内容管理</a>
					</h4>
					<form action="index.php?content-master-contents-add" method="post" class="form-horizontal">
						<div class="form-group">
				            <label for="contenttitle" class="control-label col-sm-2">标题：</label>
				            <div class="col-sm-9">
							    <input class="form-control" type="text" id="contenttitle" name="args[contenttitle]" needle="needle" msg="您必须输入标题">
					        </div>
				        </div>
				        <div class="form-group">
				            <label for="contenttitle" class="control-label col-sm-2">发布时间：</label>
				            <div class="col-sm-4">
							    <input class="form-control datetimepicker" data-minview="0" data-date="{x2;date:TIME,'Y-m-d H:i:s'}" data-date-format="yyyy-mm-dd hh:ii:ss" type="text" id="contenttitle" name="args[contentinputtime]" needle="needle" msg="您必须输入发布时间">
					        </div>
				        </div>
				        <!--
				        <div class="col-sm-9">
				            <label for="block" class="control-label col-sm-2">标题颜色：</label>
				            <input type="text" name="args[contenttitle]" needle="needle" msg="您必须输入标题">
				        </div>
				        <div class="col-sm-9">
				            <label for="block" class="control-label col-sm-2">标题加粗：</label>
				            <input type="text" name="args[contenttitle]" needle="needle" msg="您必须输入标题">
				        </div>
				        -->
				        <div class="form-group">
				            <label for="contentmoduleid" class="control-label col-sm-2">模型：</label>
				            <div class="col-sm-3">
							    <select id="contentmoduleid" msg="您必须选择信息模型" refreshjs="on" needle="needle" class="form-control combox" name="args[contentmoduleid]" refUrl="index.php?content-master-module-moduleforms&moduleid={value}" target="contentforms">
					            	<option value="">选择信息模型</option>
					            	{x2;tree:$modules,module,mid}
					            	<option value="{x2;v:module['moduleid']}">{x2;v:module['modulename']}</option>
					            	{x2;endtree}
					            </select>
					        </div>
				        </div>
				        <div class="form-group">
				            <label for="block" class="control-label col-sm-2">缩略图：</label>
				            <div class="col-sm-9">
					            <script type="text/template" id="pe-template-contentthumb">
						    		<div class="qq-uploader-selector" style="width:30%" qq-drop-area-text="可将图片拖拽至此处上传" style="clear:both;">
						            	<div class="qq-upload-button-selector" style="clear:both;">
						                	<ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
								                <li class="text-center">
								                    <div class="thumbnail">
														<img class="qq-thumbnail-selector" alt="点击上传新图片">
														<input type="hidden" class="qq-edit-filename-selector" name="args[contentthumb]" tabindex="0">
													</div>
								                </li>
								            </ul>
								            <ul class="qq-upload-list-selector list-unstyled" aria-live="polite" aria-relevant="additions removals" style="clear:both;">
									            <li class="text-center">
									                <div class="thumbnail">
														<img class="qq-thumbnail-selector" src="app/core/styles/images/noimage.gif" alt="点击上传新图片">
														<input type="hidden" class="qq-edit-filename-selector" name="args[contentthumb]" tabindex="0" value="app/core/styles/images/noimage.gif">
						                			</div>
									            </li>
									        </ul>
						                </div>
						            </div>
						        </script>
						        <div class="fineuploader" attr-type="thumb" attr-template="pe-template-contentthumb"></div>
							</div>
				        </div>
				        <div class="form-group">
				            <label for="contentcatid" class="control-label col-sm-2">分类：</label>
				        	<div class="col-sm-9 form-inline">
							    <select id="contentcatid" msg="您必须选择一个分类" needle="needle" class="autocombox form-control" name="args[contentcatid]" refUrl="index.php?content-master-category-ajax-getchildcategory&catid={value}">
					            	<option value="">选择一级分类</option>
					            	{x2;tree:$parentcat,cat,cid}
					            	<option value="{x2;v:cat['catid']}">{x2;v:cat['catname']}</option>
					            	{x2;endtree}
					            </select>
					        </div>
				        </div>
				        <div class="form-group">
				            <label for="contentlink" class="control-label col-sm-2">站外链接：</label>
				            <div class="col-sm-9">
							    <input class="form-control" type="text" id="contentlink" name="args[contentlink]">
					        </div>
				        </div>
				        <div class="form-group">
				            <label for="contentdescribe" class="control-label col-sm-2">摘要：</label>
				            <div class="col-sm-9">
							    <textarea id="contentdescribe" class="form-control" name="args[contentdescribe]" rows="7" cols="4"></textarea>
					        </div>
				        </div>
				    	<div id="contentforms"></div>
				    	<div class="form-group">
				            <label for="contenttext" class="control-label col-sm-2">内容</label>
				            <div class="col-sm-10">
							    <textarea id="contenttext" rows="7" cols="4" class="ckeditor" name="args[contenttext]"></textarea>
					        </div>
				        </div>
				        <div class="form-group">
				            <label for="contenttemplate" class="control-label col-sm-2">模版：</label>
				            <div class="col-sm-3">
							    <select class="form-control" name="args[contenttemplate]" id="contenttemplate">
					            	{x2;tree:$tpls,tpl,tid}
					            	<option value="{x2;v:tpl}">{x2;v:tpl}</option>
					            	{x2;endtree}
					            </select>
					        </div>
				        </div>
				        {x2;if:$poses}
				        <div class="form-group">
				            <label class="control-label col-sm-2">推荐到：</label>
			            	<div class="col-sm-9">
							    {x2;tree:$poses,pos,pid}
				            	<label class="checkbox-inline">
				            		<input type="checkbox" value="{x2;v:pos['posid']}" name="position[]">{x2;v:pos['posname']}
				            	</label>
				            	{x2;endtree}
					        </div>
				        </div>
				        {x2;endif}
				        <div class="form-group">
				            <label class="control-label col-sm-2"></label>
				            <div class="col-sm-9">
					            <button class="btn btn-primary" type="submit">提交</button>
					            <input type="hidden" name="submit" value="1">
					        </div>
				        </div>
					</form>
				</div>
			</div>
{x2;if:!$userhash}
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>
{x2;endif}