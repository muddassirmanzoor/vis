<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.head')

    <body >
        
        <div id="content-wrapper" >
            <div class="container-fluid" >
                @yield('content') <!-- Content from extended view -->
            </div>
        </div>


    </body>
    <footer class="pt-2 text-center" style="color: #ffffff !important;background: #001f5f;line-height: 2;">
        Copyright © Designed & Developed by PMIU Data Center 2024
    </footer>
    <script>
		function openNav() {
		  document.getElementById("mySidenav").style.width = "250px";
		}
		
		function closeNav() {
		  document.getElementById("mySidenav").style.width = "0";
		}
	</script>
</html>
