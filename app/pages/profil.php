<div class="form-titlex">Profil</div>
<div class="container">
	<div id="header-profile">
		<i class="fa fa-bars" aria-hidden="true"></i>
	</div>
	<main>
		<div class="row">
			<div class="left col-lg-4">
				<div class="photo-left">
					<img class="photo" src="<?php echo baseurl; ?>assets/images/user.svg" />
				</div>
				<h4 class="name" id="namex"><?php echo (isset($_SESSION['sdata']['name'])) ? $_SESSION['sdata']['name']: ""; ?></h4>
				<p class="info" id="group"><?php echo (isset($_SESSION['sdata']['group'])) ? $_SESSION['sdata']['group']: ""; ?></p>
				<p class="info" id="emailx"><?php echo (isset($_SESSION['sdata']['email'])) ? $_SESSION['sdata']['email']: ""; ?></p>
				<p class="desc" id="perusahaanx"><?php echo (isset($_SESSION['sdata']['perusahaan'])) ? $_SESSION['sdata']['perusahaan']: "You company name should be here.."; ?></p>
			</div>
			<div class="right col-lg-8">
				<div class="row gallery">
					<div class="col-md-4">
						<div class="infox">
						    <img src="<?php echo baseurl; ?>assets/images/loader.svg">
						</div>
						<div class="smart-wrap">
							<div class="form-titlex">&#9881;</div>
							<div class="smart-forms smart-container wrap-2">
						        <form id="form-profil" action="<?php echo baseurl; ?>app/db/db_data.php">
						        	<div class="form-body theme-yellow">
										<div class="spacer-b30">
					                    	<div class="tagline"><span>Data Pribadi</span></div>
					                    </div>
						            	<div class="section">
						                	<label for="name" class="field-label">Nama</label>
						                	<label class="field">
						                    	<input type="text" value="<?php echo (isset($_SESSION['sdata']['name'])) ? $_SESSION['sdata']['name']: ""; ?>" name="name" id="name" class="gui-input" placeholder="Isikan nama">
						                    </label>
						                </div>

						                <div class="section">
						                    <label for="email" class="field-label">Email</label>
						                    <label class="field">
						                        <input type="email" value="<?php echo (isset($_SESSION['sdata']['email'])) ? $_SESSION['sdata']['email']: ""; ?>" name="email" id="email" class="gui-input" disabled>
						                    </label>
						                </div>

										<div class="section">
						                	<label for="phone" class="field-label">Phone</label>
						                	<label class="field">
						                    	<input type="text" value="<?php echo (isset($_SESSION['sdata']['phone'])) ? $_SESSION['sdata']['phone']: ""; ?>" name="phone" id="phone" class="gui-input" placeholder="Isikan no. HP">
						                    </label>
						                </div>

										<div class="section">
						                	<label for="nik" class="field-label">NIK</label>
						                	<label class="field">
						                    	<input type="text" value="<?php echo (isset($_SESSION['sdata']['nik'])) ? $_SESSION['sdata']['nik']: ""; ?>" name="nik" id="nik" class="gui-input" placeholder="Isikan no. NIK">
						                    </label>
						                </div>

										<div class="spacer-t40 spacer-b30">
					                    	<div class="tagline"><span>Data Perusahaan</span></div>
					                    </div>

										<div class="section">
						                	<label for="perusahaan" class="field-label">Perusahaan</label>
						                	<label class="field">
						                    	<input type="text" value="<?php echo (isset($_SESSION['sdata']['perusahaan'])) ? $_SESSION['sdata']['perusahaan']: ""; ?>" name="perusahaan" id="perusahaan" class="gui-input" placeholder="Isikan nama perusahaan">
						                    </label>
						                </div>

										<div class="section">
						                	<label for="npwp" class="field-label">NPWP</label>
						                	<label class="field">
						                    	<input type="text" value="<?php echo (isset($_SESSION['sdata']['npwp'])) ? $_SESSION['sdata']['npwp']: ""; ?>" name="npwp" id="npwp" class="gui-input" placeholder="Isikan No. NPWP">
						                    </label>
						                </div>

										<div class="section">
						                	<label for="nib" class="field-label">No. NIB</label>
						                	<label class="field">
						                    	<input type="text" value="<?php echo (isset($_SESSION['sdata']['nib'])) ? $_SESSION['sdata']['nib']: ""; ?>" name="nib" id="nib" class="gui-input" placeholder="Isikan No. NIB">
						                    </label>
						                </div>

										<div class="section">
						                	<label for="tglnib" class="field-label">Tgl. NIB</label>
						                	<label class="field">
						                    	<input type="text" value="<?php echo (isset($_SESSION['sdata']['tanggal_nib'])) ? $_SESSION['sdata']['tanggal_nib']: ""; ?>" name="tglnib" id="tglnib" class="gui-input" placeholder="Isikan tanggal NIB">
						                    </label>
						                </div>

										<div class="section">
											<label for="alamat" class="field-label">Alamat</label>
					                    	<label class="field prepend-icon">
					                        	<textarea class="gui-textarea" id="alamat" name="alamat" placeholder=""><?php echo (isset($_SESSION['sdata']['alamat'])) ? $_SESSION['sdata']['alamat']: ""; ?></textarea>
					                            <span class="field-icon"><i class="fa fa-map-marker"></i></span>
					                            <span class="input-hint"> <strong>Hint:</strong> Please enter between 80 - 300 characters.</span>
					                        </label>
					                    </div>

										<div class="spacer-t40 spacer-b30">
					                    	<div class="tagline"><span>Username & Password</span></div>
					                    </div>

					                    <div class="section">
						                    <label for="username" class="field-label">Username</label>
						                    <label class="field">
						                        <input type="text" value="<?php echo (isset($_SESSION['sdata']['username'])) ? $_SESSION['sdata']['username']: ""; ?>" name="username" id="username" class="gui-input" disabled>
						                    </label>
						                </div>

						            	<div class="section">
						                	<label for="password" class="field-label">Ganti password</label>
						                	<label class="field prepend-icon">
						                    	<input type="password" name="password" id="password" autocomplete="off" class="gui-input">
						                        <span class="field-icon"><i class="fa fa-lock"></i></span>
						                    </label>
						                </div>

						            	<div class="section">
						                	<label for="confirmPassword" class="field-label">Konfirmasi password</label>
						                	<label class="field prepend-icon">
						                    	<input type="password" name="confirmPassword" id="confirmPassword" autocomplete="off" class="gui-input">
						                        <span class="field-icon"><i class="fa fa-unlock-alt"></i></span>
						                    </label>
						                </div>

						            </div>
						            <div class="form-footer">
						                <input type="hidden" name="action" value="uprofil">
										<input type="hidden" id="user_id" name="user_id" value="<?php echo (isset($_SESSION['sdata']['user_id'])) ? $_SESSION['sdata']['user_id']: ""; ?>">
										<input type="hidden" id="emailh" name="emailh" value="<?php echo (isset($_SESSION['sdata']['email'])) ? $_SESSION['sdata']['email']: ""; ?>">
						            	<button type="submit" class="button btn-yellow">Simpan</button>
						            </div>
						        </form>
						  	</div>
						</div>
					</div>
					<!-- <div class="col-md-4">
						<img src="<?php echo baseurl; ?>assets/images/pexels-photo-113338.jpeg" />
					</div> -->
				</div>
			</div>
	</main>
</div>
