app.controller('userController',function(userService,$scope){


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
		updatingAliveStatus:false
	};


	$scope.userDataModelDS = {

		currentUser:null,
		onlineUsers:[]
	}


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


		// body...
	}

	$scope.init = function()
	{


		userService.getCurrentUser()
					.then(function(res){

						if(res.data.success == true)
						{
							$scope.userViewModelDS.mode = 'in';
							$scope.userDataModelDS.currentUser = res.data.user;
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

					clearFields();


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
 
		},function(){

	  		$scope.userViewModelDS.gettingOnlineUsers = false;
	  		console.log("can not connect");

		});

		if($scope.userViewModelDS.mode=='in') setTimeout(populateOnlineUsers,5000);


	};


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

		if($scope.userViewModelDS.mode=='in') setTimeout(updateAliveStatus,5000);
	};

	$scope.init();

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



});