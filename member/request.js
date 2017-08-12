var httpRequest = null;
function getXMLHttpRequest() {
	if (window.ActiveXObject) {
		try {
			return new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try {
				return new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e1) {
				return null;
			}
		}
	} else if (window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else {
		return null;
	}
}
function request(method, uri, callback, param){
	httpRequest = getXMLHttpRequest();
	httpRequest.onreadystatechange=callback;
	if(method=="get" || method=="GET"){
		if(param!=null && param!=''){
			uri+="?"+param;
			param = null;
		}
	}
	httpRequest.open(method, uri, true);	
	httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	httpRequest.send(param);
}