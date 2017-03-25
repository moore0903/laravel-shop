//edit by ilank QQ:165593397  http://www.sunge.cn
//智能js错误修正
function killerrors() { 
return true; 
} 
window.onerror = killerrors;
if (parent.frames.length > 0) {parent.location.href = location.href;} 

	if(/Android (\d+\.\d+)/.test(navigator.userAgent)){
		var version = parseFloat(RegExp.$1);
		if(version>2.3){
			var phoneScale = parseInt(window.screen.width)/750;
			document.write('<meta name="viewport" content="width=750, minimum-scale = '+ phoneScale +', maximum-scale = '+ phoneScale +', target-densitydpi=device-dpi">');
		}else{
			document.write('<meta name="viewport" content="width=750, target-densitydpi=device-dpi">');
		}
	}else{
		document.write('<meta name="viewport" content="width=750, user-scalable=no, target-densitydpi=device-dpi">');
	}
