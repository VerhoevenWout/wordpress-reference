<template>
	<table class='form-table importfunctions'>
		<tbody>
			<tr>
				<td class='progress'>
					{{ parseInt(percent) }} %
					<span v-bind:style="progressbarstyle"></span>
				</td>
				<td >
					<a v-on:click='start' v-bind:class="{ disabled: inprogress != false || completed != false }" class='button-primary'  id='import-categories' title='Importeer categorie&euml;n'>Start {{ importfunctionname }}</a>
				</td>
			</tr>
			<tr v-show='completed != false'>
				<td> Voltooid op {{ getcompleteddate() }} </td>
				<td></td>
			</tr>
		</tbody>
	</table>
</template>

<script>
	var Vue = require('vue');
	import { EventBus } from '../helper/event.js';

	export default {
		name: 'importfunction',

		props: ['importfunctionname', 'inprogress'],

		data: function () {
    		return {
				progress: {
					0: 0,
					1: 0
				},
				percent: 0,
				progressbarstyle:{
					'width': '0%'
				}, 
				completed: false,
				refreshIntervalId: false
			}
		},

		created: function() {
			
			this.pollprogress();

			
		},
		
		methods: {
			start: function(){
				if(this.inprogress == false && this.completed == false){
					var formData = new FormData();
					formData.append('action', 'start_import');
					formData.append('importfunctionname', this.importfunctionname);

					var vm = this;

			    	this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
			        	 vm.startinterval();
			        });
		    	}
			}, 
			pollprogress: function(){

				var formData = new FormData();
				formData.append('action', 'pollprogress');
				formData.append('import_function', this.importfunctionname);

				this.$http.post('/wp-admin/admin-ajax.php', formData).then((response) => {
		        	if(response.body == false){
		        		this.percent = 0;
		        		clearInterval(this.refreshIntervalId);
		        	} else if (response.body[0] == 'complete'){
		        		this.progress = response.body;
		        		this.completed = response.body[1];
		        		this.percent = 100;
		        		clearInterval(this.refreshIntervalId);
		        	} else{
		        		this.progress = response.body;
						this.percent = (this.progress[0]/this.progress[1])*100;
						EventBus.$emit('inprogressmethod', this.importfunctionname);
		        	}

		        	this.progressbarstyle['width'] = parseInt(this.percent)+'%';

		        });

			}, 
			getcompleteddate(){
				var d = new Date(this.completed*1000);
				return d.toLocaleString();
			}, 
			startinterval(){
				this.refreshIntervalId = setInterval(function () {
			      this.pollprogress();
			    }.bind(this), 3000); 
			}
		} 
	}

</script>