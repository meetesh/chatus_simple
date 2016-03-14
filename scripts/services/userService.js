app.service("userService",function($http){

	this.getCurrentUser = function()
	{
		return $http.get('ajax/GetCurrentUser.php');
	};

	this.signup = function(user)
	{
		return $http({
			'method':'POST',
			'url':'ajax/Signup.php',
			'data':JSON.stringify(user),
			'dataType':'json'

		});
	};

	this.login = function(username,password)
	{
		var vData = {
			'username':username,
			'password':password
		};
		return $http({
			'method':'POST',
			'url':'ajax/Login.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});
	};

	this.getOnlineUsers = function()
	{
		return $http.get('ajax/GetOnlineUsers.php');		
	};

	this.logout = function()
	{
		return $http.get('ajax/Logout.php');		
	};

	this.updateAliveStatus = function(username)
	{
		var vData = {
			'username':username
		};
		return $http({
			'method':'POST',
			'url':'ajax/UpdateAliveStatus.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});
	};

	this.isUsernameAvailable = function(username)
	{
		var vData = {
			'username':username
		};
		return $http({
			'method':'POST',
			'url':'ajax/IsUsernameAvailable.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});
	};


	this.updateUser = function(name,currentUsername,username,dateOfBirth)
	{
		var vData = {
			'name':name,
			'currentUsername':currentUsername,
			'username':username,
			'dateOfBirth':dateOfBirth
		};
		return $http({
			'method':'POST',
			'url':'ajax/Login.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});
	};
	

});