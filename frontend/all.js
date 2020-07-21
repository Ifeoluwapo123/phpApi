var request = createXmlHttpRequestObject();
const desc = document.getElementById('desc');
const page = document.getElementById('page');
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

function back(){
	var params = {};
	var params_array = window.location.href.split('?')[1].split('&');
	for (var i in params_array) {
		x = params_array[i].split('=');
		params[x[0]] = x[1];
	}
	var user_id = params.id;
	document.location.href = 'home.html?id='+user_id;
}

request.open('GET','http://localhost/phpApi/api/products/posts',true);

request.onload = ()=>{
	var data = JSON.parse(request.response);
	if(request.status >= 200 && request.status<400){
		if(data.phones.length > 0) var phone = 'PHONE: ';
		if(data.systems.length > 0) var system = 'SYSTEM: ';
		for (var i = 0; i < data.phones.length; i++) {
			allProducts(phone, data.phones[i]);
		}
		for (var i = 0; i < data.systems.length; i++) {
			allProducts(system, data.systems[i]);
		}
	}else{
		console.log('error');
	}
}
request.send();

function allProducts(val,data){
	const p = document.createElement('p'),
	      p1 = document.createElement('p'),
	      p2 = document.createElement('p'),
	      hr = document.createElement('hr'),
	      img = document.createElement('img'),
	      btn = document.createElement('button');
	p1.innerHTML = data.user_name;
	img.src = `images/${data.image}`;
	img.className = 'thumbnail';
	p.innerHTML = `${val}${data.name}-${data.model} ${data.version}`;
	p2.innerHTML = data.price;
	btn.innerHTML = 'BUY';
	btn.className = "btn btn-warning";
	desc.appendChild(p1);
	desc.appendChild(img);
	desc.appendChild(p);
	desc.appendChild(p2);
	desc.appendChild(btn)
	desc.appendChild(hr);
	desc.className = 'mine';
	page.appendChild(desc);
	
}
