<style>
p {
	font-size: 20px;
}
</style>

<div id="page-wrapper">
<div class="row">
	<div class="col-md-12">
		<h1 class="page-header">Petunjuk Pengisian Aplikasi MMC</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<p><i class="glyphicon glyphicon-exclamation-sign"></i> Level Akses User</p>
	<ul>
		<li style="font-size: 20px;">Maker = Jr.BBRM / BBRM</li>
		<li style="font-size: 20px;">Checker = BM / AM / ABBM</li>
		<li style="font-size: 20px;">Reviewer = BFO Staff / AFO Staff</li>
		<li style="font-size: 20px;">Approval = BFO / AFO Officer</li>
	</ul>	
	</div>
</div><br>
<?php $akses = $this->session->userdata('akses_user');
if($akses == 'Admin'){ ?>
<div class="row">
	<div class="col-md-12">
	<p><i class="glyphicon glyphicon-exclamation-sign"></i> Mengelola Data User</p>
	<p>1. Menambahkan User Baru</p>
	<ul>
		<li style="font-size: 20px;">Masuk ke menu <i style="color: blue">Setting Users</i> <i class="glyphicon glyphicon-menu-right"></i> <i style="color: blue">Input Users</i></li>
		<li style="font-size: 20px;">Masuk ke tampilan "Registrasi User", isi semua fields sesuai dengan ketentuan validasi</li>
		<i class="text-muted" style="color: red">untuk pengisian field nama menggunakan huruf CAPITAL kecuali field email</i>
		<li style="font-size: 20px;">Jika foto ingin diganti maka pilih foto yang ingin di upload dengan format (jpg, jpeg, png), jika tidak biarkan tetap kosong</li>
		<li style="font-size: 20px;">Jika semua field sudah terisi dan validasi field telah sesuai maka klik tombol <b>Simpan</b></li>
	</ul>
	<p>2. Mengubah User</p>
	<ul>
		<li style="font-size: 20px;">Masuk ke menu <i style="color: blue">Dashboard</i> <i class="glyphicon glyphicon-menu-right"></i> cari data yang akan diubah pada table, lalu klik icon <i class="glyphicon glyphicon-edit" style="color: blue"></i></li>
		<li style="font-size: 20px;">Masuk ke tampilan "Edit User", isi semua fields sesuai dengan ketentuan validasi</li>
		<li style="font-size: 20px;">Jika foto ingin diganti maka pilih foto yang ingin di upload dengan format (jpg, jpeg, png), jika tidak biarkan tetap kosong</li>
		<li style="font-size: 20px;">Jika semua field sudah terisi dan validasi field telah sesuai maka klik tombol <b>Simpan</b></li>
	</ul>	
	</div>
</div><br>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"> Menu</i> <i style="color: blue">Daftar Log History</i>
		<p>digunakan untuk mengetahui aktifitas yang dilakukan oleh User.</p>
	</div>
</div>
<?php } else if($akses == 'Maker'){ ?>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"></i> Menu <i style="color: blue">Dashboard</i></p>
		<p>digunakan untuk melihat detail nasabah yang tercatat di cabang <u>Maker</u> dengan cara klik No. MMC yang tertera pada table.
		<ul>
			<li style="font-size: 20px;">Table "Detail Data Revisi" berisi data nasabah yang telah diperiksa oleh <u>Checker</u> dan harus direvisi oleh <u>Maker</u>, dengan cara klik icon <i class="glyphicon glyphicon-edit" style="color: blue"></i> pada data yang akan direvisi.</li>
		</ul>
		</p>
	</div>
</div><br>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"></i> Mengelola Data Koperasi</p>
		<p>untuk Kode Koperasi di isi oleh <u>Reviewer</u></p>
		<p>1. Menambahkan Data Koperasi Baru
		<ul>
			<li style="font-size: 20px;">Klik menu <i style="color: blue">Data Pembiayaan</i> <i class="glyphicon glyphicon-menu-right"></i> <i style="color: blue">Data Koperasi</i></li>
			<li style="font-size: 20px;">Masuk ke tampilan "Data Koperasi" lalu klik tombol <b>Tambah Data</b></li>
			<li style="font-size: 20px;">Masuk ke tampilan "Pendaftaran Koperasi", isi semua fields sesuai dengan data yang sebenarnya</li>
			<li style="font-size: 20px;">Khusus untuk field Tenor Bank & Rate Bank klik icon <span style="color: blue">+</span> untuk sliding bertingkat</li>
			<li style="font-size: 20px;">Jika semua field sudah terisi dan validasi field telah sesuai maka klik tombol <b>Simpan</b></li>
		</ul>
		</p>
	</div>
	<div class="col-md-12">
		<p>2. Mengubah Data Koperasi
		<ul>
			<li style="font-size: 20px;">Klik menu <i style="color: blue">Data Pembiayaan</i> <i class="glyphicon glyphicon-menu-right"></i> <i style="color: blue">Data Koperasi</i></li>
			<li style="font-size: 20px;">Masuk ke tampilan "Data Koperasi" lalu klik icon <i class="glyphicon glyphicon-edit" style="color: blue"></i> pada data yang akan diubah</li>
			<li style="font-size: 20px;">Masuk ke tampilan "Pendaftaran Koperasi", isi semua fields sesuai dengan data yang sebenarnya</li>
			<li style="font-size: 20px;">Jika semua field sudah terisi dan validasi field telah sesuai maka klik tombol <b>Simpan</b></li>
		</ul>
		</p>
	</div>
</div><br>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"></i> Mengelola Data Pembiayaan Nasabah</p>
		<p>1. Menambahkan Data Pembiayaan Nasabah
		<ul>
			<li style="font-size: 20px;">Klik menu <i style="color: blue">Data Pembiayaan</i> <i class="glyphicon glyphicon-menu-right"></i> <i style="color: blue">Input Data Pembiayaan</i></li>
			<li style="font-size: 20px;">Masuk ke tampilan "Step 1 - Form Input", isi semua field dengan benar</li>
			<li style="font-size: 20px;">Jika semua field sudah terisi dan validasi field telah sesuai maka klik tombol <b>Next</b></li>
			<li style="font-size: 20px;">Lakukan langkah di atas sampai ke tahap "Step 7 - Pendaftaran Kontrak (LD)", klik tabs <span style="color: blue">Data Statis Pembiayaan Murabahah</span> 
			lalu isi field yang ada. Setelah field terisi semua dan validasi sesuai maka klik tombol <b>Finish</b></li>
			<i class="text-muted" style="color: red">jika ada kesalahan input, harap selesaikan sampai tahap terakhir lalu lakukan revisi kelasahan input agar pencatatan data tidak terjadi kesalahan</i>
			<li style="font-size: 20px";>Data yang telah berhasil tersimpan maka akan tampil pada table yang ada di menu <i style="color: blue">Dashboard</i></li>
		</ul>
		</p>
	</div>
	<div class="col-md-12">
		<p>2. Mengubah Data Pembiayaan Nasabah
		<ul>
			<li style="font-size: 20px;">Pada menu <i style="color: blue">Dashboard</i> pilih data yang akan di revisi pada table</i></li>
			<li style="font-size: 20px;">Lengkapi pengisian field yang ada dari "Step 1" sampai "Step 7"</li>
			<li style="font-size: 20px;">Jika semua field sudah terisi dan validasi field telah sesuai maka klik tombol <b>Finish</b></li>
			<li style="font-size: 20px";>Data yang telah berhasil tersimpan maka akan tampil pada table yang ada di menu <i style="color: blue">Dashboard</i></li>
		</ul>
		</p>
	</div>
</div>
<?php } else if($akses == 'Checker'){ ?>
<div class="row">
	<div class="col-md-12">
	<p>Data yang di input oleh <u>Maker</u> akan tampil pada table manu <i style="color: blue">Dashboard</i>, lalu <u>Checker</u> akan mengkoreksi datanya sesuai dengan isi dokumen <i>Costumer Facility</i>, 
	dengan cara :</p>
	<ul>
		<li style="font-size: 20px;">Klik No.MMC pada data yang akan dikoreksi</li>
		<li style="font-size: 20px;">Setelah muncul modal form, koreksi satu per satu setiap tabs panel pada data</li>
		<li style="font-size: 20px;">Pada tabs panel "Kontrak Pembiayaan (LD)" terdapat 2 tombol <b>Revisi</b> dan <b>Approve</b></li>
		<ul>
			<li style="font-size: 20px;">Data yang statusnya <b>Revisi</b> akan dikembalikan lagi untuk dilakukan perubahan data oleh <u>Maker</u>, jika <u>Maker</u> telah melakukan perubahan data maka status akan 
			berganti menjadi <b>Panding</b> untuk di koreksi kembali oleh <u>Checker</u></li>
			<li style="font-size: 20px;">Data yang statusnya <b>Approve</b> akan diteruskan ke <u>Reviewer</u> untuk tindakan lebih lanjut</li>
		</li>
	</ul>
	</div>
</div>
<?php } else if($akses == 'Reviewer'){ ?>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"></i> Mengelola Data Koperasi</p>
		<p>Koperasi yang telah di daftarkan oleh <u>Maker</u> di aplikasi MMC semua belum memiliki Kode Koperasi, Kode Koperasi akan diisi oleh <u>Reviewer</u> dengan cara mencari Data Koperasi pada T24, 
		Koperasi yang belum memiliki Kode Koperasi maka datanya tidak dapat dilanjutkan ke <u>Approval</u></p>
	</div>
</div><br>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"></i> Aturan Pengisian Data</p>
		<ul>
			<li style="font-size: 20px">Data yang masuk ke halaman ini merupakan data yang statusnya "Approve" dan belum memilik Tanggal Cair yang akan diisi oleh <u>Reviewer</u></li>
			<li style="font-size: 20px"><u>Reviewer</u> akan mengkoreksi data dengan dokumen yang ada, jika terdapat perbedaan antara data dengan dokumen maka 
			<u>Reviewer</u> dapat mengubahnya langsung dengan cara klik icon <i class="glyphicon glyphicon-edit" style="color: blue"></i></li>
			<li style="font-size: 20px">untuk pengisian Tanggal Cair, klik View Details "Approved Pembiayaan", klik icon <i class="glyphicon glyphicon-search" style="color: blue"></i> pada data yang akan di input</li>
			<li style="font-size: 20px">Setelah muncul modal form pilih Tanggal Cair yang diinginkan, lalu klik tombol <b>Finish</b></li>
			<li style="font-size: 20px">Setelah Tanggal Cair diisi maka data tersebut akan diteruskan ke <u>Approval</u> untuk tahap selanjutnya</li>
		</ul>
	</div>
</div>
<?php } else { ?>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"></i> Mengelola Data Koperasi</p>
		<p>Koperasi yang telah di daftarkan oleh <u>Maker</u> di aplikasi MMC semua belum memiliki Kode Koperasi, Kode Koperasi akan diisi oleh <u>Reviewer</u> dengan cara mencari Data Koperasi pada T24, 
		Koperasi yang belum memiliki Kode Koperasi maka datanya tidak dapat dilanjutkan ke <u>Approval</u></p>
	</div>
</div><br>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign"></i> Proses Pencairan</p>
		<ul>
			<li style="font-size: 20px;">Klik menu View Details "Approved Pembiayaan"</li>
			<li style="font-size: 20px;">Pada table "Detail Data Approved" klik icon <i class="glyphicon glyphicon-share" style="color: blue"></i> pada data yang akan di prosess</li>
			<li style="font-size: 20px;">Hasil prosess pencairan yang Berhasil maka akan tampil pada table Data Hasil Pencairan, dan NOLOAN akan terbentuk otomatis</li>
			<li style="font-size: 20px;">Jika prosess pencairan yang Gagal akan tampil pada table Data Hasil Pencairan Gagal, dan <u>Approval</u> dapat melakukan revisi data yang Gagal di prosess</li>
			<li style="font-size: 20px;">Data yang Gagal di prosess akan bertahan selama 3 hari, jika data tidak segera di revisi maka data akan hilang</li>
		</ul>
	</div>
</div>
<?php } ?>
<br>
<div class="row">
	<div class="col-md-12">
		<p><i class="glyphicon glyphicon-exclamation-sign" style="color: red"></i> Aturan menggunakan Aplikasi MMC</p>
		<ul>
			<li style="font-size: 20px;">Sebelum menutup aplikasi, pastikan akun telah logout dengan cara klik menu <i style="color: blue">Status User</i> <i class="glyphicon glyphicon-menu-right"></i> <i style="color: blue">Logout</i>,
			 jangan langsung menutup browser</li>
			<li style="font-size: 20px;">Gunakan browser Google Chrome untuk performance yang lebih baik dan view browser 80%</li>
			<li style="font-size: 20px;">Pengisian field yang diizinkan menggunakan huruf CAPITAL, angka 0-9, karakter dot (.), slash (/) selain itu tidak diperbolehkan
			<li style="font-size: 20px;">Selesaikan proses <b>"pengisian data pembiayaan"</b> sampai selesai agar tidak terjadi kesalahan,
			 jika ada pengisian yang ingin di revisi lakukan setalah proses <b>"pengisian data pembiayaan"</b> selesai dengan cara klik icon <i class="glyphicon glyphicon-edit" style="color: blue"></i> pada table di menu 
			 <i style="color: blue">Dashboard</i></li>
		</ul>
	</div>
</div>
</div>