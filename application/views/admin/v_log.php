<div id="page-wrapper">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-header">Data Log History User</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
	    	<div class="panel panel-default">
	        	<div class="panel-body">
			        <table class="table detail table-striped table-bordered table-hover">
			        	<thead>
			            	<tr>
								<th>#</th>
			                	<th>NIP User</th>
			                    <th>Nama User</th>
			                    <th>Akses User</th>
			                    <th>IP Address</th>
			                    <th>Waktu</th>
			                    <th>Keterangan</th>
			                </tr>
			            </thead>
			            <tbody>
			            <?php $no = 1;
			            foreach($log_history->result() as $log){ ?>
			            	<tr>
								<td><?= $no++ ?></td>
			            		<td><?= $log->user_session ?></td>
			            		<td><?= $log->nama_user ?></td>
			            		<td><?= $log->akses_user ?></td>
			            		<td><?= $log->ip_address ?></td>
			            		<td><?= $log->waktu ?></td>
			            		<td><?= $log->detail ?></td>
			            	</tr>
			            <?php } ?>   
			            </tbody>
			        </table>
		        </div>
	        </div>
	    </div>
	</div>
</div>