<?php

if(isset($_POST['action'])){
	do_action( 'action_calc_form', $_POST );
}
?>
<section class="package">
	<div class="container">
		<div class="row">
			<h2><span>Выберите свой пакет перевода</span></h2>
		</div>
		<div class="row ch-grid">
			<div class="col-md-4 ch-item" data-id="0">
				<div class="package_item color_one">
					<p class="name">"Стандартный"</p>
					<div class="wrap_package_img">
						<img class="package_img" src="<?php bloginfo('template_url');?>/img/package_1.gif" alt="Тариф стандартный">
					</div>
					<p class="desc">Шаблонные документы от 350 руб. за страницу</p>
					<a href="#" class="order">Заказать</a>
				</div>
			</div>
			<div class="col-md-4 ch-item active" data-id="1">
				<div class="package_item color_too">
					<p class="name">"Профессиональный"</p>
					<div class="wrap_package_img">
						<img class="package_img" src="<?php bloginfo('template_url');?>/img/package_2.gif" alt="Тариф профессиональный">
					</div>
					<p class="desc">Профессиональная и техническая лексика от 380 руб. за страницу</p>
					<a href="#" class="order">Заказать</a>
				</div>
			</div>
			<div class="col-md-4 ch-item" data-id="2">
				<div class="package_item color_tree">
					<p class="name">"Премиум"</p>
					<div class="wrap_package_img">
						<img class="package_img" src="<?php bloginfo('template_url');?>/img/package_3.gif" alt="Тариф профессиональный">
					</div>
					<p class="desc">Экспертный перевод + корректировка + верстка от 710 руб. за страницу</p>
					<a href="#" class="order">Заказать</a>
				</div>
			</div>
		</div>
	</div>
</section><!-- .package -->
<section class="calculator">
	<div class="container">
		<div class="row">
			<h2>Расчитать стоимость перевода</h2>
		</div>
		<div class="row">
			<form id="calk" action="/" method="post" enctype="multipart/form-data">
				<div class="col-md-1"></div>
				<div class="col-md-4">
					<div class="form_item_input">
						<label>Кол-во страниц</label>
						<input id="pages" type="number" placeholder="Кол-во страниц" min="1" value="1" name="pages" >
					</div><!-- .form_item -->
					<div class="form_item_input small">
						<label>Язык оригинала:</label>
						<select class="select" id="transfrom" name="transfrom">
							<?php $price = new WP_Query( array('posts_per_page' => '-1', 'post_type' => 'price_origin', 'order' => 'ASC') ); ?>
							<?php if($price->have_posts()) : ?>
								<?php global $post; ?>
								<?php if($price->have_posts()) : while ($price->have_posts()) : $price->the_post(); ?>
									<option <?php if(get_post_meta( $post->ID, 'select', 1 ) == 1) echo 'selected'?> value="<?php the_title(); ?>" data-price="<?php echo get_post_meta( $post->ID, 'standart', 1 ); ?>|<?php echo get_post_meta( $post->ID, 'professional', 1 ); ?>|<?php echo get_post_meta( $post->ID, 'premium', 1 ); ?>"><?php the_title(); ?></option>
								<?php endwhile; ?>
								<?php endif; ?>
							<?php endif; ?>
						</select>
					</div><!-- .form_item -->
					<div class="form_item_input small">
						<label>Язык перевода:</label>
						<select class="select" id="transto" name="transto">
							<?php $price = new WP_Query( array('posts_per_page' => '-1', 'post_type' => 'price_translation', 'order' => 'ASC') ); ?>
							<?php if($price->have_posts()) : ?>
								<?php global $post; ?>
								<?php if($price->have_posts()) : while ($price->have_posts()) : $price->the_post(); ?>
									<option <?php if(get_post_meta( $post->ID, 'select_too', 1 ) == 1) echo 'selected'?> value="<?php the_title(); ?>" data-price="<?php echo get_post_meta( $post->ID, 'standart', 1 ); ?>|<?php echo get_post_meta( $post->ID, 'professional', 1 ); ?>|<?php echo get_post_meta( $post->ID, 'premium', 1 ); ?>"><?php the_title(); ?></option>
								<?php endwhile; ?>
								<?php endif; ?>
							<?php endif; ?>
						</select>
					</div><!-- .form_item -->
					<div class="form_item">
						<input id="notarial" type="checkbox" name="notarial" >
						<label for="notarial">Нотариальное заверение</label>
					</div><!-- .form_item -->
					<div class="form_item">
						<input id="verstka" type="checkbox" name="verstka" >
						<label for="verstka">Верстка</label>
					</div><!-- .form_item -->
					<div id="kalk" class="form_item">
						<p>
							Стоимость
							<span id="variant">профессионального</span>
							перевода:<br/>
								<input class="price_name" type="text" name="price_calk" disabled>
							руб
						</p>
					</div>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<div class="application">
						<input type="text" id="fistName" name="first_name" placeholder="Введите Ваше имя">
						<input type="text" id="phone" name="phone" placeholder="Введите Ваш телефон">
						<input type="text" id="email" name="email" placeholder="Введите Ваше e-mail">
						<div class="file_upload_3">
							<button class="button_3" type="button">Обзор</button>
							<div class="div_3">Загрузить файл</div>
							<?php wp_nonce_field( 'upload_calc', 'fileup_nonce' ); ?>
							<input class="input_3" type="file" name="upload_calc">
						</div>
						<a id="add_comm_3" href="#">Добавить комментарий</a>
						<div class="wrap-comment_3">
							<textarea name="comment" id="t_comm" cols="27" rows="2" placeholder="Ваш комментарий"></textarea>
						</div>
						<input name="to_send" type="submit" id="to_send" class="submit button" value="<?php _e( 'Отправить', 'calcu_translate' ); ?>" />
						<?php wp_nonce_field( 'to_send' ) ?>
						<input name="action" type="hidden" id="action" value="true" />
						<input name="price" type="hidden" id="price" value="true" />
					</div><!-- .application -->
				</div>
				<div class="col-md-1"></div>
			</form>
		</div>
		<div class="row">
			<div class="col-md-12">
				<a href="#" class="donwload">Скачать подробный прайс по всем языкам</a>
			</div>
		</div>
	</div>
</section><!-- .calculator -->