<html>
	<head>

		<script src="jquery.min.js"></script>
		<script src="jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="demos.css" type="text/css" />

		<script language="Javascript">

			// Remember to invoke within jQuery(window).load(...)
			// If you don't, Jcrop may not initialize properly
			jQuery(window).load(function(){
			    
				jQuery('#cropbox').Jcrop({
					onChange: showPreview,
					onSelect: showPreview,
					aspectRatio: 115/87
				});
				var id_main = "dlg_changepict";
				$('#cancel').click(function() {
				    jQuery("#" + id_main).remove();
		
				    var imgsm = "<img width=66 height=56 class=\"image\" src=\"" + <?php echo($_GET['glu']);?> + 
				      "/image.php?uid=" + g_uid + "&s=sm&t="+date.getTime() + "\">";
				    var imgla = "<img width=115 height=87 class=\"image\" src=\"http://www.biographia.net/lg_serversep2008/image.php?uid=" + g_uid + "&s=la&t="+date.getTime() + "\">";
				    
				    jQuery("#dlg_pa_img img").replaceWith(imgsm);
				    jQuery("#dlg_eprofile_img img").replaceWith(imgla);	

				  });


				$('#subPic').click(function() {
				    jQuery.post("lg_fixImg.php",{"coords":$('#dummy').html()});
				    jQuery("#" + id_main).remove();
				    var g_uid = <?php echo($_GET['uid']);?>
		
				    var imgsm = "<img width=66 height=56 class=\"image\" src=\"" + <?php echo($_GET['glu']);?> + "/image.php?uid=" + g_uid + "&s=sm&t=" + date.getTime() + "\">";
				    var imgla = "<img width=115 height=87 class=\"image\" src=\"" + <?php echo($_GET['glu']);?> + 
				      "/image.php?uid=" + g_uid + "&s=la&t="+date.getTime() + "\">";
				    
				    jQuery("#dlg_pa_img img").replaceWith(imgsm);
				    jQuery("#dlg_eprofile_img img").replaceWith(imgla);	

				  });

				

			});

			// Our simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showPreview(coords)
			{
				if (parseInt(coords.w) > 0)
				{
				  $('#dummy').html(coords.w + ',' + coords.h + ',' + coords.x + ',' + coords.y);
				  
					var rx = 100 / coords.w;
					var ry = 100 / coords.h;

					jQuery('#preview').css({
					  width: Math.round(rx * ($('.jcrop-holder').css('width'))) + 'px',
						height: Math.round(ry * ($('.jcrop-holder').css('width'))) + 'px',
						marginLeft: '-' + Math.round(rx * coords.x) + 'px',
						marginTop: '-' + Math.round(ry * coords.y) + 'px'
					});
				}
			}

		</script>

	</head>

	<body>
		<div id="dummy" style="visibility:hidden"></div>
	<div id="outer">
	<div class="jcExample">
	<div class="article">

		<h1>Crop your image</h1>

		<!-- This is the image we're attaching Jcrop to -->
		<table>
		<tr>
		<td>
		<img src="http://www.biographia.net/lg_serversep2008/image.php?uid=<?php echo($_GET['uid'] . '&k=' . time());?>&s=la&t=1258631862929" id="cropbox" />
		</td>
		<td>
		<div style="width:115px;height:87px;overflow:hidden;">
			<img src="http://www.biographia.net/lg_serversep2008/image.php?uid=<?php echo($_GET['uid'] . '&k=' . time());?>&s=la&t=1258631862929" id="preview" />
		</div>
		<div><a id=cancel href=#>Cancel</a> <a id=subPic href=#>Submit</a></div>
		</td>
		</tr>
		</table>

		<p>
		</p>




	</div>
	</div>
	</div>
	</body>

</html>
