app.service("messageService",function($http){


	this.getNewMessages = function(username)
	{
		var vData = {
			'receiverUsername':username
		};
		return $http({
			'method':'POST',
			'url':'ajax/GetNewMessages.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});
	};



	this.getConversation = function(user1,user2)
	{
		var vData = {
			'receiverUsername':user1,
			'senderUsername':user2
		};
		return $http({
			'method':'POST',
			'url':'ajax/GetOldMessages.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});
	};

	this.seenMessages = function(messageCodes)
	{
		var vData = {
			'codes':messageCodes,
		};
		return $http({
			'method':'POST',
			'url':'ajax/SeenMessage.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});

	};


	this.sendMessage = function(message,senderUsername,receiverUsername)
	{
		var vData = {
			'message':message,
			'senderUsername':senderUsername,
			'receiverUsername':receiverUsername
		};
		return $http({
			'method':'POST',
			'url':'ajax/SendMessage.php',
			'data':JSON.stringify(vData),
			'dataType':'json'
		});

	};

	

});