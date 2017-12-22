<style type="text/css">
	nav{
		.menu-main-menu-container{
			position: absolute;
			top: 30px;
			right: 0;
		  	font-family: 'Titillium Web', sans-serif;
			font-size: 18px;
			font-weight: 300;
			color: #ffffff;
			overflow: hidden;
			li{
				display: inline;
				padding: 0 5px;
			  	&:last-child{
					border-right: none;
					margin-right: 20px;
				  	border-bottom: 0;
				}
			}
			a{
			  	color: #ffffff;
			  	transition: all .3s;
			  	&:hover{
		  			color: #000;
		  		}
			}
			&:hover{
				text-decoration:none;
	  		}
		}
	}
</style>

<nav>
	<?php wp_nav_menu(); ?>
</nav>