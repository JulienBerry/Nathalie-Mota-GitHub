<?php 

/**
 * Template Name: Template Single
 *
 * @package WordPress
 * @subpackage Nathalie Mota Photographe Event
 **/

get_header() ?>

<?php 
// Champs ACF
    $titre = get_field('nom'); 
    $type = get_field('type');
    $annee = get_field('annee');
	$photo_url = get_field('photo');
    $reference = get_field('reference'); 
    $categorie = get_field('categorie'); 
    $format = get_field('format');

// Champs de Taxonomies
    $taxo_categorie = get_the_terms(get_the_ID(), 'categorie'); 
    $taxo_format = get_the_terms(get_the_ID(), 'format'); 
	$taxo_annee = get_the_terms(get_the_ID(), 'annee'); 
	
//Récupération de l'id et de l'url	
	$id = get_the_ID();
    $url = get_permalink();

//Flèches précédent et suivant
	$nextPost = get_next_post();
    $previousPost = get_previous_post();
?>

<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

<div class="container-simple">
    <div  class="informations-photo">
      	<div class="informations"> 
			<h1><?php  echo get_the_title(get_post_thumbnail_id()) ?></h1>
			<p> RÉFÉRENCE :  <span class="reference-photo"><?php echo $reference ?></span></p>
			<p> CATÉGORIE :  <?php echo $taxo_categorie[0]->name ?></p>
			<p> FORMAT :     <?php echo $taxo_format[0]->name ?></p>
			<p> TYPE :       <?php echo $type ?>   </p>
			<p> ANNÉE :      <?php echo $taxo_annee[0]->name ?></p>
			
		</div>
		<div class="affichage-photo">
			<img class ="single-photo"  src="<?php echo $photo_url ?>" alt="<?php the_title_attribute(); ?>">
			<div class="hover-img">
				<img class="hover-fullscreen icon-lightbox" src="<?php echo get_template_directory_uri() .'/assets/images/fullscreen.svg';?>" alt="Icône d'affiche en plein écran"> 
			</div>
		</div>
	</div>
	<div class="contact-menu">
		<div class="container-contact">
			<p> Cette photo vous intéresse ? </p>
			<button type="button" class="button-contact contact-link">Contact</button>
		</div>
		<div class="container-arrows"> 
			<?php 
				$args = array( 
					'post_type' => 'photo',
					'posts_per_page' => 2,
				);
			?>
				<div class="navigation-arrows">

					<?php if (!empty($previousPost)){ ?>
						<div class="container-image-arrows"> 
							<?php echo get_the_post_thumbnail ($previousPost->ID, 'thumbnail', ['class'=>"img-arrows"])?>
						</div>
						<a href="<?php echo get_permalink($previousPost->ID) ?>"><img class="arrow" src="<?php echo get_template_directory_uri() .'/assets/images/arrow_left.svg';?>" alt="Flèche précédent"></a>
					<?php } ?>

					<?php if (!empty($nextPost)){ ?>   
						<a href="<?php echo get_permalink($nextPost->ID) ?>"><img class="arrow" src="<?php echo get_template_directory_uri() .'/assets/images/arrow_right.svg';?>" alt="Flèche suivant"></a>   
					<?php } ?>
				</div>
		</div>
	</div>
	
	<h2> VOUS AIMEREZ AUSSI</h2>

	<div class="container-similar-img">
    <?php
    $imageSimilaire = array(
        'post_type' => 'photo',
        'posts_per_page' => 2,
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie',
                'field' => 'term_id',
                'terms' => $taxo_categorie[0]->term_id,
            ),
        ),
        'post__not_in' => array($id),
        'orderby' => 'rand',
    );

    $query = new WP_Query($imageSimilaire);

    if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
    ?>
				
		<div class ="container-similar-photo" >
			<?php get_template_part('/templates-part/photo-block'); ?>
		</div>
				
		<?php endwhile;
		else :
			$response = 'Il n\'y a pas de photos similaires dans cette catégorie.';
			echo $response;
		endif;
		wp_reset_postdata();
		?>
	
	</div>
	
	<div class="container-all">
		<button class="button-single" type="button" onclick="window.location.href='<?php echo home_url(); ?>'"> Toutes les photos </button> 
	</div>
</div>

<?php endwhile; endif ?> 

<?php get_footer() ?>