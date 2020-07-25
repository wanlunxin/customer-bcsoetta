<link rel="stylesheet" type="text/css" href="<?php echo baseurl; ?>assets/datatables/css/datatables.css"/>

<style type="text/css">
	/* http://www.responsivegridsystem.com/calculator/ */
	.grid {
		width: 85%;
		margin: 2em auto;
		/* background-color: beige; */
		display: grid;
		grid-template-columns: repeat(4, 1fr);
	}

	.grid-div {
		margin: 4px;
		box-shadow: 1px 1px 1px 1px orange;
		/* height: 120px; */
		/* padding: 10px; */
		/* background-color: green; */
		/* border: 1px solid black; */
	}

	.grid-div img {
		width: 50%;
		height: 100%;
	}

	.grid-div a {
		margin: 10px 0 10px 0;
		display: inline-block;
		text-decoration: none;
	}

	.apptitle {
		font-size: 1rem;
		margin-top: 10px;
		font-weight: 700;
		color: #75a63d;
	}

	@media screen and (max-width: 1024px) {
		.grid {
			grid-template-columns: repeat(3, 1fr);
		}
	}

	@media screen and (max-width: 768px) {
		.grid {
			grid-template-columns: repeat(2, 1fr);
		}
	}
	@media screen and (max-width: 349px) {
		.grid-div img {
			width: 100%;
			height: 100%;
		}
		.grid {
			width: 100%;
			grid-template-columns: repeat(1, 1fr);
		}
	}
	@media screen and (max-width: 460px) {
		.jconfirm .jconfirm-box-container {
			width: 90%;
    		margin: auto;
		}
	}
</style>
