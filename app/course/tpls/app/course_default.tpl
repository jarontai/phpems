{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="box itembox" style="margin-bottom:0px;">
				<div class="col-xs-12">
					<ol class="breadcrumb">
						<li><a href="index.php">首页</a></li>
						<li><a href="index.php?course">课程</a></li>
						{x2;tree:$catbread,cb,cbid}
						<li><a href="index.php?course-app-category&catid={x2;v:cb['catid']}">{x2;v:cb['catname']}</a></li>
						{x2;endtree}
						<li class="active">{x2;$cat['catname']}</li>
					</ol>
				</div>
			</div>
		</div>
		<div class="main" id="datacontent">
{x2;endif}
			<div class="col-xs-8" style="padding-left:0px;position:relative;">
				<div class="box itembox" style="height:auto;width:800px;top:0px;z-index:99">
					<h4 class="title">{x2;$content['coursetitle']}</h4>
					{x2;if:$content['course_files'] || $content['course_oggfile'] || $content['course_webmfile']}
					<div style="margin-top:10px;" controls="true" width="100%" height="450" id="movieplatform">
					</div>
					{x2;else}
					<embed src="{x2;$content['course_youtu']}" allowFullScreen="true" quality="high" width="100%" height="450" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>
					{x2;endif}
					<blockquote class="text-info">{x2;realhtml:$content['coursedescribe']}</blockquote>
				</div>
			</div>
			<div class="col-xs-4 pull-right" style="padding-right:0px;">
				<div class="box itembox" style="padding-top:10px;">
					<h4 class="title">{x2;$course['cstitle']}</h4>
					<div>
						{x2;realhtml:$course['csdescribe']}
					</div>
				</div>
				{x2;tree:$contents['data'],content,cid}
				<div class="box" style="padding-top:10px;">
					<div class="col-xs-3">
						<a target="datacontent" href="index.php?course-app-course&page={x2;$page}&csid={x2;$course['csid']}&contentid={x2;v:content['courseid']}" class="ajax">
							<img src="{x2;v:content['coursethumb']}" alt="" width="100%">
						</a>
					</div>
					<div class="col-xs-9">
						<a target="datacontent" href="index.php?course-app-course&page={x2;$page}&csid={x2;$course['csid']}&contentid={x2;v:content['courseid']}" class="ajax">
							<h4 class="title" style="margin-top:0px;">
							{x2;if:$content['courseid'] == v:content['courseid']}
							<span style="color:green;"><em class="glyphicon glyphicon-play-circle"></em></span>
							{x2;endif}
							{x2;v:content['coursetitle']}
							</h4>
						</a>
						<p style="font-size:13px;">{x2;realsubstring:v:content['coursedescribe'],90}</p>
					</div>
				</div>
				{x2;endtree}
				<ul class="pagination pull-right">{x2;$contents['pages']}</ul>
			</div>
			{x2;if:$content['course_files'] || $content['course_oggfile'] || $content['course_webmfile']}
			<script type="text/javascript">
				var flashvars={
				    f:'{x2;if:$content['course_files']}{x2;$content['course_files']}{x2;elseif:$content['course_oggfile']}{x2;elseif:$content['course_oggfile']}{x2;elseif:$content['course_webmfile']}{x2;$content['course_webmfile']}{x2;endif}',
				    c:0
				};
				var video=[{x2;if:$content['course_files']}'{x2;$content['course_files']}->video/mp4',{x2;endif}{x2;if:$content['course_oggfile']}'{x2;$content['course_oggfile']}->video/ogg',{x2;endif}{x2;if:$content['course_webmfile']}'{x2;$content['course_webmfile']}->video/webm'{x2;endif}];
				CKobject.embed('app/core/styles/js/ckplayer/ckplayer.swf','movieplatform','ckplayer_movieplatform','100%','450',false,flashvars,video);
			</script>
			{x2;endif}
{x2;if:!$userhash}
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>
{x2;endif}