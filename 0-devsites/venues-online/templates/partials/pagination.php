<ul class="pagination pagination-desktop" v-if="pagination != null && filterdata.lat">
	<li class="fa fa-chevron-left" v-on:click="paginationIndexDown()"></li>
	<span v-if="pagination.length >= 6">
		<li v-if="pageindex > 3" v-on:click="gotopage(pageindexmin)">{{ pageindexmin+1 }}</li>
		<li v-if="pageindex > 3">...</li>
		<li v-if="pagination[pageindex-3]" v-on:click="gotopage(pageindex-3)">{{ pageindex-2 }}</li>
		<li v-if="pagination[pageindex-2]" v-on:click="gotopage(pageindex-2)">{{ pageindex-1 }}</li>
		<li v-if="pagination[pageindex-1]" v-on:click="gotopage(pageindex-1)">{{ pageindex }}</li>

		<li v-on:click="gotopage(pageindex)" class="activepage">{{ pageindex + 1 }}</li>
		
		<li v-if="pagination[pageindex+1]" v-on:click="gotopage(pageindex+1)">{{ pageindex+2 }}</li>
		<li v-if="pagination[pageindex+2]" v-on:click="gotopage(pageindex+2)">{{ pageindex+3 }}</li>
		<li v-if="pagination[pageindex+3]" v-on:click="gotopage(pageindex+3)">{{ pageindex+4 }}</li>
		<li v-if="pageindex < pageindexmax-2">...</li>
		<li v-if="pageindex < pageindexmax-2" v-on:click="gotopage(pageindexmax)">{{ pageindexmax+1 }}</li>
	</span>
	<span v-if="pagination.length < 6">
		<li v-if="pageindex > 1" v-on:click="gotopage(pageindexmin)">{{ pageindexmin+1 }}</li>
		<li v-if="pageindex > 1">...</li>
		<li v-if="pagination[pageindex-1]" v-on:click="gotopage(pageindex-1)">{{ pageindex }}</li>

		<li v-on:click="gotopage(pageindex)" class="activepage">{{ pageindex + 1 }}</li>
		
		<li v-if="pagination[pageindex+1]" v-on:click="gotopage(pageindex+1)">{{ pageindex+2 }}</li>
		<li v-if="pageindex < pageindexmax">...</li>
		<li v-if="pageindex < pageindexmax" v-on:click="gotopage(pageindexmax)">{{ pageindexmax+1 }}</li>
	</span>
	<li class="fa fa-chevron-right" v-on:click="paginationIndexUp()"></li>
</ul>

<ul class="pagination pagination-mobile" v-if="pagination != null && filterdata.lat">
	<li class="fa fa-chevron-left" v-on:click="paginationIndexDown()"></li>
	<span>
		<li v-if="pageindex > 1" v-on:click="gotopage(pageindexmin)">{{ pageindexmin+1 }}</li>
		<li v-if="pageindex > 1">...</li>
		<li v-if="pagination[pageindex-1]" v-on:click="gotopage(pageindex-1)">{{ pageindex }}</li>

		<li v-on:click="gotopage(pageindex)" class="activepage">{{ pageindex + 1 }}</li>
		
		<li v-if="pagination[pageindex+1]" v-on:click="gotopage(pageindex+1)">{{ pageindex+2 }}</li>
		<li v-if="pageindex < pageindexmax">...</li>
		<li v-if="pageindex < pageindexmax" v-on:click="gotopage(pageindexmax)">{{ pageindexmax+1 }}</li>
	</span>
	<li class="fa fa-chevron-right" v-on:click="paginationIndexUp()"></li>
</ul>