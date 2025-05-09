<style>
	.navbar-nav>.user-menu>.dropdown-menu>li.user-header {
		padding: 10px;
		text-align: center;
		height:max-content!important;
	}
</style>
<header class="main-header">
	<a href="{{url('/')}}" class="logo">
		<span class="logo-mini">
			<img src="{{asset('/img/siplogooke.webp')}}" alt="icon-mini" width="30px" height="40px">
		</span>
		<span class="logo-lg">
			<b>SIMS</b>APP
		</span>
	</a>

	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">
				Toggle navigation
			</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown messages-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" >	
						<!-- <i id="bell-id" class="fa fa-bell-o"></i> -->
						<i class="fa fa-bell-slash"></i>
						<span class="label label-warning" id="notificationCount"></span>					
					</a>
				<!-- 	<ul class="dropdown-menu" id="">
						<li class="header">New Notifications:</li>
						<li>
							<ul class="menu" id="notificationContent">
							</ul>
						</li>
						<li class="footer">
							<a href="#" onclick="view_all('{{Auth::User()->email}}')">View all</a>
						</li>
					</ul> -->
				</li>
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						@if(Auth::User()->avatar != NULL)
							<img src="{{Auth::User()->avatar}}" class="user-image" alt="small-user-img">
						@else
							@if(Auth::User()->gambar == NULL || Auth::User()->gambar == "-")
								<img src="{{asset('image/default-user.png')}}" class="user-image" alt="small-user-img">
							@else
								<img src="{{asset('image') . '/' . Auth::User()->gambar}}" class="user-image" alt="small-user-img">
							@endif
						@endif
						<span class="hidden-xs">{{ Auth::User()->name }}</span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							@if(Auth::User()->avatar != NULL)
								<img src="{{Auth::User()->avatar}}" class="img-circle" alt="big-user-img">
							@else
								@if(Auth::User()->gambar == NULL || Auth::User()->gambar == "-")
									<img src="{{asset('image/default-user.png')}}" class="img-circle" alt="big-user-img">
								@else
									<img src="{{asset('image') . '/' . Auth::User()->gambar}}" class="img-circle" alt="big-user-img">
								@endif
							@endif
							<p>
								{{ Auth::User()->name }} - {{$initView['userRole']->name}}
								<small>
									@if(Auth::User()->id_company == '1') 
										Sinergy Informasi Pratama
									@else
										Multi Solusindo Perkasa
									@endif
								</small>
								<small>Member since {{ Auth::User()->date_of_entry }}</small>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="{{url('profile_user')}}" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
									<input type="hidden" name="nik" value="{{Auth::User()->nik}}">
								</form>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>
@section('scriptNotificationHeader')
<!-- From Header Blade for notification -->
<!-- Firebase-app 8.6.3-->
<!-- <script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script> -->
<!-- Firebase-database 8.6.3-->
<!-- <script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-database.js"></script> -->
<!-- MomentJS -->
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->

<script type="text/javascript">
	//Disabled push notif
	// var firebaseConfig = {
	//     apiKey: "{{env('FIREBASE_APIKEY')}}",
	//     authDomain: "{{env('FIREBASE_AUTHDOMAIN')}}",
	//     projectId: "{{env('FIREBASE_PROJECTID')}}",
	//     storageBucket: "{{env('FIREBASE_STORAGEBUCKET')}}",
	//     messagingSenderId: "{{env('FIREBASE_MESSAGINGSENDERID')}}",
	//     appId: "{{env('FIREBASE_APPID')}}",
	//     measurementId: "{{env('FIREBASE_MEASUREMENTID')}}"
	// };
	
 //  	firebase.initializeApp(firebaseConfig);

 //  	firebase.database().ref('notif/web-notif').once('value', function(snapshot) {
 //  	 	snapshot_dump = snapshot.val()

 //  	 	var append = ""
 //  	 	var count = 0

 //  	 	var keys = Object.keys(snapshot_dump)
 //  	 	keys = keys.reverse()

 //  	 	for (var i = 0; i < keys.length; i++) {
 //  	 		if (snapshot_dump[keys[i]].status == "unread") {
 //  	 			if (!snapshot_dump[keys[i]].module == false) {
 					
 // 					if (snapshot_dump[keys[i]].to == "{{Auth::User()->email}}") {
 // 						if (snapshot_dump[keys[i]].result == 'DRAFT') {
 // 							URL = "{{url('admin/draftPR')}}"
 // 							if ("{{App\RoleUser::where("user_id",Auth::User()->nik)->join("roles","roles.id","=","role_user.role_id")->where('roles.name',"BCD Procurement")->exists()}}" || "{{App\RoleUser::where("user_id",Auth::User()->nik)->join("roles","roles.id","=","role_user.role_id")->where('roles.name',"BCD Manager")->exists()}}") {
 // 								URL = "{{url('admin/draftPR')}}?status=draft&no_pr="+snapshot_dump[keys[i]].id_pr
 // 							}
	// 			  			append = append + makeNotificationHolder(snapshot_dump[keys[i]],keys[i],"unread",URL)
	// 			  		}else{
	// 			  			append = append + makeNotificationHolder(snapshot_dump[keys[i]],keys[i],"unread","{{url('admin/detail/draftPR')}}/"+snapshot_dump[keys[i]].id_pr)
	// 			  		}
	//  				}
 //  	 			}else{
 //  	 				if (snapshot_dump[keys[i]].to == "{{Auth::User()->email}}") {

	// 		  	 		if ("{{Auth::User()->id_division}}" == 'FINANCE') {
	// 		  	 			append = append + makeNotificationHolder(snapshot_dump[keys[i]],keys[i],"unread","{{url('salesproject')}}#submitIdProject/"+snapshot_dump[keys[i]].id_pid)

	// 		  	 		}else if ("{{Auth::User()->id_division}}" == 'TECHNICAL PRESALES') {
	// 		  	 			if (snapshot_dump[keys[i]].result == 'INITIAL') {
	// 			  	 			append = append + makeNotificationHolder(snapshot_dump[keys[i]],keys[i],"unread",snapshot_dump[keys[i]].lead_id)
	// 		  	 			}else{
	// 						    localStorage.setItem("status","read")
	// 			  	 			append = append + makeNotificationHolder(snapshot_dump[keys[i]],keys[i],"unread","{{url('project/detailSales')}}/"+snapshot_dump[keys[i]].lead_id)
	// 		  	 			}

	// 		  	 		}else{
	// 			  	 		append = append + makeNotificationHolder(snapshot_dump[keys[i]],keys[i],"unread","{{url('project/detailSales')}}/"+snapshot_dump[keys[i]].lead_id)
	// 		  	 		}
	// 		  	 	}
 //  	 			}
	//   	 	}
 //  	 		count++
 //  	 	}

 //  	 	$("#notificationContent").append(append)

 //  	})

 //  	firebase.database().ref('notif/web-notif').on('value', function(snapshot) {
 //        snapshot_dump = snapshot.val()
 //        var append = ""
 //        var count = 0

 //        var keys = Object.keys(snapshot_dump)
 //  	 	keys = keys.reverse()

 //  	 	for (var i = 0; i < keys.length; i++) {

 //  	 		if (snapshot_dump[keys[i]].status == "unread") {

 //  	 			if (snapshot_dump[keys[i]].to == "{{Auth::User()->email}}") {
 //  	 				count++

	// 	  	 	}

	// 	  	} 
 //        }

 //        if(count != 0){ 	
 //        	count = count
 //        	$("#bell-id").removeClass('fa fa-bell-o').addClass('fa fa-bell')
	// 		$("#notificationCount").text(count)

 //        } else {   
 //        	$("#bell-id").removeClass('fa fa-bell').addClass('fa fa-bell-o')
 //        }		
 //    });

 //    var start = true;

 //    firebase.database().ref('notif/web-notif').limitToLast(1).on('child_added', function(snapshot) {
 //        if(!start){
 //        	if (!snapshot.val().module == false) {
 //        		if (snapshot.val().to == "{{Auth::User()->email}}") {
 //        			var url = "{{url('admin/draftPR')}}"
	//         		if (snapshot.val().result == 'DRAFT') {
	//         			if (snapshot.val().to == "{{Auth::User()->email}}") {
	//         				if ("{{App\RoleUser::where("user_id",Auth::User()->nik)->join("roles","roles.id","=","role_user.role_id")->where('roles.name',"BCD Procurement")->exists()}}" || "{{App\RoleUser::where("user_id",Auth::User()->nik)->join("roles","roles.id","=","role_user.role_id")->where('roles.name',"BCD Manager")->exists()}}") {
	//         					url = "{{url('admin/draftPR')}}?status=draft&no_pr="+snapshot.val().id_pr
 //    							pushNotify(snapshot.val().title,url)
	//         				}else{
 //    							pushNotify(snapshot.val().title,url)
	//         				}
	//         			}
	        			
	// 					$("#notificationContent").prepend(makeNotificationHolder(snapshot.val(),snapshot.key,"unread",url))
	//         		}else{
	//         			if (snapshot.val().to == "{{Auth::User()->email}}") {
	//     					pushNotify(snapshot.val().title,"{{url('admin/detail/draftPR')}}/"+snapshot.val().id_pr);
	//     				}
	        			

	//         			$("#notificationContent").prepend(makeNotificationHolder(snapshot.val(),snapshot.key,"unread","{{url('admin/detail/draftPR')}}/"+snapshot.val().id_pr))
	//         		}
 //        		}
 //        	}else{
 //        		if (snapshot.val().to == "{{Auth::User()->email}}") {
	// 	  	 		if ("{{Auth::User()->id_division}}" == 'FINANCE') {
	// 	  	 			$("#notificationContent").prepend(makeNotificationHolder(snapshot.val(),snapshot.key,"unread","{{url('salesproject')}}#submitIdProject/"+snapshot.val().id_pid))

	// 	  	 		}else if ("{{Auth::User()->id_division}}" == 'TECHNICAL PRESALES') {
	// 	  	 			if (snapshot.val().result == 'INITIAL') {
	//             			$("#notificationContent").prepend(makeNotificationHolder(snapshot.val(),snapshot.key,"unread",snapshot.val().lead_id)) 
	// 	  	 			}else{
	// 					   localStorage.setItem("status","read")
					
	// 		  	 			$("#notificationContent").prepend(makeNotificationHolder(snapshot.val(),snapshot.key,"unread","{{url('project/detailSales')}}/"+snapshot.val().lead_id))

	// 	  	 			}
	// 	  	 		}else{
	// 		  	 		$("#notificationContent").prepend(makeNotificationHolder(snapshot.val(),snapshot.key,"unread","{{url('project/detailSales')}}/"+snapshot.val().lead_id))

	// 	  	 		}
	// 	  	 	}
 //        	}
 //        } else {
 //            start = false
 //        }
 //    })

 //    function timedRefresh(timeoutPeriod) {
	// 	setTimeout("location.reload(true);",timeoutPeriod);
	// }

 //  	function makeNotificationHolder(data,index,status,url){
 //        var append = ""
 //        if (data.date_time == null) {
 //        	date_time = ""
 //        }else{
 //        	date_time = moment(data.date_time,"X").fromNow()
 //        }

 //        if (!data.opty_name == false) {
 //        	if (data.opty_name.length > 30) {
	//         	opty_name = data.opty_name.substring(0, 25) + '...'
	//         }else{
	//         	opty_name = data.opty_name
	//         }
 //        }else{
 //        	opty_name = data.title
 //        }
        
 //        if(status == "unread"){
	// 		append = append + ' <li style="cursor:pointer">'
	// 		append = append + '	<a class="pointer" onclick="readNotification('+ "'" + index +  "'" + ',' + "'" + url + "'" + ')">'
	// 		append = append + '	<div class="pull-left">'
	// 		append = append + '	<img src="{{asset("img/logopng.png")}}" class="img-circle" alt="User Image">'
	// 		append = append + '	</div>'
	// 		append = append + '	<h6>'
	// 		append = append + '<small class="label" style="background-color:'+ data.heximal +'">'+ data.result + '</small>'
	// 		append = append + '	<small class="pull-right"><i class="fa fa-clock-o"></i> '+ date_time + '</small>'
	// 		append = append + '	</h6>'
	// 		append = append + '	<p>'+ opty_name +'</p>'
	// 		append = append + '	</a>'
	// 		append = append + '	</li>'

	// 		// append = append + '<li>'
	// 		// append = append + '<a class="pointer" onclick="readNotification('+ "'" + index +  "'" + ',' + "'" + url + "'" + ')"><div class="pull-left"> <small class="label pull-right" style="background-color:'+ data.heximal +'">'+ data.result + '</small> </div>'
	// 		// append = append + ' <h6>' + opty_name + '</h6>' + '<p><small><i class="fa fa-clock-o"></i> '+ date_time +'</small></p>'
	// 		// append = append + '</a>'
	// 		// append = append + '</li>'
 //        } 

 //        return append
 //    }

 //    function readNotification(index,url){
 
 //        firebase.database().ref('notif/web-notif/' + index).once('value').then(function(snapshot) {
 //            var data = snapshot.val()
 //            if (data.id_pid == null || data.company == null || data.date_time == null) {
 //            	id_pid = ""
 //            	company = ""
 //            	date_time = ""
 //            }else{
 //            	id_pid = data.id_pid 
 //            	company = data.company
 //            	date_time = data.date_time
 //            }

 //            if (!data.module == false) {
 //            	firebase.database().ref('notif/web-notif/' + index).set({
	//                 to: data.to,
	//                 id_pr: data.id_pr,
	//                 title: data.title,
	//                 heximal: data.heximal,
	//                 status: "read",
	//                 result : data.result,
	//                 showed : "true",
	//                 date_time : data.date_time,
	//                 module:"draft"
	//             });
 //            }else{
 //            	firebase.database().ref('notif/web-notif/' + index).set({
	//             	company:company,
	//                 to: data.to,
	//                 lead_id: data.lead_id,
	//                 opty_name: data.opty_name,
	//                 heximal: data.heximal,
	//                 status: "read",
	//                 result : data.result,
	//                 showed : "true",
	//                 id_pid : id_pid,
	//                 date_time : data.date_time
	//             });
 //            }

            

 //            if ("{{Auth::User()->id_division}}" == 'TECHNICAL PRESALES') {
 //            	if (snapshot.val().result == 'INITIAL') {
 //            		location.reload(true);  
 //            		window.location.href = "{{url('project/index')}}/"

	//             	localStorage.setItem("lead_id",url)
	//             	localStorage.setItem("status","unread")
 //            	}else{
	// 				localStorage.setItem("status","read")

 //            		location.reload(true);  
 //            		window.location.href = url
 //            	}          	           	 
 //            }else{
 //            	if (window.location.href.split("/")[3].split("#")[1] == 'submitIdProject') {
	//             	location.reload(true);
	//             	window.location.href = url
	//             }else if (window.location.href.split("/")[3] == 'salesproject') {
	//             	window.location.href = url
	//             	location.reload(true);
	//             }else{
	//             	window.location.href = url
	//             }
 //            }
 //        })
 //    }

 //    function view_all(){
 //        window.location = "{{url('notif_view_all')}}"
 //    }

 //    function pushNotify(title,url) {
 //    	if (!("Notification" in window)) {
 //    		// checking if the user's browser supports web push Notification
 //    		alert("Web browser does not support desktop notification");
 //    	} else if (Notification.permission === "granted") {
    		
 //    		// if notification permissions is granted,
 //    		// then create a Notification object
 //    		createNotification(title,url);
 //    	} else if (Notification.permission !== "denied") {
 //    		alert("Going to ask for permission to show web push notification");
 //    		// User should give explicit permission
 //    		Notification.requestPermission().then((permission) => {
 //    			// If the user accepts, let's create a notification
 //    			createNotification(title,url);
 //    		});
 //    	}
 //    	// User has not granted to show web push notifications via Browser
 //    	// Let's honor his decision and not keep pestering anymore
 //    }

 //    function createNotification(title,url) {
 //    	var notification = new Notification('New Notification', {
 //    		icon: '{{asset("img/logopng.png")}}',
 //    		body: title,
 //    	});
 //    	// url that needs to be opened on clicking the notification
 //    	// finally everything boils down to click and visits right
 //    	notification.onclick = function() {
 //    		window.open(url);
 //    	};
 //    }
</script>
@endsection
