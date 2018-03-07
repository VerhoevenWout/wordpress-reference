<?php

namespace muller;

/**
 * Intialise the theme
 *
 * All classes and hook are intiaded to let the wordpress funciton with the theme.
 *
 */
class homehelper {

	public function __construct($theme){

		$this->theme = $theme;

	}


	public function getlayout(){
		$layouts = [];

		while ( have_rows('home_layout') ) : the_row();
			$layouts[] = $this->{get_row_layout()}();

		endwhile;

		return $layouts;
	}

	public function afbeelding_1(){

		$class = '';
		if(get_sub_field('full_width')){
			$class = 'collapse';
		}

		$layout = '<article class="afbeelding_1 row '.$class.' "><div class="columns small-12">';

		if(get_sub_field('link')){
			$blank = get_sub_field('blank') ? 'target="_blank"' : '';
			$layout .= '<a '.$blank.' href="'.get_sub_field('link').'">';
		}

		$layout .= $this->getpicture(get_sub_field('afbeelding_mobile'),get_sub_field('afbeelding'), get_sub_field('alt'));

		if(get_sub_field('tekst_mobiel')):
		$layout .= '<div class="html">'.get_sub_field('tekst_mobiel').'</div>';
		endif;


		if(get_sub_field('link')){
			$layout .= '</a>';
		}
		

		$layout .= '</div></article>';

		return $layout;
	}

	public function afbeelding_3(){

		$class = '';
		if(get_sub_field('full_width')){

			$class = ' collapse ';

		}
		if(get_sub_field('mirror')){

			$class = ' mirror ';

		}

		$layout = '<article class="afbeelding_3 row '.$class.' ">';

		//Afbeelding groot
		$layout .= '<div class="columns small-12 large-8">';

		if(get_sub_field('link_1')){
			$blank = get_sub_field('blank_1') ? 'target="_blank"' : '';
			$layout .= '<a '.$blank.' href="'.get_sub_field('link_1').'">';
		}

		if(get_sub_field('afbeelding_1')):
		$layout .= $this->getpicture(get_sub_field('afbeelding_1_mobile'),get_sub_field('afbeelding_1'), get_sub_field('alt_1'));
		endif;
		$noimage = get_sub_field('afbeelding_1') ? '' : 'noimage';
		$layout .= '<div class="html '.$noimage.' " style="background-color: '.get_sub_field('html_kleur_1').';">'.get_sub_field('html_tekst_1').'</div>';

		if(get_sub_field('link_1')){
			$layout .= '</a>';
		}

		$layout .= '</div>';

		$layout .= '<div class="columns small-12 large-4"><div class="row ">';

		//Afbeeldingen klein 
		for ($i=2; $i < 4; $i++) { 
			$layout .= '<div class="columns small-6 large-12">';

			if(get_sub_field('link_'.$i)){
				$blank = get_sub_field('blank_'.$i) ? 'target="_blank"' : '';
				$layout .= '<a '.$blank.' href="'.get_sub_field('link_'.$i).'">';
			}

			if(get_sub_field('afbeelding_'.$i)):
			$layout .= $this->getpicture(get_sub_field('afbeelding_'.$i.'_mobile'),get_sub_field('afbeelding_'.$i), get_sub_field('alt_'.$i));
			endif;
			$noimage = get_sub_field('afbeelding_'.$i) ? '' : 'noimage';
			$layout .= '<div class="html '.$noimage.'  " style="background-color: '.get_sub_field('html_kleur_'.$i).';">'.get_sub_field('html_tekst_'.$i).'</div>';

			if(get_sub_field('link_'.$i)){
				$layout .= '</a>';
			}

			$layout .= '</div>';
		}

		$layout .= '</div></div></article>';

		return $layout;
	}

	public function afbeelding_2(){

		$class = '';
		if(get_sub_field('full_width')){
			$class .= ' collapse ';
		}

		if(get_sub_field('mirror')){
			$class .= ' mirror ';
		}

		if(get_sub_field('2_3_verhouding')){
			$class .= ' verhouding23 ';
			$collumclasses = [
				1 => 'small-12 large-8',
				2 => 'small-12 large-4'
			];
		}else{
			$class .= ' verhouding50 ';
			$collumclasses = [
				1 => 'small-6',
				2 => 'small-6'
			];
		}

		$layout = '<article class="afbeelding_2 row '.$class.' ">';

		//Afbeeldingen klein 
		for ($i=1; $i < 3; $i++) { 

			$htmlclass = get_sub_field('html_tekst_onder_'.$i) ? 'htmlonder' : '';
			$htmlclass .= get_sub_field('padding_'.$i) ? ' padding' : '';

			$layout .= '<div class="columns '.$collumclasses[$i].' '.$htmlclass.'">';

			if(get_sub_field('link_'.$i)){
				$blank = get_sub_field('blank_'.$i) ? 'target="_blank"' : '';
				$layout .= '<a '.$blank.' href="'.get_sub_field('link_'.$i).'">';
			}

			if(get_sub_field('afbeelding_'.$i)):
			$layout .= $this->getpicture(get_sub_field('afbeelding_'.$i.'_mobile'),get_sub_field('afbeelding_'.$i), get_sub_field('alt_'.$i));
			endif;
			$noimage = get_sub_field('afbeelding_'.$i) ? '' : 'noimage';
			$layout .= '<div class="html '.$noimage.' " style="background-color: '.get_sub_field('html_kleur_'.$i).';" >'.get_sub_field('html_tekst_'.$i).'</div>';

			if(get_sub_field('link_'.$i)){
				$layout .= '</a>';
			}

			$layout .= '</div>';
		}

		$layout .= '</article>';

		return $layout;
	}
	
	public function getpicture($mobile, $normal, $alt){

		$picture = '<picture>

                    <source media="(max-width: 60em)" type="image/jpg"
                srcset="'.$mobile.'">

                    <source media="(min-width: 60em)" type="image/jpg"
                srcset="'.$normal.'">

                    <img src="'.$normal.'" alt="'.$alt.'">

                </picture>';

        return $picture;

	}
	

	public function tekst(){
		$class = '';

		if(get_sub_field('mirror')){
			$class .= ' mirror ';
		}
	
		$layout = '<article class="tekst align-center row '.$class.' ">';

		if(get_sub_field('afbeelding_4')){
			$layout .= '<div class="columns small-12 medium-4"><img src="'.get_sub_field('afbeelding_4').'" ></div>';
			$columns = 'small-12 medium-8 hasimg';
		}else{
			$columns = 'small-12 medium-9';
		}

		$layout .= '<div class="columns wysiwyg '.$columns.'">'.get_sub_field('html_tekst_4').'</div>';

		$layout .= '</article>';

		return $layout;
	}	

	public function iframe(){


		$layout = '<article class="iframe row align-center"><div class="columns small-12">
		<iframe src="'.get_sub_field('iframe_link').'" width="100%" height="'.get_sub_field('iframe_hoogte').'" frameBorder="0"></iframe>
		</div></article>';

		return $layout;
	}
}