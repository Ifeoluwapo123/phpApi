const login = document.getElementById('login');
login.addEventListener('submit', function(e){
	e.preventDefault();

	const formdata = new FormData(this);

	fetch('http://localhost/phpApi/api/users/login',{
		method: 'post',
		body: formdata
	}).then(function(response){
		return response.text();
	}).then(function(text){
		const data = JSON.parse(text);
		const { loginStatus } = data;
		if(loginStatus) 
			document.getElementById('status').innerHTML = loginStatus;
		else
			document.location.href = `home.html?id=${data.user_id}`;
	}).catch(function(error){
		console.log(error);
	});
});