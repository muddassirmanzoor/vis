<header class="mb-3 border-bottom">
<style>		
		.sidenav {
		  height: 100%;
		  width: 0;
		  position: fixed;
		  z-index: 1;
		  top: 0;
		  left: 0;
		  background-color: #001f5f;
		  overflow-x: hidden;
		  transition: 0.5s;
		  padding-top: 60px;
		}
		
		.sidenav a {
		  padding: 8px 8px 8px 32px;
		  text-decoration: none;
		  font-size: 25px;
		  color: #818181;
		  display: block;
		  transition: 0.3s;
		}
		
		.sidenav a:hover {
		  color: #f1f1f1;
		}
		
		.sidenav .closebtn {
				position: absolute;
				top: 8px;
				right: 5px;
				font-size: 36px;
				margin-left: 15px;
				z-index: 1000;
				color: #001f5f;
			}
		a.navbar-brand.siderbar-navbar-brand {
			position: absolute;
			top: 0;
			background: #c39f3b;
			width: 100%;
			text-align: center;
			padding: 10px 0px;
		}
		ul.menu-sider-bar {
			position: relative;
			top: 40px;
			padding-left: 15px;
		}
		ul.menu-sider-bar li {
			list-style: none;
			color: #c39f3b;
		}
		ul.menu-sider-bar li a {
			color: #c39f3b;
		}
		ul.menu-sider-bar li a:hover {
			color: #ffffff;
		}
		span.welcome-text {
			color: #c39f3b;
			font-size: 21px;
		}
		ul.menu-sider-bar a svg {
			margin-right: 15px;
		}
		.rounded-circle {
			border-radius: 50% !important;
			border: 2px solid #c39f3b;
		}
		ul.menu-sider-bar a svg path {
			fill: #c39f3b;
		}
		ul.menu-sider-bar a:hover svg path {
			fill: #ffffff;
		}
		/***********************/
		header.header.sticky {
			background: #ffffff;
		}
		.sticky {
		position: fixed;
		top: 0;
		width: 83.3%;
		}
		.sticky + .content {
		padding-top: 102px;
		}
		@media screen and (max-height: 450px) {
		  .sidenav {padding-top: 15px;}
		  .sidenav a {font-size: 18px;}
		}
		</style>
			<nav class="navbar navbar-expand-lg bg-header-color">
				<div class="container">
					<span style="font-size:30px;cursor:pointer;color: #001f5f;" onclick="openNav()">&#9776;</span>
					<a class="navbar-brand" href="{{url('/show-map')}}">
						<span class="app-brand-logo demo">
						  <img src="{{url('/img/vis-logo.png')}}" style=" width: 100px; ">
						</span>
					</a>	
					<div class="dropdown text-end">
						<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
							<span class="welcome-text">Welcome</span>
						<img src="{{url('/assets/images/user-icon.png')}}" alt="mdo" width="32" height="32" class="rounded-circle">
						</a>
						<ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
						<li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>
						</ul>
					</div>
				</div>
			  </nav>
			  <div id="mySidenav" class="sidenav">
				<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
				<a class="navbar-brand siderbar-navbar-brand" href="{{url('/show-map')}}">
					<span class="app-brand-logo demo">
					  <img src="{{url('/img/vis-logo.png')}}" style=" width: 100px; ">
					</span>
				</a>
				<ul class="menu-sider-bar">	
				<li><a href="{{url('/show-map')}}" class="nav-link px-2 link-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map-fill" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.598-.49L10.5.99 5.598.01a.5.5 0 0 0-.196 0l-5 1A.5.5 0 0 0 0 1.5v14a.5.5 0 0 0 .598.49l4.902-.98 4.902.98a.5.5 0 0 0 .196 0l5-1A.5.5 0 0 0 16 14.5zM5 14.09V1.11l.5-.1.5.1v12.98l-.402-.08a.5.5 0 0 0-.196 0zm5 .8V1.91l.402.08a.5.5 0 0 0 .196 0L11 1.91v12.98l-.5.1z"/>
				  </svg> Schools Map</a></li>
				<li><a href="{{url('/show-map-sne')}}" class="nav-link px-2 link-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map-fill" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.598-.49L10.5.99 5.598.01a.5.5 0 0 0-.196 0l-5 1A.5.5 0 0 0 0 1.5v14a.5.5 0 0 0 .598.49l4.902-.98 4.902.98a.5.5 0 0 0 .196 0l5-1A.5.5 0 0 0 16 14.5zM5 14.09V1.11l.5-.1.5.1v12.98l-.402-.08a.5.5 0 0 0-.196 0zm5 .8V1.91l.402.08a.5.5 0 0 0 .196 0L11 1.91v12.98l-.5.1z"/>
				  </svg> NEW SNE Schools Map</a></li>
				<li><a href="{{url('/punjab-stats')}}" class="nav-link px-2 link-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
					<path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
				  </svg>Schools Stats</a></li>
				<li><a href="{{url('/complaint-form')}}" class="nav-link px-2 link-dark"><svg width="20" height="25" viewBox="0 0 35 38" fill="currentColor" class="bi bi-bar-chart-fill" xmlns="http://www.w3.org/2000/svg">
<path d="M22.2132 6.13153C22.3417 6.38026 22.5044 6.60755 22.7013 6.80482C22.8939 6.98923 23.1551 7.08786 23.4206 7.07929H29.1275V6.46603C29.1232 6.27305 29.0976 6.08436 29.0505 5.89995C28.9648 5.62978 28.8236 5.37676 28.6395 5.16233C28.3483 4.78923 28.0315 4.43329 27.689 4.10307C27.278 3.69138 26.7257 3.16818 26.0236 2.57208C25.3214 1.97598 24.8462 1.52998 24.4652 1.2255C24.0842 0.921015 23.6689 0.629398 23.3777 0.427839C23.1423 0.269165 22.8854 0.153376 22.6114 0.076183C22.393 0.050452 22.1704 0.050452 21.9521 0.076183H21.875V4.59625C21.8793 4.81925 21.9007 5.10229 21.9478 5.32101C22.0163 5.61691 22.0505 5.7327 22.1704 6.02432L22.2132 6.13153Z" fill="black"></path>
<path d="M23.4658 18.2354C22.9991 18.6771 22.3784 18.9215 21.7362 18.9086H7.24824C6.61461 18.9215 6.00238 18.6771 5.54857 18.2354C5.08619 17.8022 4.83359 17.1975 4.84643 16.5671C4.83787 15.9324 5.09047 15.3192 5.54857 14.8818C5.99382 14.4272 6.61033 14.1784 7.24824 14.1913H21.7961C22.4426 14.1784 23.0634 14.4272 23.5257 14.8818C23.9924 15.3192 24.2536 15.9281 24.245 16.5671C24.2536 17.2018 23.9924 17.8065 23.5257 18.2354H23.4658ZM23.4658 9.45681C22.8151 9.47825 22.1729 9.31529 21.6163 8.98079C21.1154 8.68917 20.683 8.29034 20.3447 7.81432C20.0236 7.34688 19.7796 6.82797 19.6255 6.28333C19.4842 5.78586 19.4071 5.27124 19.3943 4.75234V0.000690399H4.58955C3.96877 -0.0121751 3.36082 0.155076 2.82994 0.476713C2.2905 0.789773 1.79815 1.18431 1.37858 1.64318C0.963293 2.09776 0.620789 2.61238 0.368192 3.17417C0.13272 3.71023 0.0042813 4.28918 0 4.8767V30.6505C0.0042813 31.2938 0.175533 31.9242 0.505194 32.4731C0.843416 33.0435 1.26727 33.5624 1.75961 34.0041C2.25196 34.4416 2.80425 34.8061 3.39507 35.0934C3.8703 35.3379 4.39261 35.4794 4.9235 35.5051H15.631L23.1576 27.8416C22.7508 28.1546 22.2499 28.3176 21.7362 28.3004H7.24824C6.61033 28.3133 5.9981 28.0646 5.54857 27.61C5.11187 27.2069 4.85928 26.6408 4.84643 26.049C4.83359 25.4143 5.09047 24.801 5.54857 24.3636C5.98954 23.9004 6.60605 23.6431 7.24824 23.6603H21.7961C22.4469 23.6474 23.0719 23.9004 23.5257 24.3636C23.9924 24.801 24.2536 25.41 24.245 26.049C24.245 26.5207 24.0952 26.9839 23.8169 27.3655L29.1385 21.9878V9.45681H23.4658ZM25.3453 29.201L23.9539 30.5819L22.6695 31.8556L21.7062 32.8076L21.201 33.2965C20.9398 33.541 20.7301 33.8326 20.5716 34.1542C20.4903 34.3429 20.4175 34.5402 20.3576 34.7375L20.0665 35.6252L19.7925 36.5429C19.7154 36.8474 19.6683 37.079 19.6383 37.2162C19.5741 37.4306 19.5998 37.6665 19.7154 37.8595C19.8224 37.9839 20.0194 38.0267 20.3447 37.9838C20.5759 37.941 20.8071 37.8852 21.034 37.8166C21.3637 37.748 21.6934 37.6622 22.0144 37.555C22.3527 37.4649 22.6738 37.3406 23.0077 37.2334L23.8169 36.8646L24.275 36.5901L24.7031 36.2685L26.0175 34.9519L27.3019 33.6954L28.6933 32.3316L32.4565 28.6692L29.2028 25.4786L25.3453 29.201ZM34.9996 25.693C34.9782 25.4314 34.9269 25.1741 34.8455 24.9254C34.6828 24.5523 34.4473 24.2135 34.1562 23.9305C33.925 23.6603 33.6467 23.433 33.3299 23.27C33.0516 23.1199 32.7434 23.0385 32.4266 23.0256C32.0584 22.987 31.6945 23.1157 31.4333 23.3773L30.9452 23.7889C30.7826 23.9519 30.607 24.1063 30.4272 24.2478L33.7152 27.4342C33.8137 27.3655 33.9079 27.2884 33.9892 27.2026L34.2632 26.911L34.6143 26.5593C34.8669 26.3449 35.0082 26.0275 34.9996 25.693Z" fill="black"></path>
</svg>Add Complaint</a></li>
				@if(auth()->check() && auth()->user()->role == 'Support')
					<li>
						<a href="{{ url('/complaint-listing') }}" class="nav-link px-2 link-dark">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
								<path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
							</svg> Complaints List
						</a>
					</li>
				@endif
				<li><a href="{{route('logout')}}" class="nav-link px-2 link-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
					<path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
				  </svg>Sign out</a></li>
				</ul>
			</div>
	  </header>