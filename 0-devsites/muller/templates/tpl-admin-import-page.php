<div class="wrap" id='import'>
	<h2>Import</h2>

	<table class='form-table' >
		<tbody>
			<!-- <tr>
				<td>
					<form id="import-dropzone" action="/wp-admin/admin-ajax.php" class="dropzone">
						<input type='hidden' name='action' value='upload_csv' />
					</form>
				</td>
			</tr> -->
			<tr>
				<td id='csvTable'>
					<?= $this->csvTable;?>
				</td>
			</tr>
			
		</tbody>
	</table>

	<importfunction :inprogress='inprogress' :importfunctionname='"importProductCategories"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"importProducts"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"cleantaxs"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"cleanurls"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"getProductImages"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"importMerken"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"deleteProducts"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"buildcache"' ></importfunction>
	<importfunction :inprogress='inprogress' :importfunctionname='"getnewmeta"' ></importfunction>

	<table class='form-table'>
		<tbody>
			<tr>
				<td>
					Product ID:
				</td>
				<td>
					<input type="text" v-model='productid' name="">
				</td>
				<td>
					<a class='button-primary'  v-on:click='getimages'>Get images</a>
				</td>
			</tr>	
		</tbody>
	</table>


</div>
