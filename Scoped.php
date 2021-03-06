<?php
namespace akiyatkin\w3c\scoped;
class Scoped {
	public static function fix ($html) 
	{
		$h = explode('</head>', $html);
		if (sizeof($h) > 1) {
			$head = array_shift($h);
			$html = implode('</head>',$h);
		} else {
			$head = '';
		}
		$js = '<script>
			(function(){
				var divs = document.getElementsByClassName("data-scoped-style");
				for (var i = 0, l = divs.length; i<l; i++) {
					var div = divs[i];
					var style = document.createElement("style");
					style.setAttribute("type", "text/css");
					style.setAttribute("scoped", "scoped");
					style.setAttribute("data-w3c-scoped", "true");
					if (style.styleSheet) {   // IE
					    style.styleSheet.cssText = def;
					} else {                // the world
					    var tt = document.createTextNode(div.innerHTML);
					    style.appendChild(tt);
					}
					div.parentElement.insertBefore(style,div);
					div.parentElement.removeChild(div);
				}
			})();
		</script>';
		$html = str_ireplace('<style scoped>', '<canvas height="0" width="0" class="data-scoped-style">', $html);
		$html = str_ireplace('</style>', '</canvas>'.$js, $html);
		
		return $head.$html;
	}
}


