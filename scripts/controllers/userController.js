app.controller('userController',function(userService,messageService,$scope,$timeout){


	$scope.userViewModelDS = {

		mode:"",
		loginForm:{
			username:'',
			password:'',
			message:''
		},
		signupForm:{
			name:'',
			username:'',
			password:'',
			cPassword:'',
			dateOfBirth:'',
			message:''

		},
		gettingOnlineUsers:false,
		gettingAllUsers:false,
		updatingAliveStatus:false,
		gettingNewMessages:false

	};


	$scope.messageDataModelDS = {

		messages:[],
		selectedMessages:[],
		message:""

	};




	$scope.userDataModelDS = {

		currentUser:null,
		onlineUsers:[],
		users:[],
		selectedChat:null

	}

	$scope.chatDataModelDS = [
		/*
		structure will be like this.
		var chats = [{
			user:{},
			messages:[{}],
			status:'on/off',
			newMessages:[]
			newMessagesCount:0
		}]
		*/
	];


	$scope.login = function(){

		$scope.userViewModelDS.loginForm.message = "Loggin in";

		userService.login($scope.userViewModelDS.loginForm.username,$scope.userViewModelDS.loginForm.password)
		.then(function(res){
			if(res.data.success)
			{
        		$scope.userViewModelDS.loginForm.message = "success";
				$scope.init();
			}else
			{
				$scope.userViewModelDS.loginForm.message = res.data.message;
			}
		},function(){
			alert("Can not connect");
		})
	};

	function clearFields () {



		$scope.userViewModelDS.loginForm.message = '';
		$scope.userViewModelDS.loginForm.username = '';
		$scope.userViewModelDS.loginForm.password= '';
		$scope.userViewModelDS.signupForm.username = '';
		$scope.userViewModelDS.signupForm.name = '';
		$scope.userViewModelDS.signupForm.password = '';
		$scope.userViewModelDS.signupForm.cPassword= '';
		$scope.userViewModelDS.signupForm.dateOfBirth = '';
		$scope.userViewModelDS.signupForm.message = '';
		$scope.userDataModelDS.currentUser = null;
		$scope.userDataModelDS.onlineUsers =[];
		$scope.userDataModelDS.users =[];
		$scope.userDataModelDS.selectedChat = null;
		$scope.messageDataModelDS.messages = [];
		$scope.chatDataModelDS = [];



		// body...
	}

	$scope.init = function()
	{


        clearFields();
		userService.getCurrentUser()
					.then(function(res){

						if(res.data.success == true)
						{
							$scope.userViewModelDS.mode = 'in';
							$scope.userDataModelDS.currentUser = res.data.user;
							populateAllUsers();
							populateOnlineUsers();
							updateAliveStatus();

						}else
						{
							$scope.userViewModelDS.mode = 'out';
						}


					},function(){

						alert("Can not connect");
					});

					//more for later



	};

	function populateOnlineUsers () {


		$scope.userViewModelDS.gettingOnlineUsers = true;

		userService.getOnlineUsers().then(function(res){

			if(res.data.success)
			{

	     		$scope.userDataModelDS.onlineUsers = res.data.users;
			}else
			{
		    	$scope.userDataModelDS.onlineUsers = [];
			}

     		$scope.userViewModelDS.gettingOnlineUsers = false;
     		applyFilter($scope.userDataModelDS.onlineUsers,$scope.userDataModelDS.users);
 
		},function(){

	  		$scope.userViewModelDS.gettingOnlineUsers = false;
	  		console.log("can not connect");

		});

		if($scope.userViewModelDS.mode=='in') 
			{
				$timeout(populateOnlineUsers,10000);
			}


	};


function populateAllUsers () {


		$scope.userViewModelDS.gettingAllUsers = true;

		userService.getAllUsers().then(function(res){

			if(res.data.success)
			{

	     		$scope.userDataModelDS.users = res.data.users;
    
			}else
			{
		    	$scope.userDataModelDS.users = [];
			}

  		$scope.userViewModelDS.gettingAllUsers = false;
		applyFilter($scope.userDataModelDS.onlineUsers,$scope.userDataModelDS.users);

 
		},function(){

	  		$scope.userViewModelDS.gettingAllUsers = false;
	  		console.log("can not connect");

		});

	};





	function applyFilter(onlineUsers,users)
	{
		if(!onlineUsers.length || !users.length) return;
		var del = null;
		if($scope.chatDataModelDS.length==0)
		{
			//create DS
			$scope.chatDataModelDS = [];
			for(var x=0;x<users.length;x++)
			{
				del= {
					"user":users[x],
					"messages":[],
					"status":"off",
					"newMessages":[],
					"newMessagesCount":0
				}
				for (var i =0;i<onlineUsers.length; i++) 
				{
					if(users[x].id==onlineUsers[i].id)
					{
						del.status = "on";
						break;
					}
				}
				$scope.chatDataModelDS.push(del);
			}
			$scope.getNewMessages();
		}
		else
		{
			//modify esisting ds
			var chat = null;
			for(var x = 0;x<$scope.chatDataModelDS.length;x++)
			{
				chat = $scope.chatDataModelDS[x];
				chat.status = 'off';
				for (var i =0;i<onlineUsers.length; i++) 
				{
					if(chat.user.id==onlineUsers[i].id)
					{
						chat.status = "on";
						break;
					}
				}
			}

		}

	}


	function updateAliveStatus () {

		$scope.userViewModelDS.updatingAliveStatus = true;

		userService.updateAliveStatus($scope.userDataModelDS.currentUser.username).then(function(res){

			if(!res.data.success)
			{
				$scope.init();    
			}

   		$scope.userViewModelDS.updatingAliveStatus = false;
 
		},function(){

	  		$scope.userViewModelDS.updatingAliveStatus = false;
	  		console.log("can not connect");

		});

		if($scope.userViewModelDS.mode=='in') $timeout(updateAliveStatus,5000);
	};


	$scope.logout = function(){

		userService.logout().then(function(res){
			if(res.data.success)
			{
				$scope.init();
			}
		},function() {
			alert('can not connect')
		})
	};

	//sign up

	$scope.signup = function(){


		userService.signup($scope.userViewModelDS.signupForm).then(function(res){



			if(res.data.success)
			{
				$scope.init();
			}else
			{
				$scope.userViewModelDS.signupForm.message = res.data.message;
			}

		},function(){
			alert("can not connect.")
		})

	};


	function getChat(user)
	{
		for(var i=0;i<$scope.chatDataModelDS.length;i++)
		{
			if($scope.chatDataModelDS[i].user.id==user.id)
			{
				return $scope.chatDataModelDS[i];
			}
		}

		return null;

	}


	function getChatByUserId(userId)
	{
		for(var i=0;i<$scope.chatDataModelDS.length;i++)
		{
			if($scope.chatDataModelDS[i].user.id==userId)
			{
				return $scope.chatDataModelDS[i];
			}
		}

		return null;

	}


	$scope.selectUser = function(chat)
	{
		if(chat == null) return;
		$scope.userDataModelDS.selectedChat = chat;
		if($scope.userDataModelDS.selectedChat.messages.length == 0)
		{
			getConversation(chat.user);
		}else
		{
			if(chat.newMessages && chat.newMessages.length>0)
			{
				var k = [];
				for(var i = 0;i<chat.newMessages.length;i++)
				{
					k.push(chat.newMessages[i]);
				}
				for(var i = 0;i<chat.messages.length;i++)
				{
					k.push(chat.messages[i]);
				}
				
				chat.messages = k;
				triggerSeenMessages(chat.newMessages);
			}
		}

	};


	function addMessages(user,messages) 
	{
		//do something different
		getChat(user).messages = messages;
	}


	function getConversation(withUser)
	{
		messageService.getConversation($scope.userDataModelDS.currentUser.username,withUser.username)
			.then(function(res){
				if(res.data.success)
				{
					addMessages(withUser,res.data.messages);
					$scope.userDataModelDS.selectedChat.messages = res.data.messages;
					triggerSeenMessages(res.data.messages);

				}else
				{
					addMessages(withUser,[]);
				}


			},function(){

				alert("can not connect.")
			});

	}

	function triggerSeenMessages(messages)
	{
		var k = [];
		var tmp = null;
		var tmpSenderUserId = 0;
		angular.forEach(messages,function(message){

			if(message.senderUserId != $scope.userDataModelDS.currentUser.id && message.seen != 1)
			{
				tmp = {
					"code":message.code
				};
				k.push(tmp);
				tmpSenderUserId = message.senderUserId;
			}
		});
		messageService.seenMessages(k).then(function(res){

			if(tmpSenderUserId)
			{
				var chat = getChatByUserId(tmpSenderUserId);
				chat.newMessagesCount = 0;
				chat.newMessages = [];
			}


		},function(){

			alert("can not connect");

		})
	}

	$scope.getMessageCSSClass = function(message){



		if(message.senderUserId==$scope.userDataModelDS.currentUser.id)
		{
			return 'receiver-message'
		}

		return 'sender-message'

	};

	$scope.getSelectedUserCSSClass = function(user){

		if(!$scope.userDataModelDS.selectedChat) return '';

		if(user.id == $scope.userDataModelDS.selectedChat.user.id) return 'user-selected'
			else
				return '';

	};





	$scope.getNewMessages = function()
	{
		//to be wirtten
		$scope.userViewModelDS.gettingNewMessages = true;
		messageService.getNewMessages($scope.userDataModelDS.currentUser.username)
			.then(function(res){
				

				if(res.data.success)
				{
					addNewMessages(res.data.messages);
				}
				$scope.userViewModelDS.gettingNewMessages = false;
				if($scope.userViewModelDS.mode=='in') $timeout($scope.getNewMessages, 2000);

			},function(){

				alert("can not connect.")
			});


	}

	function addNewMessages(messages)
	{
		var a = true;
		angular.forEach(messages,function(msg){

			var chat = getChatByUserId(msg.senderUserId);
			a = false;
			for(var i=0;i<chat.newMessages.length;i++)
			{
				if(chat.newMessages[i].code==msg.code)
				{
					a = true;
					break;
				}
			}
			if(!a) 
			{
				chat.newMessagesCount++;
			    chat.newMessages.splice(0,0,msg);
			}
		});
	}


	$scope.sendMessage = function()
	{
		if($scope.messageDataModelDS.message.trim().length == 0) return;
		messageService.sendMessage($scope.messageDataModelDS.message.trim(),$scope.userDataModelDS.currentUser.username,$scope.userDataModelDS.selectedChat.user.username)
			.then(function(res){

				if(res.data.success)
				{
					//very bad change it
					getConversation($scope.userDataModelDS.selectedChat.user);
					$scope.messageDataModelDS.message = "";
				}else
				{
					alert('some error '+res.data.message);
				}

			},
			function(){

				alert('can not connect.')


			});


	};


	$scope.init();


});