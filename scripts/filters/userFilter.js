app.filter('userBasicFilter',function(){

	return function(chats,userDataModelDS){
		var k = [];
		angular.forEach(chats,function(chat){

			if(chat.user.id != userDataModelDS.currentUser.id && chat.status=='off')k.push(chat);



		});
		return k;
	};

});


app.filter('userBasicOnlineFilter',function(){

	return function(chats,userDataModelDS){
		var k = [];
		angular.forEach(chats,function(chat){

			if(chat.user.id != userDataModelDS.currentUser.id && chat.status=='on')k.push(chat);


		});


		return k;
	};

})