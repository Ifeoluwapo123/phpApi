
const list = document.getElementById('lists');
const desc = document.getElementById('desc');
const page = document.getElementById('page');

window.params = function(){
	var params = {};
	var params_array = window.location.href.split('?')[1].split('&');
	for (var i in params_array) {
		x = params_array[i].split('=');
		params[x[0]] = x[1];
	}
	var user_id = params.id;
	var request = createXmlHttpRequestObject(),
	    res = createXmlHttpRequestObject(),
	    read = createXmlHttpRequestObject();

	read.open('GET',
		`http://localhost/phpApi/api/products/posts`,true);

	read.onload = ()=>{
		var data = JSON.parse(read.response);
		if(read.status >= 200 && read.status<400){
			if(data.phones.length > 0) var phone = 'PHONE: ';
			if(data.systems.length > 0) var system = 'SYSTEM: ';
			for (var i = 0; i < data.phones.length; i++) {
				if(data.phones[i].user_id == user_id){
				    myProducts(phone, data.phones[i]);
				}
			}
			for (var i = 0; i < data.systems.length; i++) {
				if(data.systems[i].user_id == user_id){
				    myProducts(system, data.systems[i]);
				}
			}
		}else{
			console.log('error');
		}
	}

	request.open('GET',
		`http://localhost/phpApi/api/users/users?id=${user_id}`,
	true);

	request.onload = ()=>{
		var data = JSON.parse(request.response);
		if(request.status >= 200 && request.status<400){
			document.getElementById('header').innerHTML = 
			`Welcome ${data[0].name}`;
		}else{
			console.log('error');
		}
	}
	res.open('GET','http://localhost/phpApi/api/products/all',true);

	res.onload = ()=>{
		var data = JSON.parse(res.response);
		if(res.status >= 200 && res.status<400){
			for (var i = 0; i < data.length; i++) {
				products(data[i].products)
			}
		}else{
			console.log('error');
		}
	}
	res.send();
	read.send();
	request.send();
}();

function products(data){
	const li = document.createElement('li');
	li.innerHTML = data;
	list.appendChild(li);
}

function myProducts(val,data){
	const p = document.createElement('p');
	const img = document.createElement('img');
	if(data.image !== '') img.src = `images/${data.image}`;
	p.innerHTML = `${val}${data.name}-${data.model} ${data.version}`;
	desc.appendChild(p);
	page.appendChild(img);
	page.appendChild(desc);
}

function createXmlHttpRequestObject() {
	var xmlHttp;
	try { 
	  	xmlHttp = new XMLHttpRequest();  
	}  
	catch(e) {
		var XmlHttpVersions = new Array('MSXML2.XMLHTTP.6.0',     
	                                  	'MSXML2.XMLHTTP.5.0',                             
	                                  	'MSXML2.XMLHTTP.4.0',                      
	                                  	'MSXML2.XMLHTTP.3.0',        
	                                  	'MSXML2.XMLHTTP',                                    
	                                  	'Microsoft.XMLHTTP');   
	
		for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++){      
		  	try {           
		  		xmlHttp = new ActiveXObject(XmlHttpVersions[i]);      
		    }
		 	catch (e) {}    
		}  
    }  

	if (!xmlHttp)    
		alert("Error creating the XMLHttpRequest object.");  
	else     
		return xmlHttp; 
}

function send(){
	var params = {};
	var params_array = window.location.href.split('?')[1].split('&');
	for (var i in params_array) {
		x = params_array[i].split('=');
		params[x[0]] = x[1];
	}
	var user_id = params.id;
	document.location.href = 'all.html?id='+user_id;
}

