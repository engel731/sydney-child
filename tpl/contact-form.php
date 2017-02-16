<?php
/*
	Template Name: Contact Form
*/
?>

<?php 
	if(isset($_POST['submitted'])) {
		//Check to make sure that the title field is not empty
		if(trim($_POST['title']) === '') {
			$titleError = 'Indiquez un titre';
			$hasError = true;
		} else {
			$title = trim($_POST['title']);
		}

		//Check to make sure that the name field is not empty
		if(trim($_POST['name']) === '') {
			$nameError = 'Indiquez votre nom';
			$hasError = true;
		} else {
			$name = trim($_POST['name']);
		}

		if(trim($_POST['date']) === '') {
			$dateError = 'Indiquez une date';
			$hasError = true;
		} else if (!strptime($_POST['date'], "d.m.Y")) {
			$dateError = 'Le format(JJ/MM/AA) de la date est incorect';
		    $hasError = true;
		} else {
			$date = trim($_POST['date']);
		}

		//Check to make sure sure that a valid date address is submitted
		if(trim($_POST['mail']) === '')  {
			$mailError = 'Indiquez une e-mail valide';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['mail']))) {
			$mailError = 'Adresse e-mail invalide.';
			$hasError = true;
		} else {
			$mail = trim($_POST['mail']);
		}

		if(trim($_POST['nation']) === '') {
			$nationError = 'Indiquez votre Nationalité';
			$hasError = true;
		} else {
			$nation = trim($_POST['nation']);
		}

		//Check to make sure comments were entered	
		if(trim($_POST['content']) === '') {
			$contentError = 'Entrez votre message';
			$hasError = true;
		} else if (function_exists('stripslashes')) {
			$content = stripslashes(trim($_POST['content']));
		} else {
			$content = trim($_POST['content']);
		}

		//Check to see if the honeypot captcha field was filled in
		if(isset($_POST['resident']) && $_POST['resident'] == true) {
			$resident = $_POST['resident'];
		}

		//If there is no error, send the email
		if(!isset($hasError)) {
			$emailTo = get_bloginfo('admin_email');
			$subject = 'Formulaire de contact de '.$name;
			
			$body = "Titre: $title \n\n Nom: $name \n\nDate: $date \n\nNationalit&eacute; : $nation \n\nEmail: $mail \n\nMessage: $content \n\n R&eacute;sident : $resident";

			$headers = 'De : '.get_bloginfo('name').' <'.$emailTo.'>' . "\r\n" . 'R&eacute;pondre &agrave; : ' . $email;
			
			mail($emailTo, $subject, $body, $headers);
			$emailSent = true;
		}
	}
?>

<?php get_header(); ?>

<?php if(isset($emailSent) && $emailSent == true) : ?>

	<div id="primary" class="fp-content-area col-md-12">
		<main id="main" class="site-main" role="main">
			<div class="entry-content">
				<header class="entry-header">
					<h3>Merci, <?=$name;?></h3>
				</header><!-- .entry-header -->
				
				<div class="entry-post">
					<p>Votre e-mail a &eacute;t&eacute; envoy&eacute; avec succ&egrave;s. Vous recevrez une r&eacute;ponse sous peu.</p>
				</div>
			</div><!-- .entry-content -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php else : ?>

	<?php if (have_posts()) : ?>

		<div id="primary" class="fp-content-area col-md-6">
			<main id="main" class="site-main" role="main">
				<div class="entry-content">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</div><!-- .entry-content -->
			</main><!-- #main -->
		</div><!-- #primary -->
		
		<div id="secondary" class="widget-area col-md-6" role="formulaire de contact">
			<form action="<?php the_permalink(); ?>" method="post" class="form-horizontal">
				<div class="form-group">
				    <legend>Formulaire de contact</legend>
				    <!--  Formulaire  -->
					<?php if(isset($hasError)) : ?>
						<p class="help-block">Une erreur est survenue lors de l'envoi du formulaire.</p>
					<?php endif; ?>
				</div>
				
				<div class="row">
					<div class="form-group">
						<label for="text" class="col-lg-5 control-label">Titre du message : </label>
						
						<div class="col-lg-7">
							<input name="title" type="text" class="form-control" id="text">
							<?php if($titleError != '') : ?>
								<span class="help-block"><?php echo $titleError; ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="name" class="col-lg-5 control-label">Votre nom : </label>
						
						<div class="col-lg-7">
							<input name="name" type="text" class="form-control" id="name">
							<?php if($nameError != '') : ?>
								<span class="help-block"><?php echo $nameError; ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="date" class="col-lg-5 control-label">Votre date de naissance : </label>
						
						<div class="col-lg-7">
							<input name="date" type="date" class="form-control" id="date">
							<?php if($dateError != '') : ?>
								<span class="help-block"><?php echo $dateError; ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="mail" class="col-lg-5 control-label">Votre e-mail : </label>
						
						<div class="col-lg-7">
							<input name="mail" type="email" class="form-control" id="mail">
							<?php if($mailError != '') : ?>
								<span class="help-block"><?php echo $mailError; ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="select" class="col-lg-5 control-label">Nationalité : </label>
						
						<div class="col-lg-7">
							<select name="nation" id="select" class="form-control" >
								<option value="france">Française</option>
								<option value="americain">Americaine</option>
								<option value="allemand">Allemande</option>
								<option value="espagne">Espagnole</option>
								<option vaelu="anglais">Britannique</option>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="textarea">Message : </label>
					<textarea name="content" id="textarea" type="textarea" class="form-control"></textarea>
					<?php if($contentError != '') : ?>
						<span class="help-block"><?php echo $contentError; ?></span>
					<?php endif; ?>
				</div>

				<div class="checkbox">
					<label>
						<input name="resident" type="checkbox"> Résident de la ville
					</label>
				</div>
				
				<input type="hidden" name="submitted" value="true" />
				<button type="submit">Envoyer</button>
			</form>
		</div><!-- #secondary -->
		
	<?php endif; ?>
<?php endif; ?>

<?php get_footer(); ?>