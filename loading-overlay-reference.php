<style>
  @-webkit-keyframes uil-ring-anim {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
  }
  @-moz-keyframes uil-ring-anim {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
  }
  @-webkit-keyframes uil-ring-anim {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
  }
  @-o-keyframes uil-ring-anim {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
  }
  @keyframes uil-ring-anim {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
  }

  .loading-ring{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  display: block;
  width: 100px;
  height: 100px;
  border-radius: 50px;
  box-shadow: 0 3px 0 0 #a7e5ef;
  -webkit-transform-origin: 50px 51.5px;
  transform-origin: 50px 51.5px;
  -webkit-animation: uil-ring-anim 0.5s linear infinite;
  animation: uil-ring-anim 0.5s linear infinite;
  }
  .loading-overlay{
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, .9);
  z-index: 9999;
  transition: all .3s;
  }
  .fade-loading-overlay{
  opacity: 0;
  transition: all .3s;
  }
  .hide-loading-overlay{
  visibility: hidden;
  }
</style>

<div class="loading-overlay">
  <div class='loading-ring'></div>
</div>

<script>
  // Only hide when fully loaded
  window.onload = function () {
  	setTimeout(function(){
  		hideOverlay();
  	}, 1000);
  }
  function hideOverlay(){
  	console.log('hiding');
  	$('.loading-overlay').addClass('fade-loading-overlay');
  	setTimeout(function(){
  		$('.loading-overlay').addClass('hide-loading-overlay');
  	},300);
  }
</script>






<!-- ------------------------------------------------------------ -->
<!-- ------------------------------------------------------------ -->
<!-- ------------------------------------------------------------ -->

<style>
  .loading-overlay{
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, .9);
  z-index: 9999;
  transition: all .3s;
  }
  .fade-loading-overlay{
  opacity: 0;
  transition: all .3s;
  }
  .hide-loading-overlay{
  visibility: hidden;
  }

  .profile-main-loader{
    left: 50% !important;
    margin-left:-50px;
    position: fixed !important;
    top: 50% !important;
    margin-top: -50px;
    width: 45px;
    z-index: 9000 !important;
  }

  .profile-main-loader .loader {
  position: relative;
  margin: 0px auto;
  width: 100px;
  height:100px;
  }
  .profile-main-loader .loader:before {
  content: '';
  display: block;
  padding-top: 100%;
  }

  .circular-loader {
  -webkit-animation: rotate 2s linear infinite;
          animation: rotate 2s linear infinite;
  height: 100%;
  -webkit-transform-origin: center center;
      -ms-transform-origin: center center;
          transform-origin: center center;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  margin: auto;
  }

  .loader-path {
  stroke-dasharray: 150,200;
  stroke-dashoffset: -10;
  -webkit-animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
          animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
  stroke-linecap: round;
  }

  @-webkit-keyframes rotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
  }

  @keyframes rotate {
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
  }
  @-webkit-keyframes dash {
  0% {
    stroke-dasharray: 1,200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -124;
  }
  }
  @keyframes dash {
  0% {
    stroke-dasharray: 1,200;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 89,200;
    stroke-dashoffset: -124;
  }
  }
  @-webkit-keyframes color {
  0% {
    stroke: #ccc;
  }
  40% {
    stroke: #ccc;
  }
  66% {
    stroke: #ccc;
  }
  80%, 90% {
    stroke: #ccc;
  }
  }
  @keyframes color {
  0% {
    stroke: #ccc;
  }
  40% {
    stroke: #ccc;
  }
  66% {
    stroke: #ccc;
  }
  80%, 90%, 100% {
    stroke: #ccc;
  }
  }
</style>

  <div class="loading-overlay">
    <div class="profile-main-loader">
      <div class="loader">
        <svg class="circular-loader"viewBox="25 25 50 50" >
          <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#70c542" stroke-width="2" />
        </svg>
      </div>
    </div>
  </div>

<script>
  // Only hide when fully loaded
  window.onload = function () {
    setTimeout(function(){
      hideOverlay();
    }, 1000);
  }
  function hideOverlay(){
    console.log('hiding');
    $('.loading-overlay').addClass('fade-loading-overlay');
    setTimeout(function(){
      $('.loading-overlay').addClass('hide-loading-overlay');
    },300);
  }
</script>
