const form = document.getElementById('form');

form.addEventListener('submit', function(e){
	e.preventDefault();

	const formdata = new FormData(this);

	fetch('http://localhost/phpApi/api/users/register',{
		method: 'post',
		body: formdata
	}).then(function(response){
		return response.text();
	}).then(function(text){
		const data = JSON.parse(text);
		const { status } = data;
		if(status) document.getElementById('status').innerHTML = status;
		else
			document.getElementById('status').innerHTML = 
		    `${data.name}, Thanks for registering`;
	}).catch(function(error){
		console.error(error);
	});
});
