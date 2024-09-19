/*
Nano Ajax Library
(c) Schien Dong, Antradar Software Inc.

License: www.antradar.com/license.php
Documentation: www.antradar.com/docs-nano-ajax-manual

ver p3.2
*/

function gid(d){return document.getElementById(d);}

function hb(){var now=new Date(); var hb=now.getTime();return hb;}

function ajxb(u,data){
	if (document.wssid) u=u+'&wssid_='+document.wssid;
	var method='POST'; if (!data) method='GET';
	var rq=xmlHTTPRequestObject();
	rq.open('GET',u+'&hb='+hb(),false);
	rq.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	rq.send(data);
	return rq.responseText;	
}

function ajxnb(rq,u,f,data){
	if (document.wssid) u=u+'&wssid_='+document.wssid;	
	rq.onreadystatechange=f;
	var method='POST'; if (!data) method='GET';
	rq.open(method,u+'&hb='+hb(),true);
	rq.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');
	rq.send(data);  	
}

function ajxpgn(c,u,d,e,data,callback,slowtimer,runonce){
	var ct=gid(c);
	if (ct==null) return;
	if (runonce&&ct.reqobj!=null) return;
	var f=function(c){return function(){
		if (rq.readyState==4){
			if (ct.reqobj!=null){
				ct.reqobj=null;
			}
			
			if (ct.abortflag) {ct.abortflag=null;return;}

			var apperror=rq.getResponseHeader('apperror');
			if (apperror!=null&&apperror!=''){
				var errfunc=rq.getResponseHeader('errfunc');
				if (callback&&callback.length>0){
					callback[1](errfunc,decodeURIComponent(apperror),rq);					
				} else {
					if (errfunc!=null&&errfunc!=''&&self[errfunc.toLowerCase()]){
						self[errfunc.toLowerCase()](decodeURIComponent(apperror));
					} else alert(decodeURIComponent(apperror));
				}
				
				return;	
			}

			ct.innerHTML=rq.responseText;
			
			if (d) ct.style.display='block';
			
			if (e){
				var i;
				var scripts=gid(c).getElementsByTagName('script');
				for (i=0;i<scripts.length;i++) eval(scripts[i].innerHTML);
				scripts=null;
			}
			
			if (callback){
				if (callback.length>0) callback[0](rq); else callback(rq);
			}
		}	  
	}}	
	
	var rq=xmlHTTPRequestObject();
	
	if (ct.reqobj!=null) {ct.abortflag=1;ct.reqobj.abort();}
	ct.reqobj=rq;
	ajxnb(rq,u,f(c),data);
}


function ajxjs(f,js){if (f==null) eval(ajxb(js+'?'));}

function ajxcss(f,css){
	if (f==null) {
	  	csl=document.createElement('link');
		csl.setAttribute('rel','stylesheet');
		csl.setAttribute('type','text/css');
		csl.setAttribute('href',css);
		document.getElementsByTagName("head").item(0).appendChild(csl);
	}
}

function xajx(url){
	if (!document.xjs_transport){
		var xjs=document.createElement('div');
		document.body.appendChild(xjs);
		document.xjs_transport=xjs;
	}
	
	var xjs=document.xjs_transport;
	var rq=document.createElement('script');
	rq.setAttribute('src',url);
	xjs.appendChild(rq);
	
	if (xjs.gc) clearTimeout(xjs.gc);
	xjs.gc=setTimeout(function(){
		xjs.innerHTML='';
	},3000);  
}


function xmlHTTPRequestObject() {
	var obj = false;
	var objs = ["Microsoft.XMLHTTP","Msxml2.XMLHTTP","MSXML2.XMLHTTP.3.0","MSXML2.XMLHTTP.4.0"];
	var success = false;
	for (var i=0; !success && i < objs.length; i++) {
		try {
			obj = new ActiveXObject(objs[i]);
			success = true;
		} catch (e) { obj = false; }
	}

	if (!obj) obj = new XMLHttpRequest();
	return obj;
}

function encodeHTML(code){
	if (!self.encodeURIComponent) {alert('Unsupported browser'); return;}
	return encodeURIComponent(code);
}
