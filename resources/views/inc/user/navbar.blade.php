

	<!-- begin sidebar-nav -->
	<aside class="app-navbar">
  <div class="sidebar-nav scrollbar scroll_light">
	<ul class="metismenu " id="sidebarNav">
		<li>
			<a href="{{route('user.profile')}}" aria-expanded="false">
				<span class="nav-title">Profile</span>
			</a> 
		</li>
		<li>
			<a href="{{route('user.tools')}}" aria-expanded="false">
				<span class="nav-title">Tools</span>
			</a> 
		</li>
		@if($tools['tool']==1)
		<li>
			<a href="{{route('user.tools.find_value_stock')}}" aria-expanded="false">
				<span class="nav-title">Find Value Stocks</span>
			<small>Expiry Date {{date('d/m/Y',strtotime($tools['expiry_date']))}}</small>
			</a> 
		</li>
		@elseif($tools['tool']==2)
		<li>
			<a href="{{route('user.tools.optimize_investment_mix')}}" aria-expanded="false">
			<span class="nav-title">Optimize Investment Mix</span>
			<small>Expiry Date {{date('d/m/Y',strtotime($tools['expiry_date']))}}</small>
			</a> 
		</li>
		@elseif($tools['tool']==3)
		<li>
			<a href="{{route('user.tools.find_value_stock')}}" aria-expanded="false">
				<span class="nav-title">Find Value Stocks</span>
				<small>Expiry Date {{date('d/m/Y',strtotime($tools['expiry_date']))}}</small>
			</a> 
		</li>
		<li>
			<a href="{{route('user.tools.optimize_investment_mix')}}" aria-expanded="false">
			<span class="nav-title">Optimize Investment Mix</span>
			<small>Expiry Date {{date('d/m/Y',strtotime($tools['expiry_date']))}}</small>
			</a> 
		</li>
		@endif
		
		<li>
			<a href="{{route('user.settings')}}" aria-expanded="false">
				<span class="nav-title">Setting</span>
			</a> 
		</li>		
	</ul>
  </div>
	</aside>
	<!-- end sidebar-nav -->
	
	<!-- end app-navbar --> 















